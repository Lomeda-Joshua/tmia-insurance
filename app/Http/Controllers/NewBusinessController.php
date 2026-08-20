<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewBusinessController extends Controller
{
    public function index(){
        return view('main.new_business');
    }
}
