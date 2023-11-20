<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Mail;
use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

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
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app\public\data\credentials.json'));
        $client->addScope(Google_Service_Gmail::GMAIL_SEND);
        $authUrl = $client->createAuthUrl();
        return Redirect::to($authUrl);
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
        return redirect('registration2');
        // return redirect('login')->with("success", "Registration Completed, now you can login");
    }
    function validate_registration2(Request $request)
    {

        $request->validate([
            'policy' => 'required|accepted',
        ], [
            'policy.required' => '利用規約に同意する必要があります。'
        ]);
        $data = $request->all();
        $createUser = $this->create($data);
        $token = Str::random(64);
        UserVerify::create([
            'user_id' => $createUser->id,
            'token' => $token
        ]);
        // Mail::send('email.emailVerificationEmail', ['token' => $token], function ($message) use ($request) {
        //     $message->to($request->email);
        //     $message->subject('Email Verification Mail');
        // });
        Session::put("email", $createUser->email);
        Session::put("verifyToken", $token);
        return redirect("send-email");


    }
    function registration3()
    {
        return view("login");
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
    public function create(array $data)
    {
        return
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);
    }
    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
        $message = "Sorry your email cannot be identified.";
        if (!is_null($verifyUser)) {

            $user = $verifyUser->user;
            dump($user->is_email_verified);
            if (!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your email is now verified";
            } else {
                $message = "Your email is already verified.";
            }
        }
        // return redirect('registration1')->with('message', $message);

    }
    function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
    public function auth()
    {

    }
    public function callback(Request $request)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app\public\data\credentials.json'));
        $client->addScope(Google_Service_Gmail::GMAIL_SEND);

        $code = $request->input('code');
        $client->authenticate($code);
        $token = $client->getAccessToken();

        // Store $token in your database or session for later use
        // For simplicity, we'll store it in the session
        Session::put('gmail_token', $token);
        return view("registration");
    }
    public function sendEmailForm()
    {
        return view('send-email-form');

    }
    public function sendEmail()
    {
        // Retrieve stored $token from your session
        $token = Session::get('gmail_token');
        dump($token);
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app\public\data\credentials.json'));
        $client->addScope(Google_Service_Gmail::GMAIL_SEND);
        $client->setAccessToken($token);

        $service = new Google_Service_Gmail($client);
        $email = Session::get('email');
        $verifyToken = Session::get('verifyToken');
        $message = new Google_Service_Gmail_Message();
        // $rawMessage = base64_encode("To: calmspencer21@gmail.com\r\nSubject: Test Subject\r\n\r\nTest email body.");
        $htmlContent = View::make('email.emailVerificationEmail', ['token' => $verifyToken])->render();
        dump($htmlContent);
        $mimeMessage = 'MIME-Version: 1.0' . "\r\n";
        $mimeMessage .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $mimeMessage .= 'To: ' . $email . "\r\n";
        $mimeMessage .= 'Subject: VerificationEmail' . "\r\n\r\n";
        $mimeMessage .= $htmlContent;
        $rawMessage = base64_encode($mimeMessage);
        // return redirect('login')->with("success", "Registration Completed, now you can login");

        $message->setRaw($rawMessage);
        $service->users_messages->send('me', $message);


        // return Redirect::to('registration3')->with('success', 'Email sent successfully');
    }
}

?>