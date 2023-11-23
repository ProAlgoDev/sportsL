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
        
        <div class="new_team_create3_form">
                <form action="{{route('sample.dashboard')}}" method="GET">
                    @csrf
                    <div class="new_team_create3_description">
                        <img src="{{asset('images/recommend.png')}}" alt="" />
                        <div class="new_team_create3_w">
                            <h2>おめでとうございます。<br>{{$name}}</h2>
                        </div>
                    </div>
                    <div class="form-group mb-4  new_team_create3_content">
                        <span>のチームが作成されました。<br>
帳簿機能・招待機能が<br>
使えるようになりました</span>
                    </div>
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn" type="submit">チームトップへ</button>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection('content')