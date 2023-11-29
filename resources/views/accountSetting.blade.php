@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{URL::previous()}}"><img src="{{asset('images/back.png')}}" alt=""></a>
    </div>
    <div class="left_menu_logo">
        {{$title}}
    </div>
</div>
<div class="accounting_category_edit_btn">
    <button>変更する</button>

</div>
<div class="accounting_setting_form">

                    <div class="personal_info">
                        <button><img src="{{asset('images/avatar/default_avatar.png')}}" alt=""></button>
                        <div class="personal_info_content">
                            <p class="user_id">#U30103</p>
                            <p class="user_name">谷　一 </p>
                        </div>
                    </div>
                    <div class="included_team">
                        <h4>所属チーム</h4>
                        <table>
                            <tr>
                                <td>しぶやさんブロックSU</td>
                                <td>オーナー</td>
                            </tr>
                            <tr>
                                <td>幕張シューティングB</td>
                                <td>メンバー</td>
                            </tr>
                            <tr>
                                <td>大阪メンバーボール</td>
                                <td>申請中</td>
                            </tr>
                        </table>
                    </div>
                    <div class="account_detail_info">
                        <div class="birthday">
                            <span class="title">生年月日</span>
                            <span class="status">未設定</span>
                        </div>
                        <div class="gender">
                            <span class="title">性別</span>
                            <span class="status">未設定</span>
                        </div>
                        <div class="email">
                            <div class="title">
                                <span>メールアドレス</span>
                                <span>abcdef@abcd3.com</span>
                            </div>
                            <button class="edit"><img src="{{asset('images/chevron-left.svg')}}" alt=""></button>
                        </div>
                        <div class="password">
                            <div class="title">
                                <span>パスワード</span>
                                <span>********</span>
                            </div>
                            <button class="edit"><img src="{{asset('images/chevron-left.svg')}}" alt=""></button>
                        </div>
                    </div>
                    
                <div class="team_relative_btn">
                        <a class="btn btn-primary register_btn category_register_btn">チーム作成</a>
                        <a class="btn btn-primary register_btn category_register_btn">チーム参加</a>
                </div>
                <p class="security">チームオーナー（マスター権限）のアカウントは削除することができません。
権限を譲渡してからアカウントを削除してください。</p>
<a class="account_delete_btn">アカウントを削除する</a>
</div>

@endsection('content')