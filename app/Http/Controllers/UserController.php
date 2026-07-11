<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['auth','openParentRegisterForm', 'openParentRegister']);

        $this->middleware(function ($request, $next) {
            if (in_array($request->route()?->getName(), ['parents.register.children.form', 'parents.register.children'])) {
                return $next($request);
            }

            if (in_array($request->route()?->getName(), ['users.profile.edit', 'users.profile.update', 'users.me', 'parents.register.form', 'parents.register'])) {
                return $next($request);
            }
            if(Auth::user()){
                if (Auth::user()->role !== 'admin') {
                    abort(403, 'Access denied. Admin only.');
                }
            }
            Controller::getVerse();

            return $next($request);
        });
    }

    public function login()
    {
        return view('login');
    }

    public function auth(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if(Auth::attempt($credentials)) {
            if(Auth::user()->is_active == 0) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is deactivated. Please contact the administrator.']);
            }
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function index()
    {
        $users = User::latest()->get();
        $setting = Controller::getVerse();
        return view('users.index', compact('users', 'setting'));
    }

    public function create()
    {
        $setting = Controller::getVerse();
        $parents = User::where('role', 'parent')->get();
        return view('users.form', compact('setting', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required',
            'role' => 'required|in:admin,teacher,parent,student',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        return redirect()->route('users.index')->with('success', "User {$user->name} created.");
    }

    public function edit(User $user)
    {
        $setting = Controller::getVerse();
        $parents = User::where('role', 'parent')->get();
        return view('users.form', compact('user', 'setting', 'parents'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,teacher,parent,student',
            'phone_number' => 'required',
            'is_active' => 'boolean',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->phone_number = $request->phone_number;
        $user->is_active = $request->is_active ? $request->is_active : 0;

        if($request->parent_id && $request->parent_id > 0){
            $user->is_active = $request->parent_id;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', "User {$user->name} updated.");
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    public function logout() {
        if (!Auth::user()) return response(json_encode(["Message" => "You're not logged in"]), 401);
        Auth::logout();

        $result['message'] = "User Logged Out";
        return response(json_encode($result), 200);
    }

    public function changepassword(User $user) {
        $setting = Setting::first();
        return view('users.changepassword', compact('user', 'setting'));
    }

    public function updatepassword(User $user, Request $request) {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->route('users.index')->with('success', "User {$user->name} password updated.");
    }

    public function storeToken(Request $request) {
        Auth::user()->update(['device_key'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }
  
    
}