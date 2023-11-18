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
        if (Auth::check()) {
            return view("dashboard");
        }
        return view('login');
    }
    function registration1()
    {
        return view("registration");
    }
    function registration2()
    {
        $flashedData = session()->getOldInput();
        return view("registration2");
    }
    function validate_initial()
    {
        return redirect('login');
    }
    function validate_registration(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ], [
            'password.confirmed' => 'パスワードの確認が一致しません。',
            'name.required' => '名前フィールドは必須です。',
            'email.required' => '電子メールフィールドは必須です。',
            'password.required' => 'パスワードフィールドは必須です。',
            'email.email' => '正確なemail形式ではありません。',
            'email.unique' => 'このメールアドレスは既に登録されています。',
        ]);
        // $data = $request->all();
        // User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password'])
        // ]);
        $request->flash();
        return redirect("registration2");
        // return redirect('login')->with("success", "Registration Completed, now you can login");
    }
    function validate_registration2(Request $request)
    {

        $request->validate([
            'policy' => 'required|accepted',
        ], [
            'policy.required' => '利用規約に同意する必要があります。'
        ]);
        // $data = $request->all();
        // User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password'])
        // ]);
        $request->flash();
        return redirect("registration2");
        // return redirect('login')->with("success", "Registration Completed, now you can login");
    }
    public function validate_back()
    {
        return redirect('login');
    }
    function validate_login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => '電子メールフィールドは必須です。',
            'password.required' => 'パスワードフィールドは必須です。'
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