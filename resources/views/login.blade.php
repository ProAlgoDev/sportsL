@extends('main')
@section('content')
@if($message = Session::get('success'))
<div class="alert alert-info">
    {{ $message }}
</div>

@endif
<div class="login_container">
    <div class="login_content">
        <div class="login_logo">
            <img src="{{ asset('images/next_logo.png') }}" />
        </div>
        @if(session('showModal'))
        <div class='success_verify'>成功メールの確認</div>
        @endif
        @if(session('errors'))
        <span class="text-danger">{{session('errors')}}</span>
        @endif
        {{-- @if(session('resetPassword'))
        <div class='success_verify'>{{session('resetPassword')}}</div>
        @endif --}}
        <form action="{{route('sample.validate_login')}}" class="login_form" method="POST">
                @csrf
                <div class="login_email">
                    <span>電子メールアドレス</span>
                    <img src="{{asset('images/email.png')}}" alt="" />
                    <input type="text" name="email" class="form-control" placeholder="" />
                    @if($errors->has('email'))
                        <span class="text-danger">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                     @if(session('error'))
                            <span class="text-danger">{{session('error')}}</span>
                        @endif
                </div>
                <div class="login_password">
                    <span>パスワード</span>
                    <img class='login_password_input' src="{{ asset('images/password.png') }}" />
                    <input type="password" name="password" class="form-control" id='login_password_input' placeholder="" />
                    <div id="login_password_show"><img src="{{asset('images/show.png')}}"/></div>

                    @if($errors->has('password'))
                        <span class="text-danger">{{$errors->first('password')}}</span>
                    @endif
                </div>
                <div class="login_forgot">
                    <a href="{{route('password_reset')}}">ID・PASSWORDを忘れた方はこちら</a>
                </div>
                <div class="login_btn">
                    <button type='submit' class="btn btn-primary">ログイン</button>
                </div>
        </form>
        <div class="login_register">
            <a href="{{route('registration1')}}">アカウントを作成する（メール）</a>
        </div>
        <div class="login_social">
            <a href="#"><img src="{{asset('images/twitter.png')}}" alt="" /></a>
            <a href="#"><img src="{{asset('images/google2.png')}}" alt="" /></a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            var passwordInput = document.getElementById('login_password_input');
            var showPasswordButton = document.getElementById("login_password_show");
            showPasswordButton.addEventListener("click", function(){
                if(passwordInput.type == 'password'){
                    passwordInput.type = 'text';
                }
                else{
                    passwordInput.type = 'password';
                }
            });
        });
    </script>
</div>
@endsection('content')