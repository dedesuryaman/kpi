<?php

namespace App\Http\Controllers\Api;  

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectSubTask;

class HomeController extends Controller
{
	public function index(){
		
		return ApiResponse::success([
            'profile' => Auth::user(),
			'approved_project' => 0,
			'on_progress_project' => 0,
			'completed_project' => 0,
        ], 'Home data');
		
	}
}