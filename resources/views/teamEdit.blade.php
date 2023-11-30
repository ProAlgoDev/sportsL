@extends('main')
@section('content')
@include('bookDashboardLogo')
@include('leftMenuHeader')
<div class="team_info_edit">
    <h2>基本情報</h2>
    <img src="{{asset('images/avatar/'.$teamInfo->teamAvatar)}}" alt="">
    <table>
        <tr>
            <td>チーム名</td>
            <td>{{$teamInfo->teamName}}</td>
        </tr>
        <tr>
            <td>スポーツ</td>
            <td>{{$teamInfo->sportsType}}</td>
        </tr>
        <tr>
            <td>活動エリア</td>
            <td>{{$teamInfo->area}}</td>
        </tr>
        <tr>
            <td>カテゴリ</td>
            <td>{{$teamInfo->age}}</td>
        </tr>
        <tr>
            <td>性別</td>
            <td>{{$teamInfo->sex}}</td>
        </tr>
    </table>
    <div class="team_info_edit_btn">
        <a href="{{route('team_edit_detail',[$teamInfo->teamId])}}">編集する</a>
    </div>
</div>
<div class="initial_amount_set">
    <h2>会計初期設定</h2>
    <table>
        <tr>
            <td>初期金額</td>
            <td>-</td>
        </tr>
        <tr>
            <td>年度開始月</td>
            <td>-</td>
        </tr>
    </table>
    <p>※会計を締めるのは年度開始月の前月になります。</p>
    <div class="initial_amount_btn">
        <a href="{{route('team_edit_amount')}}" class="">編集する</a>
    </div>
</div>
@endsection('content')