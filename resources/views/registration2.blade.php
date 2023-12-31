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
            <img src="{{asset('images/progressbar2.png')}}" alt="">
        </div>
        
        <div class="register2_form">
                <form action="{{route('sample.validate_registration2')}}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <div class="register2_field"><img src="{{asset('images/name.png')}}" /><span>Name</span></div>
                        <input type="text" name="name" placeholder="Name" value="{{old('name')}}" hidden/>
                        <div class="register2_result">{{old('name')}}</div>
                        @if($errors->has('name'))
                            <span class="text-danger">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                    <div class="form-group mb-4">
                        <div class="register2_field"><img src="{{asset('images/email.png')}}" /><span>Email</span></div>
                        <input type="text" name="email" placeholder="Email"  value="{{old('email')}}" hidden/>
                        <div class="register2_result">{{old('email')}}</div>
                         @if($errors->has('email'))
                            <span class="text-danger">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                    <div class="form-group mb-4">
                        <div class="register2_field"><img src="{{asset('images/password.png')}}" /><span>Password</span></div>
                        
                        <input type="password" name="password" value="{{old('password')}}"  placeholder="Password" hidden/>
                        <div id="passwordDisplay" class="register2_result" type='password'>{{old('password')}}</div>
                         @if($errors->has('password'))
                            <span class="text-danger">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                    <div class="form-group mb-4">
                        <div class="policy"><input type="checkbox" name="policy" id='policy' /><a href="https://team-wallet.com/static/terms" target="_blank">利用規約に同意する</a></div>
                        @if($errors->has('policy'))
                            <span class="text-danger">{{$errors->first('policy')}}</span>
                        @endif
                    </div>
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn btn_280px" type="submit">登録する</button>
                    </div>
                </form>
                <div class="register_back">
                    <a href="{{route('registration1')}}">戻る</a>
                </div>
        </div>
    </div>
    <script>
        // Replace characters with dots for password display
        document.addEventListener('DOMContentLoaded', function() {
            var passwordDisplay = document.getElementById('passwordDisplay');
            if (passwordDisplay) {
                var password = passwordDisplay.textContent;
                passwordDisplay.textContent = '*'.repeat(password.length);
            }
        });
    </script>
</div>
@endsection('content')