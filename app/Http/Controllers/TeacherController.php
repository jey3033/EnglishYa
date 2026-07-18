<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function index(){
        $setting = Controller::getVerse();

        return view('teacher.dashboard', compact('setting'));
    }

    public function mydata(){
        $setting = Controller::getVerse();
        return view('teacher.mydata', compact('setting'));
    }

    public function update(Request $request){
        $data = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')
                ->store('profile-pictures', 'public');
        }

        if (isset($path)) {
            Auth::user()->update(['profile_path' => $path]);
        }

        return back()->with('success', "data has been updated");
    }

    public function schedule(){
        $setting = Controller::getVerse();

        return view('teacher.schedule.index', compact('setting'));
    }
}
