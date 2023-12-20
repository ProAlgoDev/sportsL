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
use App\Models\Master;
use App\Models\Category;
use App\Models\PasswordReset;
use App\Models\DefaultCategory;
use App\Models\Book;
use App\Models\Player;
use App\Models\InviteMail;
use Illuminate\Support\Facades\Auth;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Mail;
// use Google_Client;
// use Google_Service_Gmail;
// use Google_Service_Gmail_Message;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Image;

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
            'email.required' => 'メールフィールドは必須です。',
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
            'email.required' => 'メールフィールドは必須です。',
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
            'email.required' => 'メールフィールドは必須です。',
            'password.required' => 'パスワードフィールドは必須です。'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('dashboard');
        }
        session()->flash('error', 'ログインまたはパスワードが間違っています。');
        return redirect("login");
    }

    function dashboard()
    {

        $name = Auth::user()->name;
        $userId = Auth::user()->id;
        $owner = Team::where('owner', $userId)->first();
        $member = Member::where('user_id', $userId)->first();

        if ($owner) {
            return redirect("book_dashboard/$owner->teamId/all");
        } elseif ($member) {
            $memberTeamId = $member->team->teamId;
            $approve = $member->approved;
            if ($approve == 1) {
                return redirect("book_dashboard/$memberTeamId/all");
            } else {
                return redirect('account_setting');
            }
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
                $verifyUser->delete();
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
            'email.required' => 'メールフィールドは必須です。',
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
                Mail::send('email.emailVerificationEmail', ['token' => $token], function ($message) use ($email) {
                    $message->to($email);
                    $message->subject('Email Verification');
                });
                return redirect('login');
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
            '1' => "社会人",
            '2' => "大学",
            '3' => "13-18",
            '4' => "0-12",
            '5' => "その他",
        ];
        $sexList = [
            '1' => "男",
            '2' => "女",
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
        $team_id = Team::where('teamId', $request->teamId)->first()->id;
        $defaultCategory = DefaultCategory::where('teamId', $team_id)->first();
        $teamId = $request->teamId;
        if (!$defaultCategory) {
            $defaultCategory = DefaultCategory::where('teamId', 'default')->get();
            $defaultCategory->map(function ($item) use ($team_id) {
                DefaultCategory::create([
                    'teamId' => $team_id,
                    'defaultCategory' => $item->defaultCategory
                ]);
            });
        }
        $name = Auth::user()->name;
        return view('newTeamCreate3', ['name' => $name]);

    }
    public function book_dashboard($teamId, $type)
    {
        $selectDate = session('selectDate');
        $team_id = Team::where('teamId', $teamId)->first()->id;
        $book = Book::where('teamId', $team_id)->first();
        $user = Auth::user()->id;
        $userName = Auth::user()->name;

        $teamIdList = Team::where('owner', $user)->get();
        $teamAvatar = Team::where('teamId', $teamId)->value('teamAvatar');
        $team = Team::where('teamId', $teamId)->first();
        $teamName = $team->teamName;
        $owner = Team::where('teamId', $teamId)->where('owner', $user)->first();
        $initialAmount = InitialAmount::where('teamId', $team_id)->first();
        $ownerCheck = False;
        if ($owner) {
            $ownerCheck = '管理者';
        } else {
            $ownerCheck = "会員";
        }
        $currentDate = Carbon::now();
        if ($book) {
            $totalInputAmount = Book::where('teamId', $team_id)->where('ioType', 0)->sum('amount');
            $totalOutputAmount = Book::where('teamId', $team_id)->where('ioType', 1)->sum('amount');
        } else {
            $totalInputAmount = 0;
            $totalOutputAmount = 0;
        }
        $fiveYearsAgo = $currentDate->subYears(5);
        if ($type == 'all') {
            $inputData = [];
            $iTableData = [];
            $oTableData = [];
            $books = Book::where('teamId', $team_id)->where("changeDate", ">=", $fiveYearsAgo)->get();
            if ($books) {
                $initialAmount = InitialAmount::where('teamId', $team_id)->value('amount');
                for ($i = 0; $i < 6; $i++) {
                    $date = Carbon::now()->subYears($i);
                    $inputData[$date->year] = Book::where('teamId', $team_id)->whereYear('changeDate', $date->year)->get();
                    $iBooksGrouped = Book::where('teamId', $team_id)->whereYear('changeDate', $date->year)->where('ioType', 0)->get()->groupBy('item');
                    $oBooksGrouped = Book::where('teamId', $team_id)->whereYear('changeDate', $date->year)->where('ioType', 1)->get()->groupBy('item');
                    $iItemSums = [];
                    $oItemSums = [];
                    foreach ($iBooksGrouped as $itemName => $books) {
                        $iItemSums[$itemName] = $books->sum('amount');
                    }
                    foreach ($oBooksGrouped as $itemName => $books) {
                        $oItemSums[$itemName] = $books->sum('amount');
                    }
                    $iTableData[$date->year] = $iItemSums;
                    $oTableData[$date->year] = $oItemSums;
                }
            }
        }
        if ($type == 'year') {

            $selectDate = $selectDate == null ? now()->format('Y') : $selectDate;
            $inputData = [];
            $iTableData = [];
            $oTableData = [];
            $books = Book::where('teamId', $team_id)->whereYear("changeDate", $selectDate)->get();
            if ($books) {
                $initialAmount = InitialAmount::where('teamId', $team_id)->value('amount');
                for ($i = 1; $i < 13; $i++) {
                    $inputData[$i] = Book::where('teamId', $team_id)->whereYear('changeDate', $selectDate)->whereMonth('changeDate', $i)->get();
                    $iBooksGrouped = Book::where('teamId', $team_id)->whereYear('changeDate', $selectDate)->whereMonth('changeDate', $i)->where('ioType', 0)->get()->groupBy('item');
                    $oBooksGrouped = Book::where('teamId', $team_id)->whereYear('changeDate', $selectDate)->whereMonth('changeDate', $i)->where('ioType', 1)->get()->groupBy('item');
                    $iItemSums = [];
                    $oItemSums = [];
                    foreach ($iBooksGrouped as $itemName => $books) {
                        $iItemSums[$itemName] = $books->sum('amount');
                    }
                    foreach ($oBooksGrouped as $itemName => $books) {
                        $oItemSums[$itemName] = $books->sum('amount');
                    }
                    $iTableData[$i] = $iItemSums;
                    $oTableData[$i] = $oItemSums;
                }
            }
        }
        if ($type == 'month') {

            $selectDate = $selectDate == null ? now()->format('Y-m') : $selectDate;
            list($year, $month) = explode('-', $selectDate);
            $inputData = [];
            $iTableData = [];
            $oTableData = [];
            $startDate = Carbon::create($year, $month, 1);
            $endDate = $startDate->copy()->lastOfMonth();
            $books = Book::where('teamId', $team_id)->whereYear("changeDate", $selectDate)->get();
            if ($books) {
                $initialAmount = InitialAmount::where('teamId', $team_id)->value('amount');
                for ($i = $startDate->day; $i <= $endDate->day; $i++) {
                    $date = Carbon::create($year, $month, $i);
                    $inputData[$i] = Book::where('teamId', $team_id)->where('changeDate', $date)->get();
                    $iBooksGrouped = Book::where('teamId', $team_id)->where('changeDate', $date)->where('ioType', 0)->get()->groupBy('item');
                    $oBooksGrouped = Book::where('teamId', $team_id)->where('changeDate', $date)->where('ioType', 1)->get()->groupBy('item');
                    $iItemSums = [];
                    $oItemSums = [];
                    foreach ($iBooksGrouped as $itemName => $books) {
                        $iItemSums[$itemName] = $books->sum('amount');
                    }
                    foreach ($oBooksGrouped as $itemName => $books) {
                        $oItemSums[$itemName] = $books->sum('amount');
                    }
                    $iTableData[$i] = $iItemSums;
                    $oTableData[$i] = $oItemSums;
                }
            }
        }
        $memeberIdList = Member::where('user_id', $user)->get();
        if (!$books) {
            return view('bookDashboard', ['teamId' => $teamId, 'owner' => $ownerCheck, 'userName' => $userName, 'teamName' => $teamName, 'teamAvatar' => $teamAvatar, 'type' => $type, 'teamIdList' => $teamIdList, 'memberIdList' => $memeberIdList, 'inputData' => '', 'initialAmount' => '', 'iTable' => '', 'oTable' => '', 'selectDate' => $selectDate, 'totalInput' => $totalInputAmount, 'totalOutput' => $totalOutputAmount]);

        } elseif ($books) {
            return view('bookDashboard', ['teamId' => $teamId, 'owner' => $ownerCheck, 'userName' => $userName, 'teamName' => $teamName, 'type' => $type, 'teamAvatar' => $teamAvatar, 'book' => $books, 'teamIdList' => $teamIdList, 'memberIdList' => $memeberIdList, 'inputData' => $inputData, 'initialAmount' => $initialAmount, 'iTable' => $iTableData, 'oTable' => $oTableData, 'selectDate' => $selectDate, 'totalInput' => $totalInputAmount, 'totalOutput' => $totalOutputAmount]);
        }
    }

    public function validate_book_dashboard(Request $request)
    {

        return redirect("book_dashboard/$request->teamId/$request->date_switch")->with('selectDate', $request->selectDate);
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
            '1' => "社会人",
            '2' => "大学",
            '3' => "13-18",
            '4' => "0-12",
            '5' => "その他",
        ];
        $sexList = [
            '1' => "男",
            '2' => "女",
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
        $teamInitialAmount = InitialAmount::where('teamId', $teamInfo->id)->first();
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
        $teamId = $request->teamId;
        $team = Team::where('teamId', $teamId)->first();
        $initial = InitialAmount::where('teamId', $team->id)->first();
        if (!$initial) {
            InitialAmount::create([
                'teamId' => $team->id,
                'amount' => $request->initialAmount,
                'createDate' => $request->createDate
            ]);
        } else {

            $initial->update([
                'teamId' => $team->id,
                'amount' => $request->initialAmount,
                'createDate' => $request->createDate

            ]);
        }
        return redirect("team_edit_amount/$teamId")->with('initalEditSuccess', 'successfully');
    }
    public function accounting_category_register($teamId)
    {
        $team_id = Team::where('teamId', $teamId)->first()->id;
        $defaultCategoryList = DefaultCategory::where('teamId', $team_id)->get();

        $categoryList = Category::where('teamId', $team_id)->get();

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
        $team_id = Team::where('teamId', $teamId)->first()->id;
        $categories = Category::where('teamId', $team_id)->where('categoryList', $requestValue)->first();
        if (!$categories) {
            Category::create([
                'teamId' => $team_id,
                'categoryList' => $requestValue,
            ]);
        } else {
            return redirect("accounting_category_register/$teamId")->with('existingName', 'existingName');
        }
        return redirect("accounting_category_register/$teamId")->with('success', '');
    }
    public function monthly_report($teamId)
    {
        $team_id = Team::where('teamId', $teamId)->first()->id;

        $book = Book::where('teamId', $team_id)->get();
        return view('monthlyReport', ['teamId' => $teamId, 'book' => $book]);
    }
    public function validate_category_name_edit(Request $request, $teamId)
    {
        //todo change category name from book model
        $categoryList = $request->input('categoryList');
        $dcategoryList = $request->input('deleteCategory');
        $team_id = Team::where('teamId', $teamId)->first()->id;
        if ($dcategoryList) {
            foreach ($dcategoryList as $item) {
                $dcategory = Category::where('teamId', $team_id)->where('categoryList', $item)->first();
                if ($dcategory) {
                    $dcategory->delete();
                }
            }
        }

        if ($categoryList) {
            foreach ($categoryList as $key => $value) {
                $category = Category::where('teamId', $team_id)->where('categoryList', $key)->first();
                if($category){
                    $category->categoryList = $value;
                    $category->status = 0;
                    $category->save();
                }
            }
        }

    }
    public function accounting_register($teamId)
    {
        $team_id = Team::where('teamId', $teamId)->first()->id;
        $defaultCategory = DefaultCategory::where('teamId', $team_id)->pluck('defaultCategory');
        $category = Category::where('teamId', $team_id)->pluck('categoryList');
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
        $team_id = Team::where('teamId', $teamId)->first()->id;
        $categoryModel = Category::where('teamId', $team_id)->where('categoryList', $category)->first();
        if ($categoryModel) {
            $categoryModel->status = 1;
            $categoryModel->save();
        }
        if ($category == '月謝' || $category == '保険') {
            $player = Player::where('teamId', $team_id)->where('status', 0)->get();

            if ($player->isEmpty()) {
                session()->flash('player', 'まず選手を登録してください。');
                return redirect()->back();
            }
            $playerCount = count($player);
            $amount = $amount * $playerCount;
        }
        Book::create([
            'teamId' => $team_id,
            'changeDate' => $inputDate,
            'item' => $category,
            'ioType' => $io,
            'amount' => $amount,
            'serialNumber' => $serial,
            'description' => $description
        ]);
        return redirect("accounting_register/$teamId")->with('accountingRegister', 'success');
    }

    public function invite_team($teamId)
    {
        return view('inviteTeam', ['title' => 'チームへ招待', 'teamId' => $teamId]);
    }
    public function ownership_transfer($teamId)
    {
        $team_id = Team::where('teamId', $teamId)->first();
        $memberList = Member::where('team_id', $team_id->id)->where('approved', 1)->get();

        return view('ownerShipTransfer', ['title' => 'オーナー権限引き継ぎ', 'memberList' => $memberList, 'teamId' => $teamId]);
    }
    public function account_setting()
    {
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();
        $teamList = Team::where('owner', $userId)->get();
        $memberList = Member::where('user_id', $userId)->get();
        return view('accountSetting', ['title' => 'アカウント設定', 'user' => $user, 'teamList' => $teamList, 'memberList' => $memberList]);
    }
    public function monthly_report_search(Request $request, $teamId)
    {
        $yearRequest = $request->year;
        $monthRequest = $request->month;
        $team_id = Team::where('teamId', $teamId)->first()->id;
        if ($yearRequest && $monthRequest) {
            $book = Book::where('teamId', $team_id)->whereYear('changeDate', $request->year)->whereMonth('changeDate', $monthRequest)->get();
        } elseif (!$yearRequest && !$monthRequest) {
            $book = Book::where('teamId', $team_id)->get();
        } elseif ($yearRequest) {
            $book = Book::where('teamId', $team_id)->whereYear('changeDate', $yearRequest)->get();
        } elseif ($monthRequest) {
            $book = Book::where('teamId', $team_id)->whereMonth('changeDate', $monthRequest)->get();
        }

        return view('monthlyReport', ['teamId' => $teamId, 'book' => $book, 'year' => $yearRequest, 'month' => $monthRequest]);
    }
    public function accounting_edit(Request $request, $teamId)
    {
        $team_id = Team::where('teamId', $teamId)->first()->id;

        $defaultCategory = DefaultCategory::where('teamId', $team_id)->pluck('defaultCategory');
        $category = Category::where('teamId', $team_id)->pluck('categoryList');
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
        $baseCategory = $request->baseCategory;
        $io = $request->io_switch;
        $amount = $request->amount;
        $serial = $request->serial;
        $description = $request->description;
        $team_id = Team::where('teamId', $teamId)->first()->id;
        $book = Book::where('teamId', $team_id)->where('id', $request->itemId)->first();
        $categoryList = Book::where('teamId', $team_id)->where("item", $baseCategory)->pluck('item')->toArray();
        if (count($categoryList) == 1 && $baseCategory != $category) {
            $categoryModel = Category::where('teamId', $team_id)->where('categoryList', $baseCategory)->first();
            if ($categoryModel) {
                $categoryModel->status = 0;
                $categoryModel->save();
            }
        }
        $newCategory = Category::where('teamId', $team_id)->where('categoryList', $category)->first();
        if ($newCategory) {
            $newCategory->status = 1;
            $newCategory->save();
        }
        $book->update([
            'teamId' => $team_id,
            'changeDate' => $inputDate,
            'item' => $category,
            'ioType' => $io,
            'amount' => $amount,
            'serialNumber' => $serial,
            'description' => $description
        ]);
        $defaultCategory = DefaultCategory::where('teamId', $team_id)->pluck('defaultCategory');
        $category = Category::where('teamId', $team_id)->pluck('categoryList');
        $category = $category ?? [];
        $categoryList = $defaultCategory->merge($category)->all();
        return redirect("monthly_report/$teamId")->with('accountingEdit', 'success');
    }
    public function player_register($teamId)
    {
        $team_id = Team::where('teamId', $teamId)->first()->id;

        $register = Player::where('teamId', $team_id)->where('status', 0)->where('register', 0)->get();
        $archive = Player::where('teamId', $team_id)->where('status', 0)->where('register', 1)->get();
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
            '1' => "男",
            '2' => "女",
            '3' => "混合",
        ];
        $team_id = Team::where('teamId', $teamId)->first()->id;
        $gender = $genderList[$request->gender];
        Player::create([
            'name' => $request->playerName,
            'gender' => $gender,
            'createdDate' => $request->createdDate,
            'teamId' => $team_id,
        ]);
        return redirect("player_register/$teamId");
    }
    public function validate_player_register_edit(Request $request, $teamId)
    {
        $editList = $request->input('editList');
        $archiveList = $request->input('archiveList');
        $deleteList = $request->input('deleteList');
        $visibleList = $request->input('visibleList');
        $team_id = Team::where('teamId', $teamId)->first()->id;
        if ($editList) {
            foreach ($editList as $item) {
                $id = $item['id'];
                $name = $item['name'];
                $gender = $item['gender'];
                $date = $item['date'];
                $player = Player::where('teamId', $team_id)->where('id', $id)->first();
                $player->name = $name;
                $player->gender = $gender;
                $player->createdDate = $date;
                $player->save();
            }
        }
        if ($archiveList) {
            foreach ($archiveList as $item) {
                $player = Player::where('teamId', $team_id)->where('id', $item)->first();
                $player->register = 1;
                $player->save();
            }
        }
        if ($visibleList) {
            foreach ($visibleList as $item) {
                $player = Player::where('teamId', $team_id)->where('id', $item)->first();
                $player->register = 0;
                $player->save();
            }
        }
        if ($deleteList) {
            foreach ($deleteList as $item) {
                $player = Player::where('teamId', $team_id)->where('id', $item)->first();
                $player->status = 1;
                $player->save();
            }
        }
    }
    public function validate_invite_team(Request $request, $teamId)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'メールフィールドは必須です。',
            'email.email' => '正確なemail形式ではありません。',
        ]);
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if ($user) {
            $id = $user->id;
            $owner = Team::where('teamId', $teamId)->where('owner', $id)->first();
            $member = Member::where('user_id', $id)->first();
        } else {
            $owner = '';
            $member = '';
        }
        $from = Team::where('teamId', $teamId)->first();
        $teamName = $from->teamName;
        $verifyToken = Str::random(64);
        if ($owner) {
            session()->flash('error', 'あなたはこのチームの管理者です。');
        } elseif ($member) {
            session()->flash('error', 'あなたはこのチームのメンバーです');
        } else {
            Mail::send('email.emailInviteMember', ['token' => $verifyToken, 'teamName' => $teamName], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Invite Mail');
            });
            InviteMail::create([
                'email' => $email,
                'token' => $verifyToken,
                'expired_at' => now()->addHours(24),
                'teamId' => $teamId,
            ]);
        }

        return redirect()->back();

    }
    public function validate_invite_mail($token)
    {
        $user = InviteMail::where('token', $token)->where('expired_at', '>', now())->first();
        return view("inviteRegistration", ['user' => $user]);
    }
    public function validate_invite_register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.confirmed' => 'パスワードの確認が一致しません。',
            'name.required' => '名前フィールドは必須です。',
            'password.required' => 'パスワードフィールドは必須です',
        ]);
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $teamId = $request->teamId;
        $id = User::latest()->first();
        if (!$id) {
            $id_m = 1;
        } else {
            $id_m = $id->id + 1;
        }
        $user_id = strtoupper($email[0]) . now()->format('d') . now()->format('m') . now()->format('y') . $id_m;
        $user = User::where('email', $email)->first();
        if (!$user) {
            User::create([
                'u_id' => $user_id,
                'email' => $email,
                'name' => $name,
                'password' => Hash::make($password),
                'is_email_verified' => 1
            ]);
        }
        $team = Team::where('teamId', $teamId)->first();
        $userId = User::where('email', $email)->first()->id;
        $mteamId = $team->id;
        Member::create([
            'user_id' => $userId,
            'approved' => 1,
            'team_id' => $mteamId
        ]);
        $credentials = $request->only('email', 'password');

        Auth::attempt($credentials);
        return redirect("book_dashboard/$teamId/all");
    }
    public function member_approve($teamId)
    {
        $member = Member::where('approved', 0)->whereHas('team', function ($query) use ($teamId) {
            $query->where('teamId', $teamId);
        })->get();
        return view('memberApproveList', ['teamId' => $teamId, 'memberList' => $member]);
    }
    public function validate_approve_member(Request $request, $teamId)
    {
        $approveList = $request->approveList;

        foreach ($approveList as $member) {
            $user = Member::where('user_id', $member)->first();
            $user->approved = 1;
            $user->save();
        }
    }
    public function search_team()
    {
        $user = Auth::user()->id;
        $member = Member::where('user_id', $user)->pluck('team_id')->toArray();
        if (!$member) {
            $teamList = Team::where('owner', '!=', $user)->get();
        } else {
            $teamList = Team::whereNotIn('id', $member)->where('owner', '!=', $user)->get();
        }
        if (!$teamList) {
            return redirect('dashboard');
        }
        return view('searchTeam', ['teamList' => $teamList]);
    }
    public function validate_search_team(Request $request)
    {
        $id = $request->search;
        $user = Auth::user()->id;
        $member = Member::where('user_id', $user)->pluck('team_id')->toArray();
        if ($id) {
            if (!$member) {
                $teamList = Team::where('teamId', 'LIKE', "%$id%")->where('owner', '!=', $user)->get();
            } else {
                $teamList = Team::whereNotIn('id', $member)->where('teamId', 'LIKE', "%$id%")->where('id', '!=', $member)->where('owner', '!=', $user)->get();
            }
        } else {
            if (!$member) {
                $teamList = Team::where('owner', '!=', $user)->get();
            } else {
                $teamList = Team::whereNotIn('id', $member)->where('owner', '!=', $user)->get();
            }
        }
        return view('searchTeam', ['teamList' => $teamList]);
    }
    public function search_team2(Request $request)
    {
        $team = Team::where('id', $request->id)->first();
        $user = Auth::user()->id;
        $member = Member::where('user_id', $user)->where('team_id', $team->id)->first();
        if ($member) {
            session()->flash('teamError', 'ffff');
            return redirect()->back();
        }
        return view('searchTeam2', ['team' => $team]);
    }
    public function validate_team_enter(Request $request)
    {
        $id = $request->id;
        $userId = Auth::user()->id;
        $user_id = User::where('id', $userId)->first();
        if ($id) {
            $team = Team::where('id', $id)->first();
            $member = Member::where('team_id', $team->id)->where('user_id', $user_id->id)->first();
            if ($member) {
                session()->flash('error', 's');
                return view('searchTeam3', ['team' => $team]);
            } else {
                Member::create([
                    'team_id' => $team->id,
                    'user_id' => $user_id->id,
                ]);
                return view('searchTeam3', ['team' => $team]);
            }
        }
        return back();

    }
    public function validate_account_edit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'メールフィールドは必須です。',
            'password.required' => 'パスワードフィールドは必須です。',
            'email.email' => '正確なemail形式ではありません。',
            'password.min' => 'パスワードは 6 文字以上である必要があります。'
        ]);
        // $request->validate([
        //     'avatar' => 'required|image|mimes:jpeg,png,jpg,gif', // Example validation rules
        // ]);
        $id = Auth::user()->id;
        $avatar = $request->avatar;
        $birth = $request->birth;
        $gender = $request->genders;
        $email = $request->email;
        $password = $request->password;
        $user = User::where('id', $id)->first();

        if ($avatar) {
            $imageName = now()->format('YmdHis') . '.' . $avatar->extension();
            $avatar->move(public_path('images/avatar'), $imageName);
            $user->avatar = $imageName;
        }
        if ($birth) {
            $user->birth = $birth;
        }
        if ($gender) {
            $user->gender = $gender;
        }
        if ($email) {
            $u_id = $user->u_id;
            $new = strtoupper($email[0]);
            $user->u_id = $new . substr($u_id, 1);
            $user->email = $email;
        }
        if ($password) {
            $user->password = Hash::make($password);
        }
        $user->save();
        return redirect()->back();
    }
    public function account_remove()
    {
        $userId = Auth::user()->id;

        $teamId = Team::where('owner', $userId)->pluck('id')->toArray();
        $member = Member::where('team_id', $teamId)->get();
        $book = Book::where('teamId', $teamId)->get();

        $amount = InitialAmount::where('teamId', $teamId)->get();
        if ($member->isNotEmpty() || $book->isNotEmpty() || $amount->isNotEmpty()) {
            session()->flash('error', 'f');
            return redirect('account_setting');
        }
        $memberId = Member::where('user_id', $userId)->get();
        if ($memberId->isNotEmpty()) {
            foreach ($memberId as $iMember) {
                $iMember->delete();
            }
        }
        $id = Team::where('owner', $userId)->get();
        if ($id->isNotEmpty()) {
            foreach ($id as $iOwner) {
                $iOwner->delete();
            }
        }
        $user = User::where('id', $userId)->first();
        $userVerify = UserVerify::where('user_id', $userId)->get();
        if ($userVerify->isNotEmpty()) {
            foreach ($userVerify as $iVerify) {
                $iVerify->delete();
            }
        }
        $user->delete();
        return redirect('login');
    }
    public function validate_ownership_transfer(Request $request, $teamId)
    {
        $request->validate([
            'ownerSelect' => 'required'
        ]);
        $team = Team::where('teamId', $teamId)->first();
        $oldOwner = $team->owner;
        $token = Str::random(64);
        Master::create([
            'token' => $token,
            'oldUser' => $oldOwner,
            'newUser' => $request->ownerSelect,
            'expired_at' => now()->addHours(72)
        ]);
        $user = Member::where('user_id', $request->ownerSelect)->first();
        $email = $user->user->email;
        Mail::send('email.emailOwnerTransfer', ['token' => $token, 'teamName' => $team->teamName], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Owner Transfer Mail');
        });
        return view('ownerShipTransferReport', ['title' => 'オーナー権限引き継ぎ', 'user' => $user, 'teamId' => $teamId]);
    }
    public function verify_owner_transfer($token)
    {
        $user = Master::where('token', $token)->where('expired_at', '>', now())->first();
        if (!$user) {
            return redirect('login');
        }
        $oldOwnerUser = User::where('id', $user->oldUser)->first();
        $team = Team::where('owner', $user->oldUser)->first();
        if (!$team) {
            return redirect('dashboard');
        }
        $team->owner = $user->newUser;
        Member::create([
            'approved' => 1,
            'user_id' => $oldOwnerUser->id,
            'team_id' => $team->id
        ]);
        $team->save();
        $oldMember = Member::where('user_id', $user->newUser)->where('team_id', $team->id)->first();
        $oldMember->delete();
        $user->delete();
        return redirect('dashboard');
    }
    public function password_reset()
    {
        return view('passwordReset');
    }

    public function validate_password_reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'メールフィールドは必須です。',
            'email.email' => '正確なemail形式ではありません。',
        ]);
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            session()->flash('error', 'メールは存在しません');
            return redirect('login');
        }
        $token = Str::random(64);
        PasswordReset::create([
            'user_id' => $user->id,
            'token' => $token,
            'expired_at' => now()->addHours(60),
        ]);
        Mail::send('email.emailPasswordReset', ['token' => $token], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Password Reset');
        });
        return view('passwordReset2');
    }
    public function verify_password_reset($token)
    {
        $user = PasswordReset::where('token', $token)->where('expired_at', '>', now())->first();
        if (!$user) {
            session()->flash('error', 'セッションの有効期限が切れました');
            return redirect('password_reset');
        }
        return view('resetPassword', ['user' => $user->user_id]);
    }
    public function post_reset_password(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ], [
            'password.required' => 'パスワードフィールドは必須です。',
            'password.min' => 'パスワードは 6 文字以上である必要があります。',
            'password.confirmed' => 'パスワードの確認が一致しません。',

        ]);
        $password = $request->password;
        $userId = $request->userId;
        $passwordReset = PasswordReset::where('user_id', $userId)->first();
        if ($passwordReset) {
            $passwordReset->delete();
        }
        $user = User::where('id', $userId)->first();
        if ($user) {
            $user->password = Hash::make($password);
        }
        session()->flash('resetPassword', 'パスワードがリセットされました');
        return redirect('login');
    }
}

?>