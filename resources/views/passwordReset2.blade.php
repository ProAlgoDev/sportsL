@extends('main')
@section('content')
<div class="register_container">
    <div class="register_content">
        <div class="register_logo">
            <img src="{{ asset('images/next_logo.png') }}" />
        </div>
        <div class="register_title">
            <h1>ID・PASSWORDを忘れた方</h1>
        </div>
        
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
                    <a href="{{route('login')}}" class="btn btn-primary register_btn team_enter">チームトップへ</a>
                </div>
        </div>
    </div>
</div>
@endsection('content')