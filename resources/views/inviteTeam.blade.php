@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{route('book_dashboard',[$teamId,'all'])}}"><img src="{{asset('images/back.png')}}" alt=""></a>
    </div>
    <div class="left_menu_logo">
        会計登録
    </div>
</div>

<div class="invite_team_form">

<form action="{{route('validate_invite_team',[$teamId])}}" method="POST">
                    @csrf
                    <h4>招待したい人のメールアドレスを入力</h4>
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
                        <button class="btn btn-primary register_btn category_register_btn" type="submit">招待する</button>
                    </div>
                </form>
</div>

@endsection('content')