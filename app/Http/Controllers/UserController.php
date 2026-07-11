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
            if(!Setting::first() || Setting::first()->updated_at->isToday() === false) {
                $message = Http::get('https://bible-api.com/data/kjv/random/rom,1co,2co,gal,eph,php,col,1th,2th,1ti,2ti,tit,phm,heb,jas,1pe,2pe,1jn,2jn,3jn')->json();
                $Setting = Setting::first() ?? new Setting();
                $Setting->verse = $message['random_verse']['text'];
                $Setting->verse_reference = "{$message['random_verse']['book']} {$message['random_verse']['chapter']}:{$message['random_verse']['verse']}";
                $Setting->updated_at = now();
                $Setting->save();
            }

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
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,teacher,parent,student',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        return redirect()->route('users.index')->with('success', "User {$user->name} created.");
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,teacher,parent,student',
            'password' => 'nullable|string|min:6|confirmed',
            'is_active' => 'required|boolean',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->is_active = $request->is_active;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', "User {$user->name} updated.");
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    public function parentRegisterChildrenForm()
    {
        abort_if(Auth::user()->role !== 'parent', 403);
        return view('users.parent_register');
    }

    public function parentRegisterChildren(Request $request)
    {
        abort_if(Auth::user()->role !== 'parent', 403);

        $request->validate([
            'child_name' => 'required|string|max:255',
            'child_email' => 'required|email|unique:users,email',
            'child_password' => 'required|string|min:6|confirmed',
        ]);

        $child = User::create([
            'name' => $request->child_name,
            'email' => $request->child_email,
            'role' => 'student',
            'password' => Hash::make($request->child_password),
            'is_active' => true,
        ]);

        return redirect()->route('users.index')->with('success', "Child account {$child->name} created.");
    }

    public function openParentRegisterForm()
    {
        return view('users.parent_register_open');
    }

    public function openParentRegister(Request $request)
    {
        $request->validate([
            'parent_name' => 'required|string|max:255',
            'parent_email' => 'required|email|unique:users,email',
            'parent_password' => 'required|string|min:6|confirmed',
            'child_name' => 'required|string|max:255',
            'child_email' => 'required|email|unique:users,email',
            'child_password' => 'required|string|min:6|confirmed',
        ]);

        $parent = User::create([
            'name' => $request->parent_name,
            'email' => $request->parent_email,
            'role' => 'parent',
            'password' => Hash::make($request->parent_password),
            'is_active' => true,
        ]);

        $child = User::create([
            'name' => $request->child_name,
            'email' => $request->child_email,
            'role' => 'student',
            'password' => Hash::make($request->child_password),
            'is_active' => true,
        ]);

        return redirect()->route('login')->with('success', "Parent {$parent->name} and child {$child->name} accounts created. Please log in.");
    }

    public function editProfilePictureForm()
    {
        return view('users.profile_picture');
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $user->profile_path = '/images/' . $imageName;
        $user->save();

        return back()->with('success', 'Profile picture updated.');
    }


    public function logout() {
        if (!Auth::user()) return response(json_encode(["Message" => "You're not logged in"]), 401);
        Auth::logout();

        $result['message'] = "User Logged Out";
        return response(json_encode($result), 200);
    }

    public function create_user() {
        try {
            $name = $_POST['Name'];            
            $email = $_POST['Email'];
            $password = $_POST['Password'];

            $new_user = [];
            $new_user['name'] = $name;
            $new_user['email'] = $email;
            $new_user['is_active'] = 1;
            $new_user['password'] = bcrypt($password);

            User::create($new_user);

            return response(json_encode(['message' => "User {$name} Created"]), 201);
        } catch (\Throwable $th) {
            return response(json_encode($th->getMessage()), 404);
        }
    }

    public function get_list_user() {
        $user = DB::table("users")->select('users.name', 'users.profile_path', 'users.email', 'users.is_active', 'users.id');
        if (isset($_REQUEST['filter'])) {
            foreach ($_REQUEST['filter'] as $key => $value) {
                if($value['value'] != null) {
                    $filterValue = $value['value'];
                    $user = $user->where($value['name'],'like',"%{$filterValue}%");
                }
            }
        }

        $user = $user->latest()->get();
        if ($user->isEmpty()) {
            return response(json_encode(["Message" => "USer List is Empty"]), 204);
        }
        return response(json_encode(["Data" => $user]));
    }

    public function update_user() {
        if (!Auth::user()) return response(json_encode(["Message" => "You're not logged in"]), 401);
        try {
            $name = $_POST['Name'];
            $email = $_POST['Email'];
            $password = (isset($_POST['Password'])) ? $_POST['Password'] : "";

            $user = User::where("email", $email)->first();
            $user->name = $name;
            $user->email = $email;
            if($password) $user->password = bcrypt($password);
            $user->save();

            return back();
        } catch (\Throwable $th) {
            return response(json_encode($th->getMessage()), 404);
        }
        
    }

    public function deactivate_user($id) {
        if (!Auth::user()) return response(json_encode(["Message" => "You're not logged in"]), 401);

        try {
            $user = User::where("email", $id)->first();
            $user->is_active = 0;
            $user->save();

            return back();
        } catch (\Throwable $th) {
            return response(json_encode($th->getMessage()), 404);
        }
    }

    public function activate_user($id) {
        if (!Auth::user()) return response(json_encode(["Message" => "You're not logged in"]), 401);

        try {
            $user = User::where("email", $id)->first();
            $user->is_active = 1;
            $user->save();

            return back();
        } catch (\Throwable $th) {
            return response(json_encode($th->getMessage()), 404);
        }
    }

    public function change_pass_bypass() {
        $email = $_POST['id'];
        $password = $_POST['password'];
        try {
            $user = User::where("email", $email)->first();
            $user->password = bcrypt($password);
            $user->save();

            return response(json_encode(['Message' => "User {$user->name}'s password is changed"]), 202);
        } catch (\Throwable $th) {
            return response(json_encode($th->getMessage()), 404);
        }
    }

    public function check_password(Request $request) {
        $pass = $_GET['oldpass'];
        $check = Hash::check($pass, $request->user()->password);
        if ($check) {
            return response(json_encode(['Message' => "Password match"]));
        }
        return response(json_encode(['Message' => "Password mismatch"]));
    }
    
    public function edit_profile(Request $request) {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $user = User::where("email", $_POST['email'])->first();
    
        if ($request->image) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $user->profile_path = "/images/{$imageName}";
        }
        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->save();

        return back()->with(['status' => "success", 'message' => "Profile Updated"]);
    }

    public function change_password() {
        $email = Auth::user()->email;
        $password = $_POST['newPass'];
        try {
            $user = User::where("email", $email)->first();
            $user->password = bcrypt($password);
            $user->save();

            return response(json_encode(['Message' => "User {$user->name}'s password is changed"]), 202);
        } catch (\Throwable $th) {
            return response(json_encode($th->getMessage()), 404);
        }
    }

    public function get_profilepicture() {
        $email = $_GET['email'];
        $profile_path = User::where("email", $email)->first()->profile_path;
        return $profile_path;
    }

    public function storeToken(Request $request) {
        Auth::user()->update(['device_key'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }
  
    
}