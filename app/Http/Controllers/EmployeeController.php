<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use PhpParser\Node\Expr\FuncCall;

class EmployeeController extends Controller
{
    public function index()
    {
        $departments = \App\Models\Department::all();
        $divisions = \App\Models\Division::all();

        return view('employees.index', compact('departments', 'divisions'));
    }

    public function data(Request $request)
    {
        $query = Employee::query()
            ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
            ->leftJoin('divisions', 'departments.division_id', '=', 'divisions.id')
            ->select(
                'employees.*',
                'departments.name as department_name',
                'divisions.name as division_name'
            );

        // 🔍 SEARCH GLOBAL
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('employees.employee_code', 'like', "%{$search}%")
                    ->orWhere('employees.name', 'like', "%{$search}%")
                    ->orWhere('departments.name', 'like', "%{$search}%")
                    ->orWhere('divisions.name', 'like', "%{$search}%");
            });
        }

        // 🏢 FILTER DEPARTMENT
        if ($request->department_id) {

            $query->where('employees.department_id', $request->department_id);
        }

        // 📄 PAGINATION (WAJIB untuk UI kamu)
        $perPage = $request->per_page ?? 10;

        $employees = $query
            ->orderBy('employees.id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'data' => $employees->items(),
            'total' => $employees->total(),
            'current_page' => $employees->currentPage(),
            'last_page' => $employees->lastPage(),
            'per_page' => $employees->perPage(),
        ]);
    }

    //CREATE
    public function create()
    {

        return view('employees.create', [

            'employees' => Employee::query()
                ->orderBy('name')
                ->get(),

            'departments' => Department::orderBy('name')->get(),

            'positions' => Position::orderBy('name')->get(),

            'roles' => Role::orderBy('name')->get(),



        ]);
    }

    //use Illuminate\Support\Facades\DB;
    //use Illuminate\Support\Facades\Hash;
    //use Illuminate\Support\Facades\Storage;

    public function store(Request $request)
    {
        $messages = [
            'employee_code.required' => 'Employee Code is required.',
            'employee_code.unique'   => 'This Employee Code is already registered.',
            'employee_code.max'      => 'Employee Code may not exceed 50 characters.',

            'name.required' => 'Employee Name is required.',
            'name.max'      => 'Employee Name may not exceed 255 characters.',

            'photo.image' => 'The uploaded file must be a valid image.',
            'photo.mimes' => 'Photo must be in JPG, JPEG, or PNG format.',
            'photo.max'   => 'Photo size may not exceed 2 MB.',

            'religion.required' => 'Religion is required.',
            'religion.in'       => 'The selected Religion is invalid.',

            'email.required' => 'Email is required.',
            'email.email'    => 'Please enter a valid Email.',
            'email.unique'   => 'This Email is already registered.',

            'phone.regex' => 'Phone Number format is invalid.',

            'role.required' => 'Please select a Role.',

            'department_id.required' => 'Please select a Department.',
            'department_id.exists'   => 'The selected Department is invalid.',

            'position_id.required' => 'Please select a Position.',
            'position_id.exists'   => 'The selected Position is invalid.',

            'leader_id.exists' => 'The selected Supervisor is invalid.',

            'join_date.required'        => 'Join Date is required.',
            'join_date.before_or_equal' => 'Join Date cannot be in the future.',

            'employment_status.required' => 'Please select Employment Status.',
            'employment_status.in'       => 'Employment Status is invalid.',

            'salary.required' => 'Salary is required.',
            'salary.numeric'  => 'Salary must be numeric.',
            'salary.min'      => 'Salary cannot be less than 0.',
        ];

        $attributes = [
            'employee_code'     => 'Employee Code',
            'name'              => 'Employee Name',
            'photo'             => 'Employee Photo',
            'religion'          => 'Religion',
            'email'             => 'Email',
            'phone'             => 'Phone Number',
            'role'              => 'Role',
            'department_id'     => 'Department',
            'position_id'       => 'Position',
            'leader_id'         => 'Supervisor',
            'join_date'         => 'Join Date',
            'employment_status' => 'Employment Status',
            'salary'            => 'Salary',
        ];

        $validated = $request->validate([

            'employee_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('employees', 'employee_code'),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'religion' => [
                'required',
                Rule::in([
                    'Islam',
                    'Kristen',
                    'Katolik',
                    'Hindu',
                    'Buddha',
                    'Konghucu',
                ]),
            ],

            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('employees', 'email'),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s()]+$/',
            ],

            'role' => [
                'required',
                Rule::exists('roles', 'name'),
            ],

            'department_id' => [
                'required',
                'exists:departments,id',
            ],

            'position_id' => [
                'required',
                'exists:positions,id',
            ],

            'leader_id' => [
                'nullable',
                'exists:employees,id',
            ],

            'join_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'employment_status' => [
                'required',
                Rule::in([
                    'Permanent',
                    'Contract',
                    'Probation',
                    'Intern',
                ]),
            ],

            'salary' => [
                'required',
                'numeric',
                'min:0',
            ],

        ], $messages, $attributes);

        DB::beginTransaction();

        try {

            // Upload Photo
            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')
                    ->store('employees', 'public');
            }

            // Simpan Employee
            $employee = Employee::create($validated);

            // Buat User
            $user = User::create([
                'employee_id' => $employee->id,
                'name'        => $employee->name,
                'email'       => $employee->email,
                'password'    => Hash::make(config('app.default_password', 'password')),
            ]);

            // Assign Role
            $user->syncRoles($request->role);

            DB::commit();

            return redirect()
                ->route('employees.index')
                ->with('success', 'Employee created successfully.');
        } catch (\Throwable $e) {

            DB::rollBack();

            // Hapus foto jika upload berhasil tetapi proses gagal
            if (!empty($validated['photo']) && Storage::disk('public')->exists($validated['photo'])) {
                Storage::disk('public')->delete($validated['photo']);
            }

            report($e);

            return back()
                ->withInput()
                ->with('error', 'Failed to create employee. Please try again.');
        }
    }

    // EDIT GET DATA
    public function edit($id)
    {
        $employee = Employee::with([
            'department',
            'position',
            'leader',
        ])->findOrFail($id);

        $currentRole = null;

        if ($employee->user) {
            $currentRole = $employee->user->getRoleNames()->first();
        }

        return view('employees.edit', [

            'employee' => $employee,

            'employees' => Employee::where('id', '!=', $id)
                ->orderBy('name')
                ->get(),

            'departments' => Department::orderBy('name')->get(),

            'positions' => Position::orderBy('name')->get(),

            'roles' => Role::orderBy('name')->get(),

            'currentRole' => $currentRole,


        ]);
    }
    // UPDATE
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $user = User::where('employee_id', $employee->id)->first();

        $validated = $request->validate(

            [
                'employee_code' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('employees', 'employee_code')
                        ->ignore($employee->id),
                ],

                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'photo' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png',
                    'max:2048',
                ],

                'religion' => [
                    'nullable',
                    Rule::in([
                        'Islam',
                        'Kristen',
                        'Katolik',
                        'Hindu',
                        'Buddha',
                        'Konghucu',
                    ]),
                ],

                'email' => [
                    'required',
                    'email',
                    'max:150',
                    Rule::unique('employees', 'email')->ignore($employee->id),
                    Rule::unique('users', 'email')->ignore($user?->id),
                ],

                'phone' => [
                    'nullable',
                    'string',
                    'max:20',
                    'regex:/^[0-9+\-\s()]+$/',
                ],
                'address' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

                'birth_place' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

                'birth_date' => [
                    'nullable',
                    'date',
                    'before_or_equal:today',
                ],

                'role' => [
                    'required',
                    Rule::exists('roles', 'name'),
                ],


                'department_id' => [
                    'required',
                    'exists:departments,id',
                ],

                'position_id' => [
                    'required',
                    'exists:positions,id',
                ],

                'leader_id' => [
                    'nullable',
                    'exists:employees,id',
                    'different:id',
                ],

                'join_date' => [
                    'required',
                    'date',
                    'before_or_equal:today',
                ],

                'employment_status' => [
                    'required',
                    Rule::in([
                        'Permanent',
                        'Contract',
                        'Probation',
                        'Intern',
                    ]),
                ],

                'salary' => [
                    'required',
                    'numeric',
                    'min:0',
                ],
            ],

            // Custom Messages
            [

                'employee_code.required' => 'Employee Code is required.',
                'employee_code.unique'   => 'This Employee Code is already registered.',
                'employee_code.max'      => 'Employee Code may not exceed 50 characters.',

                'name.required' => 'Employee Name is required.',
                'name.max'      => 'Employee Name may not exceed 255 characters.',

                'photo.image' => 'The uploaded file must be a valid image.',
                'photo.mimes' => 'Photo must be in JPG, JPEG, or PNG format.',
                'photo.max'   => 'Photo size may not exceed 2 MB.',


                'religion.required' => 'Please select an Religion.',
                'religion.in'       => 'The selected Religion is invalid.',

                'address.max' => 'Address Place may not exceed 100 characters.',

                'birth_place.max' => 'Birth Place may not exceed 100 characters.',

                'birth_date.date' => 'Please enter a valid Birth Date.',
                'birth_date.before_or_equal' => 'Birth Date cannot be in the future.',

                'email.required' => 'Email is required.',
                'email.unique'   => 'This Email is already registered.',

                'role.required' => 'Role is required.',


                'department_id.required' => 'Please select a Department.',
                'department_id.exists'   => 'The selected Department is invalid.',

                'position_id.required' => 'Please select a Position.',
                'position_id.exists'   => 'The selected Position is invalid.',

                'leader_id.exists'    => 'The selected Supervisor is invalid.',
                'leader_id.different' => 'An employee cannot be assigned as their own Supervisor.',

                'join_date.required'              => 'Join Date is required.',
                'join_date.date'                  => 'Please enter a valid Join Date.',
                'join_date.before_or_equal'       => 'Join Date cannot be in the future.',

                'employment_status.required' => 'Please select an Employment Status.',
                'employment_status.in'       => 'The selected Employment Status is invalid.',

                'salary.required' => 'Salary is required.',
                'salary.numeric'  => 'Salary must be a valid number.',
                'salary.min'      => 'Salary cannot be less than 0.',
            ],

            // Friendly Attribute Names
            [
                'employee_code'     => 'Employee Code',
                'name'              => 'Employee Name',
                'photo'             => 'Employee Photo',
                'department_id'     => 'Department',
                'position_id'       => 'Position',
                'leader_id'         => 'Supervisor',
                'join_date'         => 'Join Date',
                'employment_status' => 'Employment Status',
                'salary'            => 'Salary',
                'address'           => 'Address',
                'birth_place'       => 'Birth Place',
                'birth_address'     => 'Birth Address',
            ]

        );

        // Leader tidak boleh dirinya sendiri
        if (
            !empty($validated['leader_id']) &&
            $validated['leader_id'] == $employee->id
        ) {

            return back()
                ->withErrors([
                    'leader_id' => 'Employee cannot be their own leader.'
                ])
                ->withInput();
        }

        DB::beginTransaction();

        try {


            if ($request->hasFile('photo')) {

                if (
                    $employee->photo &&
                    Storage::disk('public')->exists($employee->photo)
                ) {

                    Storage::disk('public')->delete($employee->photo);
                }

                $validated['photo'] = $request
                    ->file('photo')
                    ->store('employees', 'public');
            }


            $employee->update($validated);

            $user = User::firstOrCreate(
                [
                    'employee_id' => $employee->id,
                ],
                [
                    'name'     => $employee->name,
                    'email'    => $employee->email,
                    'password' => Hash::make(config('app.default_password', 'password')),
                ]
            );

            $user->name = $employee->name;
            $user->email = $employee->email;
            $user->save();
            // Assign Role
            $user->syncRoles($request->role);

            DB::commit();

            return redirect()
                ->route('employees.index')
                ->with('success', 'Employee updated successfully.');
        } catch (\Throwable $e) {

            DB::rollBack();

            report($e);

            return back()
                ->withInput()
                ->with('error', 'Failed to update employee. Please try again.');
        }
    }
    // DELETE
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'message' => 'Employee deleted'
        ]);
    }
}
