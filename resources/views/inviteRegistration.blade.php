@extends('main')
@section('content')
<div class="register_container">
    <div class="register_content">
        <div class="register_logo">
            <img src="{{ asset('images/next_logo.png') }}" />
        </div>
        <div class="register_title">
            <h1>チーム登録</h1>
        </div>
        
        <div class="register_form">
                <form action="{{route('validate_invite_register')}}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <img src="{{asset('images/name.png')}}" />
                        <input type="text" name="name" placeholder="Name" class="form-control" />
                        @if($errors->has('name'))
                            <span class="span text-danger">
                                {{$errors->first('name')}}
                            </span>
                        @endif
                        @if($errors->has('email'))
                            <span class="span text-danger">
                                {{$errors->first('email')}}
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-4 d-none">
                        <input type="text" name="email" placeholder="Email" value="{{$user->email}}" class="form-control" />
                        <input type="text" name="teamId" value="{{$user->teamId}}">
                    </div>
                    <div class="form-group mb-4">
                        <img src="{{asset('images/password.png')}}" />
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                        @if($errors->has('password'))
                            <span class="text-danger">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                    <div class="form-group mb-4">
                        <img src="{{asset('images/confirm.png')}}" />
                        <input type="password" name="password_confirmation" id='password_confirmation' class="form-control" placeholder="Confirm"/>
                        @if($errors->has('password'))
                            <span class="text-danger">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn" type="submit">登録する</button>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection('content')