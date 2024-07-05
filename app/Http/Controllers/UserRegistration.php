<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserRegistration extends Controller
{
    public function index()
    {
        return view('jambasangsang.frontend.registration.index');
    }
}
