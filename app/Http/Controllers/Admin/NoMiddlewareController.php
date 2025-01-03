<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class NoMiddlewareController extends Controller
{
    public function screenlock($currtime,$id,$randnum)
  	{
    	Auth::logout();
    	return View('admin.screen-lock', compact('id'));
  	}

  	public function needhelp()
  	{
    	return View('admin.need-help');
  	}
}
