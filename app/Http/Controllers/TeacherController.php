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
            'color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')
                ->store('profile-pictures', 'public');

            $user->profile_path = $path;
        }

        if ($request->filled('color')) {
            $user->color = $request->color;
        }

        $user->save();

        return back()->with('success', 'Data has been updated');
    }

    public function schedule(){
        $setting = Controller::getVerse();

        return view('teacher.schedule.index', compact('setting'));
    }
}
