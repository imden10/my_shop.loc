<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Auth;

class AdminBaseController extends Controller
{
    protected $user;

    public function getUser(){
        $user = false;
        if($this->user){
            $user = $this->user;
        }else{
            $user = $this->user = Auth::user();
        }
        return $user;
    }

	public function __construct(){

	    /*Язык в админке по дефолту*/
	    if(!Session::has('alang'))
            Session::put('alang','ru');

        view()->share([

        ]);
    }
}
