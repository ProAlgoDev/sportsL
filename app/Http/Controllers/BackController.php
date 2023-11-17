<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BackController extends Controller
{
    function index()
    {
        return view('initial');
    }
    function login()
    {
        return view('login');
    }
    function registration()
    {
        return view("registration");
    }
    function validate_initial()
    {
        error_log("fasfsfffffff");
        return redirect('login')->with('success', 'welcome');
    }
    function validate_registration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        $data = $request->all();
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return redirect('login')->with("success", "Registration Completed, now you can login");
    }

    function validate_login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('dashboard');
        }

        return redirect("login")->with('success', 'login details are not validate');
    }

    function dashboard()
    {
        if (Auth::check()) {
            return view("dashboard");
        }

        return redirect('login')->with('success', 'you are not allowed to access');
    }
    function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}

?>