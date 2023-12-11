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

<div class="password_reset_form">

<form action="{{route('validate_password_reset')}}" method="POST">
                    @csrf
                    <h4>登録しているEmailを入力し、<br>
送信してください。</h4>
                    <div class="form-group mb-4 invite_team_input">
                        <input type="text" name="email" placeholder="Email" class="form-control" />
                        @if($errors->has('email'))
                            <span class="text-danger">{{$errors->first('email')}}</span>
                        @endif
                        @if(session('error'))
                            <span class="text-danger">{{session('error')}}</span>
                        @endif
                    </div>
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn category_register_btn" type="submit">送信する</button>
                    </div>
                </form>
                <div class="register_back">
                    <a href="{{route('validate_back')}}">戻る</a>
                </div>
</div>

@endsection('content')