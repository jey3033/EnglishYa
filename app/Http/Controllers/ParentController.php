<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ParentController extends Controller
{
    public function index() {
        $setting = Controller::getVerse();
        $children = User::where('parent_id', Auth::user()->id)->get();
        return view('parent.index', compact('setting', 'children'));
    }

    // child management section
    public function childindex() {
        $setting = Controller::getVerse();
        $children = User::where('parent_id', Auth::user()->id)->get();
        return view('parent.child.index', compact('setting', 'children'));
    }

    public function childcreate(){
        $setting = Controller::getVerse();

        return view('parent.child.form', compact('setting'));
    }

    public function childstore(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'student',
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'parent_id' => Auth::user()->id,
            'is_active' => false,
        ]);

        return redirect()->route('parent.child.index')->with('success', "Children {$user->name} registered");
    }

    public function childedit(User $child){
        $setting = Controller::getVerse();
        return view('parent.child.form', compact('setting', 'child'));
    }

    public function childupdate(User $child, Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required'
        ]);

        $child::update($request);

        return redirect()->route('parent.child.index')->with('success', "Children {$child->name}'s data updated");
    }

    public function childdestroy(User $child){
        $child->delete();

        return redirect()->route('parent.child.index')->with('success', 'User deleted.');
    }

    public function childchangepassword(User $child){
        $setting = Controller::getVerse();
        return view('parent.child.changepassword', compact('setting', 'child'));
    }

    public function updatepassword(User $child, Request $request) {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $child->password = Hash::make($request->password);

        $child->save();

        return redirect()->route('parent.child.index')->with('success', "Children {$child->name}'s password updated.");
    }
}
