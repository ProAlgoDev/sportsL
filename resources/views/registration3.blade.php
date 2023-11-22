@extends('main')
@section('content')
<div class="register_container">
    <div class="register_content">
        <div class="register_logo">
            <img src="{{ asset('images/next_logo.png') }}" />
        </div>
        <div class="register_title">
            <h1>新規アカウント作成</h1>
        </div>
        <div class="register_progress">
            <img src="{{asset('images/progressbar3.png')}}" alt="">
        </div>
        
        <div class="register3_form">
                <h2>ご登録ありがとうございます！</h2>
                <div class="register3_logo">
                    <img src="{{asset('images/logo1.png')}}" alt="">
                </div>
                <div class="register3_content">
                    <p>メールを送信しました。<br>メール本文に<br>記載されているリンクにアクセスして<br>登録を完了してください</p>
                </div>
                <div class="d-grid mx-auto">
                    <a class="btn btn-primary register_btn" href="{{route('login')}}">トップへ戻る</a>
                </div>
        </div>
    </div>
</div>
@endsection('content')