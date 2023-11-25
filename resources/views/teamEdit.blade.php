@extends('main')
@section('content')
@include('bookDashboardLogo')
@include('leftMenuHeader')
<div class="team_info_edit">
    <h2>基本情報</h2>
    <img src="{{asset('images/avatar/default_avatar.png')}}" alt="">
    <table>
        <tr>
            <td>チーム名</td>
            <td>TESTHOGE</td>
        </tr>
        <tr>
            <td>スポーツ</td>
            <td>バスケットボール</td>
        </tr>
        <tr>
            <td>活動エリア</td>
            <td>茨城県</td>
        </tr>
        <tr>
            <td>カテゴリ</td>
            <td>13-18</td>
        </tr>
        <tr>
            <td>性別</td>
            <td>男女混合</td>
        </tr>
    </table>
    <div class="team_info_edit_btn">
        <a href="{{route('team_edit_detail')}}">編集する</a>
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