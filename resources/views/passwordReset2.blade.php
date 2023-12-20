@extends('main')
@section('content')
@include('bookDashboardLogo')

<div class="header_menu_title">
    <div class="left_menu_back">
    </div>
    <div class="left_menu_logo">
        ID・PASSWORDを忘れた方
    </div>
</div>
<div class="register_container">
    <div class="register_content">
              
        <div class="team_enter_form">
                <div class="team_enter_sent">
                    <img src="{{asset("images/sent.png")}}" alt="">
                    <span>
                      入力されたEmailアドレスへ<br>
再設定のメールを送信しました。<br>
ご確認お願いします。
                    </span>
                </div>
                <div class="d-grid mx-auto">
                    <a href="{{route('login')}}" class="btn btn-primary register_btn team_enter btn_190px">トップへ</a>
                </div>
        </div>
    </div>
</div>
@endsection('content')