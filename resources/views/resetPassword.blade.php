@extends('main')
@section('content')
<div class="register_container">
    <div class="register_content">
        <div class="register_logo">
            <img src="{{ asset('images/next_logo.png') }}" />
        </div>
        <div class="register_title">
            <h1>パスワードのリセット</h1>
        </div>
        
        <div class="register_form">
                <form action="{{route('post_reset_password')}}" method="POST">
                    @csrf
                    <div class="form-group mb-4 reset_password_form">
                        <img src="{{asset('images/password.png')}}" />
                        <input name = 'userId' value={{$user}} hidden />
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                        @if($errors->has('password'))
                            <span class="text-danger">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                    <div class="form-group mb-4 reset_password_form">
                        <img src="{{asset('images/confirm.png')}}" />
                        <input type="password" name="password_confirmation" id='password_confirmation' class="form-control" placeholder="Confirm"/>
                        @if($errors->has('password'))
                            <span class="text-danger">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn btn_280px" type="submit">確認画面へ</button>
                    </div>
                </form>
                <div class="register_back">
                    <a href="{{route('login')}}">戻る</a>
                </div>
        </div>
    </div>
</div>
@endsection('content')