<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminBaseController;

class AdminHomeController extends AdminBaseController
{
	public function index(){
		$title = 'Админпанель';
		return view('admin.dashboard', compact('title'));
	}
}
