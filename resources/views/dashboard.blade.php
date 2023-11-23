@extends('main')
@section('content')
<div class="register_container">
    <div class="register_content">
        <div class="register_logo">
            <img src="{{ asset('images/next_logo.png') }}" />
        </div>
               
        <div class="dashboard">
            <div class="dashboard_title">
                <img src="{{asset('images/w_mark.png')}}" alt="" />
                <div class="dashboard_w">
                    <h2>{{$name}}さん<br>
私たちの会計へようこそ</h2>
                </div>
            </div>
                <div class="dashboard_how">
                    <h3>どのようにご利用になりますか？</h3>
                </div>
                <div class="dashboard_btn">
                    <a href="{{route('new_team_create1')}}" class="dashboard_group">
                        <img src="{{asset('images/team2.png')}}" alt="">
                        <div class="dashboard_group_content">新しくチームを作りたい</div>
                    </a>
                    <a href="#" class="dashboard_group">
                        <img src="{{asset('images/team2.png')}}" alt="">
                        <div class="dashboard_group_content">既存のチームに入りたい</div>
                    </a>
                </div>
        </div>
    </div>
</div>
@endsection('content')