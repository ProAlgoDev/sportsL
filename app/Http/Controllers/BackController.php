<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Carbon\Carbon;
use Session;
use App\Models\User;
use App\Models\TeamAreaList;
use App\Models\TeamSportsList;
use App\Models\Team;
use App\Models\InitialAmount;
use App\Models\Member;
use App\Models\Category;
use App\Models\DefaultCategory;
use App\Models\Book;
use App\MOdels\Player;
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
        // session()->flush();
        // $client = new Google_Client();
        // $client->setAuthConfig(storage_path('app\public\data\credentials.json'));
        // $client->addScope(Google_Service_Gmail::GMAIL_SEND);
        // $authUrl = $client->createAuthUrl();
        // return Redirect::to($authUrl);
        $email = Session::get('email');
        $user = User::where('email', $email)->first();
        if ($user && $email) {
            return redirect('send-email');
        }
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
    public function validate_registration(Request $request)
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
    public function back(Request $request, $url, $teamId)
    {
        return redirect($url . '/' . $teamId);
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
        // $client = new Google_Client();
        // $client->setAuthConfig(storage_path('app\public\data\credentials.json'));
        // $client->addScope(Google_Service_Gmail::GMAIL_SEND);

        // $code = $request->input('code');
        // $client->authenticate($code);
        // $token = $client->getAccessToken();

        // Session::put('gmail_token', $token);
        $email = Session::get('email');
        $user = User::where('email', $email)->first();
        if ($user && $email) {
            return redirect('send-email');
        }
        return view("registration");
    }

    public function sendEmail()
    {
        // $token = Session::get('gmail_token');
        // $client = new Google_Client();

        // $client->setAuthConfig(storage_path('app\public\data\credentials.json'));
        // $client->addScope(Google_Service_Gmail::GMAIL_SEND);
        // $client->setAccessToken($token);
        // $service = new Google_Service_Gmail($client);
        $email = Session::get('email');
        $verifyEmail = User::where('email', $email)->first();
        if ($verifyEmail && $verifyEmail->is_email_verified) {
            return redirect('login');
        }
        // $imagePath = public_path('images\next_logo.png');
        // $imageData = file_get_contents($imagePath);
        // $encodedImage = base64_encode($imageData);
        $verifyToken = Session::get('verifyToken');
        // $htmlContent = View::make('email.emailVerificationEmail', ['token' => $verifyToken])->render();
        Mail::send('email.emailVerificationEmail', ['token' => $verifyToken], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Email Verification');
        });
        // $message = new Google_Service_Gmail_Message();
        // $mimeMessage = 'MIME-Version: 1.0' . "\r\n";
        // $mimeMessage .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        // $mimeMessage .= 'To: ' . $email . "\r\n";
        // $mimeMessage .= 'Subject: VerificationEmail' . "\r\n\r\n";
        // $mimeMessage .= $htmlContent;
        // $rawMessage = base64_encode($mimeMessage);

        // $message->setRaw($rawMessage);
        // $service->users_messages->send("me", $message);

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
        $defaultCategory = DefaultCategory::where('teamId', $request->teamId)->first();
        $teamId = $request->teamId;
        if (!$defaultCategory) {
            $defaultCategory = DefaultCategory::where('teamId', 'default')->get();
            $defaultCategory->map(function ($item) use ($teamId) {
                DefaultCategory::create([
                    'teamId' => $teamId,
                    'defaultCategory' => $item->defaultCategory
                ]);
            });
        }
        $name = Auth::user()->name;
        return view('newTeamCreate3', ['name' => $name]);

    }
    public function book_dashboard($teamId, $type)
    {
        $book = Book::where('teamId', $teamId)->first();
        $books = Book::where('teamId', $teamId)->get();
        $user = Auth::user()->id;
        $userName = Auth::user()->name;

        $teamIdList = Team::where('owner', $user)->get();
        $teamAvatar = Team::where('teamId', $teamId)->value('teamAvatar');
        $teamName = Team::where('teamId', $teamId)->value('teamName');
        $owner = Team::where('teamId', $teamId)->where('owner', $user)->first();
        $ownerCheck = False;
        if ($owner) {
            $ownerCheck = '管理者';
        } else {
            $ownerCheck = "会員";
        }
        $memeberIdList = Member::where('userId', $user)->get();
        if (!$book) {
            return view('bookDashboard', ['teamId' => $teamId, 'owner' => $ownerCheck, 'userName' => $userName, 'teamName' => $teamName, 'teamAvatar' => $teamAvatar, 'type' => $type, 'teamIdList' => $teamIdList, 'memberIdList' => $memeberIdList]);

        } elseif ($book) {
            return view('bookDashboard', ['teamId' => $teamId, 'owner' => $ownerCheck, 'userName' => $userName, 'teamName' => $teamName, 'type' => $type, 'teamAvatar' => $teamAvatar, 'book' => $book, 'teamIdList' => $teamIdList, 'memberIdList' => $memeberIdList]);
        }
    }

    public function validate_book_dashboard(Request $request)
    {

        return redirect("book_dashboard/$request->teamId/$request->date_switch");
    }
    public function validate_team_edit(Request $request, $teamId)
    {
        $request->validate([
            'teamName' => 'required',
            'sportsList' => 'required',
            'areaList' => 'required',
            'age' => 'required',
            'sex' => 'required',

        ], [
            'teamName' => 'チーム名のフィールドは必須です。',
            'sportsList' => 'スポーツタイプフィールドは必須です。',
            'areaList' => 'エリアフィールドは必須です。',
            'age' => '年齢フィールドは必須です。',
            'sex' => '性別フィールドは必須です。'
        ]);
        $team = Team::where('owner', Auth::user()->id)->first();
        if ($request->image) {
            $imageName = now()->format('YmdHis') . '.' . $request->image->extension();
            $request->image->move(public_path('images/avatar'), $imageName);
            $team->teamAvatar = $imageName;
        }
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
        $sports = TeamSportsList::where('sportsId', $request->sportsList)->first()->sportsType;
        $area = TeamAreaList::where('areaId', $request->areaList)->first()->areaName;
        $teamId = substr($team->teamId, -7, 1);
        $teamId .= $request->sportsList . $request->areaList . $request->age . $request->sex;
        $team->teamId = $teamId;
        $team->teamName = $request->teamName;
        $team->sportsType = $sports;
        $team->area = $area;
        $team->age = $age;
        $team->sex = $sex;
        $team->save();
        return redirect("team_edit_detail/$teamId")->with('teamEditSuccess', 'Image uploaded successfully');
    }
    public function team_edit($teamId)
    {
        $teamInfo = Team::where('teamId', $teamId)->first();
        $teamInitialAmount = InitialAmount::where('teamId', $teamId)->first();
        if ($teamInitialAmount) {
            $createDate = Carbon::parse($teamInitialAmount->createDate)->format('Y-m');
        } else {
            $createDate = '';
        }
        return view('teamEdit', ['title' => 'チーム情報編集', 'teamInfo' => $teamInfo, 'initialAmount' => $teamInitialAmount, 'amount' => $createDate]);
    }
    public function team_edit_detail($teamId)
    {
        $teamInfo = Team::where('teamId', $teamId)->first();
        $sportsList = TeamSportsList::all();
        $areaList = TeamAreaList::all();
        return view("teamInfoEdit", ['title' => 'チーム情報編集', 'teamInfo' => $teamInfo, 'sportsList' => $sportsList, 'areaList' => $areaList]);
    }
    public function team_edit_amount($teamId)
    {
        return view("teamInitialAmountEdit", ['title' => '会計項目登録・編集', 'teamId' => $teamId]);
    }
    public function validate_initial_amount(Request $request)
    {
        $request->validate([
            'initialAmount' => 'required | numeric',
            'createDate' => 'required | date'
        ], [
            'initialAmount.required' => '初期金額フィールドは必須です。',
            'createDate.required' => '日付フィールドは必須です。',
            'initialAmount.numeric' => '初期金額は数値である必要があります。'
        ]);
        $teamId = Team::where('owner', Auth::user()->id)->first();
        $initial = InitialAmount::where('teamId', $teamId->teamId)->first();
        if (!$initial) {
            InitialAmount::create([
                'owner' => Auth::user()->id,
                'teamId' => $teamId->teamId,
                'amount' => $request->initialAmount,
                'createDate' => $request->createDate
            ]);
        } else {

            $initial->update([
                'owner' => Auth::user()->id,
                'teamId' => $teamId->teamId,
                'amount' => $request->initialAmount,
                'createDate' => $request->createDate

            ]);
        }
        return redirect("team_edit_amount/$teamId->teamId")->with('initalEditSuccess', 'successfully');
    }
    public function accounting_category_register($teamId)
    {

        $defaultCategoryList = DefaultCategory::where('teamId', $teamId)->get();

        $categoryList = Category::where('teamId', $teamId)->get();

        return view('accountingCategoryRegisterEdit', ['defaultList' => $defaultCategoryList, 'categoryList' => $categoryList, 'teamId' => $teamId]);

    }
    public function validate_default_category_register(Request $request, $teamId)
    {
        $request->validate(
            [
                'categoryName' => 'required'
            ],
            [
                'categoryName.required' => 'デフォルトのカテゴリ名フィールドは必須です。'
            ]
        );
        $requestValue = $request->categoryName;
        $categories = Category::where('teamId', $teamId)->where('categoryList', $requestValue)->first();
        if (!$categories) {
            Category::create([
                'teamId' => $teamId,
                'categoryList' => $requestValue,
            ]);
        } else {
            return redirect("accounting_category_register/$teamId")->with('existingName', 'existingName');
        }
        return redirect("accounting_category_register/$teamId")->with('success', '');
    }
    public function monthly_report($teamId)
    {
        $book = Book::where('teamId', $teamId)->get();
        return view('monthlyReport', ['teamId' => $teamId, 'book' => $book]);
    }
    public function validate_category_name_edit(Request $request, $teamId)
    {
        //todo change category name from book model
        $categoryList = $request->input('categoryList');
        $dcategoryList = $request->input('deleteCategory');
        if ($categoryList) {
            foreach ($categoryList as $key => $value) {
                echo "$key ':' $value";
                $category = Category::where('teamId', $teamId)->where('categoryList', $key)->first();
                $category->categoryList = $value;
                $category->save();
            }
        }
        if ($dcategoryList) {
            foreach ($dcategoryList as $item) {
                $dcategory = Category::where('teamId', $teamId)->where('categoryList', $item)->first();
                $dcategory->delete();
            }
        }
    }
    public function accounting_register($teamId)
    {
        $defaultCategory = DefaultCategory::where('teamId', $teamId)->pluck('defaultCategory');
        $category = Category::where('teamId', $teamId)->pluck('categoryList');
        $category = $category ?? [];
        $serial = Book::latest()->first();
        if ($serial) {
            $serialNumber = $serial->id + 1;
        } else {
            $serialNumber = 1;
        }
        $categoryList = $defaultCategory->merge($category)->all();
        return view('accountingRegisterEdit', ['teamId' => $teamId, 'categoryList' => $categoryList, 'serial' => $serialNumber]);
    }
    public function validate_accounting_register(Request $request, $teamId)
    {
        $request->validate([
            'inputDate' => 'required | date',
            'categoryList' => 'required',
            'io_switch' => 'required',
            'amount' => 'required | numeric',
            'serial' => 'required',
            'description' => 'required'
        ], [
            'inputDate.required' => '日付フィールドの入力は必須です。',
            'categoryList.required' => 'カテゴリ名の入力フィールドは必須です。',
            'io_switch.required' => '入力タイプフィールドは必須です。',
            'amount.required' => '金額の入力欄は必須です。',
            'serial.required' => 'シリアル番号の入力フィールドは必須です。',
            'description.required' => '説明フィールドの入力は必須です。',
        ]);
        $inputDate = $request->inputDate;
        $category = $request->categoryList;
        $io = $request->io_switch;
        $amount = $request->amount;
        $serial = $request->serial;
        $description = $request->description;
        Book::create([
            'teamId' => $teamId,
            'changeDate' => $inputDate,
            'item' => $category,
            'ioType' => $io,
            'amount' => $amount,
            'serialNumber' => $serial,
            'description' => $description
        ]);
        return redirect("accounting_register/$teamId")->with('accountingRegister', 'success');
    }

    public function invite_team()
    {
        return view('inviteTeam', ['title' => 'チームへ招待']);
    }
    public function ownership_transfer()
    {
        return view('ownerShipTransfer', ['title' => 'オーナー権限引き継ぎ']);
    }
    public function account_setting()
    {
        return view('accountSetting', ['title' => 'アカウント設定']);
    }
    public function monthly_report_search(Request $request, $teamId)
    {
        $yearRequest = $request->year;
        $monthRequest = $request->month;
        if ($yearRequest && $monthRequest) {
            $book = Book::where('teamId', $teamId)->whereYear('changeDate', $request->year)->whereMonth('changeDate', $monthRequest)->get();
        } elseif (!$yearRequest && !$monthRequest) {
            $book = Book::where('teamId', $teamId)->get();
        } elseif ($yearRequest) {
            $book = Book::where('teamId', $teamId)->whereYear('changeDate', $yearRequest)->get();
        } elseif ($monthRequest) {
            $book = Book::where('teamId', $teamId)->whereMonth('changeDate', $monthRequest)->get();
        }
        return view('monthlyReport', ['teamId' => $teamId, 'book' => $book]);
    }
    public function accounting_edit(Request $request, $teamId)
    {
        $defaultCategory = DefaultCategory::where('teamId', $teamId)->pluck('defaultCategory');
        $category = Category::where('teamId', $teamId)->pluck('categoryList');
        $category = $category ?? [];
        $categoryList = $defaultCategory->merge($category)->all();


        $book = Book::where('id', $request->id)->first();
        return view('accountingEdit', ['teamId' => $teamId, 'id' => $request->id, 'book' => $book, 'categoryList' => $categoryList,]);
    }
    public function validate_accounting_edit(Request $request, $teamId)
    {
        $request->validate([
            'inputDate' => 'required | date',
            'categoryList' => 'required',
            'io_switch' => 'required',
            'amount' => 'required | numeric',
            'serial' => 'required',
            'description' => 'required'
        ], [
            'inputDate.required' => '日付フィールドの入力は必須です。',
            'categoryList.required' => 'カテゴリ名の入力フィールドは必須です。',
            'io_switch.required' => '入力タイプフィールドは必須です。',
            'amount.required' => '金額の入力欄は必須です。',
            'serial.required' => 'シリアル番号の入力フィールドは必須です。',
            'description.required' => '説明フィールドの入力は必須です。',
        ]);

        $inputDate = $request->inputDate;
        $category = $request->categoryList;
        $io = $request->io_switch;
        $amount = $request->amount;
        $serial = $request->serial;
        $description = $request->description;
        $book = Book::where('teamId', $teamId)->where('id', $request->itemId)->first();
        $book->update([
            'teamId' => $teamId,
            'changeDate' => $inputDate,
            'item' => $category,
            'ioType' => $io,
            'amount' => $amount,
            'serialNumber' => $serial,
            'description' => $description
        ]);
        $defaultCategory = DefaultCategory::where('teamId', $teamId)->pluck('defaultCategory');
        $category = Category::where('teamId', $teamId)->pluck('categoryList');
        $category = $category ?? [];
        $categoryList = $defaultCategory->merge($category)->all();
        return redirect("monthly_report/$teamId")->with('accountingEdit', 'success');
    }
    public function player_register($teamId)
    {
        $register = Player::where('teamId', $teamId)->where('status', 0)->where('register', 0)->get();
        dump($register);
        $archive = Player::where('teamId', $teamId)->where('status', 0)->where('register', 1)->get();
        return view('playerRegister', ['title' => '選手登録・編集', 'teamId' => $teamId, 'register' => $register, 'archive' => $archive]);
    }
    public function validate_player_register(Request $request, $teamId)
    {
        $request->validate([
            'playerName' => 'required',
            'gender' => 'required',
            'createdDate' => 'required | date',
        ], [
            'playerName.required' => '名前フィールドは必須です。',
            'gender.required' => '名前フィールドは必須です。',
            'createdDate.required' => '日付フィールドは必須です。',
            'createdDate.date' => '日付は有効な日付ではありません。',
        ]);
        $genderList = [
            '1' => "男子",
            '2' => "女子",
            '3' => "混合",
        ];
        $gender = $genderList[$request->gender];
        Player::create([
            'name' => $request->playerName,
            'gender' => $gender,
            'createdDate' => $request->createdDate
        ]);
    }
}

?>