<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('employee')->id;

        return [
            'employee_code' => "required|string|max:50|unique:employees,employee_code,$id",
            'name' => 'required|string|max:150',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'leader_id' => 'nullable|exists:employees,id',
            'join_date' => 'nullable|date',
            'employment_status' => 'required|in:permanent,contract,probation,intern,resigned',
            'salary' => 'required|numeric|min:0',
        ];
    }
}
