<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function blank()
    {
        return view('frontend.pages.blank');
    }
    public function login(){
        return view('frontend.pages.login');
    }
    public function register(){
        return view('frontend.pages.register');
    }
    public function forgotpass(){
        return view('frontend.pages.forgotpass');
    }
}
