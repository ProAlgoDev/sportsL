@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{URL::previous()}}"><img src="{{asset('images/back.png')}}" alt=""></a>
    </div>
    <div class="left_menu_logo">
        会計項目登録・編集
    </div>
</div>
<div class="account_register_edit_form">

<form action="{{route('new_team_create2')}}" method="POST">
                    @csrf
                    <div class="account_register_edit_category_name">
                        <span>登録したい項目名を入力してください</span>
                        </div>
                    <div class="form-group mb-4 account_register_edit_input">
                        <input type="text" name="teamName" placeholder="" class="form-control" />
                        @if($errors->has('teamName'))
                            <span class="span text-danger">
                                {{$errors->first('teamName')}}
                            </span>
                        @endif
                    </div>
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn" type="submit">変更する</button>
                    </div>
                </form>
</div>

@endsection('content')