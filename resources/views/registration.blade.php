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
            <img src="{{asset('images/progressbar1.png')}}" alt="">
        </div>
        
        <div class="register_form">
                <form action="{{route('sample.validate_registration')}}" method="POST">
                    @csrf
                    <div class="form-group mb-4 re_input_form">
                        <img src="{{asset('images/name.png')}}" />
                        <input type="text" name="name" placeholder="Name" class="form-control" />
                        @if($errors->has('name'))
                            <span class="span text-danger">
                                {{$errors->first('name')}}
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-4 re_input_form">
                        <img src="{{asset('images/email.png')}}" />
                        <input type="text" name="email" placeholder="Email" class="form-control" />
                        @if($errors->has('email'))
                            <span class="text-danger">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                    <div class="form-group mb-4 re_input_form">
                        <img src="{{asset('images/password.png')}}" />
                        
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                        @if($errors->has('password'))
                            <span class="text-danger">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                    <div class="form-group mb-4 re_input_form">
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
                    <a href="{{route('validate_back')}}">戻る</a>
                </div>
        </div>
    </div>
</div>
@endsection('content')