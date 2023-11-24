<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\TeamAreaList;
use App\Models\TeamSportsList;
use App\Models\Team;
use App\Models\Member;
use App\Models\Book;
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
        return view('login');
    }
    function registration1()
    {
        session()->flush();
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
        $request->flash();
        return redirect('registration2');
    }
    function validate_registration2(Request $request)
    {

        $request->validate([
            'policy' => 'required|accepted',
            'email' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required',
        ], [
            'policy.required' => '利用規約に同意する必要があります。',
            'name.required' => '名前フィールドは必須です。',
            'email.required' => '電子メールフィールドは必須です。',
            'password.required' => 'パスワードフィールドは必須です。',
            'email.unique' => 'このメールアドレスは既に登録されています。',
        ]);
        $data = $request->all();

        $createUser = $this->create($data);
        $token = Str::random(64);
        UserVerify::create([
            'user_id' => $createUser->id,
            'token' => $token,
            'expires_at' => now()->addMinutes(20)
        ]);
        Session::put("email", $createUser->email);
        Session::put("verifyToken", $token);
        return redirect("send-email");


    }
    function registration3()
    {
        return view("registration3");
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
        session()->flash('error', 'ログインの詳細が検証されていません');
        return redirect("login");
    }

    function dashboard()
    {

        $name = Auth::user()->name;
        $userId = Auth::user()->id;
        $owner = Team::where('owner', $userId)->first();
        $member = Member::where('userId', $userId)->first();

        if ($owner) {
            return redirect("book_dashboard/$owner->teamId/all");
        } elseif ($member) {
            return redirect("book_dashboard/$member->teamId/all");
        }

        return view("dashboard", ['name' => $name]);

    }
    public function create(array $data)
    {
        $id = User::latest()->first();
        if (!$id) {
            $id_m = 1;
        } else {
            $id_m = $id->id + 1;
        }
        $email = $data['email'];
        $user_id = strtoupper($email[0]) . now()->format('d') . now()->format('m') . now()->format('y') . $id_m;
        return
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'u_id' => $user_id
            ]);
    }
    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->where('expires_at', '>', now())->first();
        $message = "Sorry your email cannot be identified.";
        if (!is_null($verifyUser)) {

            $user = $verifyUser->user;
            if (!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your email is now verified";
                return redirect('login')->with('showModal', true)->with('message', $message);
            } else {
                $message = "Your email is already verified.";
            }
        }
        return redirect('dashboard');

    }
    function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('login');
    }

    public function callback(Request $request)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app\public\data\credentials.json'));
        $client->addScope(Google_Service_Gmail::GMAIL_SEND);

        $code = $request->input('code');
        $client->authenticate($code);
        $token = $client->getAccessToken();

        $email = Session::get('email');
        Session::put('gmail_token', $token);
        $user = User::where('email', $email)->first();
        if ($user && $email) {
            return redirect('send-email');
        }
        return view("registration");
    }

    public function sendEmail()
    {
        $token = Session::get('gmail_token');
        $client = new Google_Client();

        $client->setAuthConfig(storage_path('app\public\data\credentials.json'));
        $client->addScope(Google_Service_Gmail::GMAIL_SEND);
        $client->setAccessToken($token);
        $service = new Google_Service_Gmail($client);
        $email = Session::get('email');
        $verifyEmail = User::where('email', $email)->first();
        if ($verifyEmail && $verifyEmail->is_email_verified) {
            return redirect('login');
        }
        $verifyToken = Session::get('verifyToken');
        $imagePath = public_path('images\next_logo.png');
        $imageData = file_get_contents($imagePath);
        $encodedImage = base64_encode($imageData);
        $htmlContent = View::make('email.emailVerificationEmail', ['token' => $verifyToken])->render();

        $message = new Google_Service_Gmail_Message();
        $mimeMessage = 'MIME-Version: 1.0' . "\r\n";
        $mimeMessage .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $mimeMessage .= 'To: ' . $email . "\r\n";
        $mimeMessage .= 'Subject: VerificationEmail' . "\r\n\r\n";
        $mimeMessage .= $htmlContent;
        $rawMessage = base64_encode($mimeMessage);

        $message->setRaw($rawMessage);
        $service->users_messages->send("me", $message);

        return Redirect::to('registration3');
    }
    public function resendEmail()
    {
        return view('verificationEmailResend');
    }
    public function validate_resend_email(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ], [
            'email.required' => '電子メールフィールドは必須です。',
        ]);
        $email = $request->get('email');
        $confirm = User::where('email', $email)->first();
        if ($confirm) {
            $token = Str::random(64);
            Session::put('email', $email);
            Session::put('verifyToken', $token);
            $userVerify = $confirm->userVerify;
            if ($userVerify) {
                $userVerify->expires_at = now()->addMinutes(20);
                $userVerify->token = $token;
                $userVerify->save();
                return redirect('registration1');
            }
        }
        session()->flash('error', '未登録のメールです。');
        return redirect('resend-email');
    }

    public function new_team_create1()
    {

        $sportsList = TeamSportsList::all();
        $areaList = TeamAreaList::all();
        return view('newTeamCreate1', ['sportsList' => $sportsList, 'areaList' => $areaList]);


    }
    public function new_team_create2(Request $request)
    {

        $request->validate(
            [
                'teamName' => 'required',
                'sports_list' => 'required',
                'area_list' => 'required',
                'age' => 'required',
                'sex' => 'required',
            ],
            [
                'teamName' => 'チーム名のフィールドは必須です。',
                'sports_list' => 'スポーツタイプフィールドは必須です。',
                'area_list' => 'エリアフィールドは必須です。',
                'age' => '年齢フィールドは必須です。',
                'sex' => '性別フィールドは必須です。'
            ]
        );
        $sports = TeamSportsList::where('sportsId', $request->sports_list)->first()->sportsType;
        $area = TeamAreaList::where('areaId', $request->area_list)->first()->areaName;
        $ageList = [
            '1' => "12歳以下",
            '2' => "13-18",
            '3' => "大学",
            '4' => "社会人",
        ];
        $sexList = [
            '1' => "男子",
            '2' => "女子",
            '3' => "混合",
        ];
        $age = $ageList[$request->age];
        $sex = $sexList[$request->sex];

        $team = Team::latest()->first();
        if ($team == null) {
            $teamId = 1;
        } else {
            $teamId = $team->id + 1;
        }
        $teamId .= $request->sports_list . $request->area_list . $request->age . $request->sex;
        dump($teamId);

        return view('newTeamCreate2', ['teamName' => $request->teamName, 'sportsType' => $sports, 'area' => $area, 'age' => $age, 'sex' => $sex, 'teamId' => $teamId]);

    }
    public function new_team_create3(Request $request)
    {

        $owner = Auth::user()->id;
        Team::create([
            'teamId' => $request->teamId,
            'teamName' => $request->teamName,
            'sportsType' => $request->sportsType,
            'area' => $request->area,
            'age' => $request->age,
            'sex' => $request->sex,
            'owner' => $owner
        ]);
        $name = Auth::user()->name;
        return view('newTeamCreate3', ['name' => $name]);

    }
    public function book_dashboard($teamId, $type)
    {
        $book = Book::where('teamId', $teamId)->first();
        $books = Book::where('teamId', $teamId)->get();
        $user = Auth::user()->id;
        $teamIdList = Team::where('owner', $user)->get();
        $teamAvatar = Team::where('teamId', $teamId)->value('teamAvatar');
        $teamName = Team::where('teamId', $teamId)->value('teamName');

        dump($teamAvatar);
        echo ("fdfsdfsdfs" . $teamAvatar);
        $memeberIdList = Member::where('userId', $user)->get();
        dump($teamIdList, $memeberIdList);
        if (!$book) {
            return view('bookDashboard', ['teamId' => $teamId, 'teamName' => $teamName, 'teamAvatar' => $teamAvatar, 'type' => $type, 'teamIdList' => $teamIdList, 'memberIdList' => $memeberIdList]);

        } elseif ($book) {
            return view('bookDashboard', ['teamId' => $teamId, 'teamName' => $teamName, 'type' => $type, 'teamAvatar' => $teamAvatar, 'book' => $book, 'teamIdList' => $teamIdList, 'memberIdList' => $memeberIdList]);
        }
    }
    public function validate_book_dashboard(Request $request)
    {

        return redirect("book_dashboard/$request->teamId/$request->date_switch");
    }
    public function create_avatar_view()
    {
        #todo
        return view('login');
    }
    public function upload_avatar(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,gif|max:2048',
        ]);

        $imageName = time() . '-' . $request->image->extension();
        $request->image->move(public_path('images/avatar'), $imageName);
        return redirect('upload')->with('success', 'Image uploaded successfully');
    }
}

?>