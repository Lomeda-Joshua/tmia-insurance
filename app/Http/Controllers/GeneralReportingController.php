<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralReportingController extends Controller
{
    public function index(){
        return view('livewire.main.report.newbusiness_renewal_report');
    }

    public function show(){
        
    }
}
