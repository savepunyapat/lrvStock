<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackendController extends Controller
{
    /*public function blank()
    {
        return view('backend.pages.blank');
    }
    public function login(){
        return view('backend.pages.login');
    }
    public function register(){
        return view('backend.pages.register');
    }
    public function forgotpass(){
        return view('backend.pages.forgotpass');
    }*/
    public function dashboard(){
        return view('backend.pages.dashboard');
    }

    public function blank(){
        return view('backend.pages.blank');
    }

    public function logout(){
        return redirect('login');
    }

    public function reports(){
        return "Reports";
    }

    public function users(){
        return "Users";
    }

    public function settings(){
        return "Settings";
    }

    public function nopermission(){
        return view('backend.pages.nopermission');
    }
}
