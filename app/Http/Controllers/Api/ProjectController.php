<?php

namespace App\Http\Controllers\Api;  

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;

class ProjectController extends Controller
{

	public function index(Request $request){
		$user = $request->user()->load('roles');
		$userId = $user->id;
		
		//keseluruhan....
		$user = User::with([
			'roles',
			'projectMembers.project'
		])->findOrFail($userId);
		//$projects = $user->projectMembers->pluck('project')->unique('id')->values();
		
		
		$userId = Auth::user()->id;

		$projects = Project::whereHas('projectMembers.memberUsers', function ($q) use ($userId) {
				$q->where('user_id', $userId);
			})->with('tasks')->with('documents')
			->simplePaginate(10);


		//
		return ApiResponse::success(
			[	
				//'user' => $user,
				'projects' => $projects
			], 'Dashboard data');
	}
}