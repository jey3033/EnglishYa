<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){
        $setting = Controller::getVerse();
        return view('student.dashboard', compact('setting'));
    }
}
