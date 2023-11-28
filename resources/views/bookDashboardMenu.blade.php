<div draggable="true" class="book_dashboard_menu_container" ondragstart="handleDrag(event)" id="book_dashboard_menu_container">
    <div class="menu_header">
        <img class="menu_header_avatar" src="{{asset("images/avatar/$teamAvatar")}}" alt="">
        <div class="menu_header_info">
            <div class="menu_header_info_teamId">#1072013</div>
            <div class="menu_header_info_teamName">サザンオールスターズ</div>
            <div class="menu_header_info_userName">
                YamadaIchiro<span>管理者</span>
            </div>
        </div>
        <button class='menu_header_list'><img src="" alt=""></button>
    </div>
    <div class="menu_content">
        <div class="menu_content_list">
            <div class="menu_search">
            </div>
            <div class="menu_content_home book_menu">
                <a href="#" class="menu_content_home_title menu_active">
                    <img src="{{asset('images/home.svg')}}" alt="">
                    <div class="">ホーム</div>
                </a>
                <div class="menu_content_home_list">
                    <a href="{{route('team_edit')}}" class="menu_content_home_item">
                        <img src="{{asset('images/edit-2.svg')}}" alt="">
                    <div class="">チーム情報編集</div>
                </a>
                    <a href="{{route('accounting_category_register')}}" class="menu_content_home_item">
                        <img src="{{asset('images/list.svg')}}" alt="">
                        <div class="">会計項目登録・編集</div>
                    </a>
                    <a href="{{route('accounting_register')}}" class="menu_content_home_item">
                        <img src="{{asset('images/dollar-sign.svg')}}" alt="">
                        <div class="">会計登録・編集</div>
                    </a>
                    <a href="{{route('player_register')}}" class="menu_content_home_item">
                        <img src="{{asset('images/users.svg')}}" alt="">
                        <div class="">選手登録・編集</div>
                    </a>
                    <a  class="menu_content_home_item">
                        <img src="{{asset('images/key.svg')}}" alt="">
                        <div class="">メンバー権限変更</div>
                    </a>
                    <a href="{{route('invite_team')}}" class="menu_content_home_item">
                        <img src="{{asset('images/send.svg')}}" alt="">
                        <div class="">チームへ招待</div>
                    </a>
                    <a href="{{route('ownership_transfer')}}" class="menu_content_home_item">
                        <img src="{{asset('images/repeat.svg')}}" alt="">
                        <div class="">オーナー権限引き継ぎ</div>
                    </a>
                </div>
                
            </div>
            <a href="{{route('account_setting')}}" class="menu_account_setting book_menu">
                <img src="{{asset('images/setting.svg')}}" alt="">
                <div class="">アカウント設定</div>
            </a>
            <a href="{{route('logout')}}" class="menu_account_logout book_menu">
                <img src="{{asset('images/log-out.svg')}}" alt="">
                <div class="">ログアウト</div>
            </a>
        </div>
    </div>
    <div class="menu_content_version">version 1.0.0</div>
    <div class="menu_background_1"></div>

    
</div>