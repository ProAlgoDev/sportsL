<div draggable="true" class="book_dashboard_menu_container" ondragstart="handleDrag(event)" id="book_dashboard_menu_container">
    <div class="menu_header">
        <img class="menu_header_avatar" src="{{asset("images/avatar/$teamAvatar")}}" alt="">
        <div class="menu_header_info">
            <div class="menu_header_info_teamId">#{{$teamId}}</div>
            <div class="menu_header_info_teamName">{{$teamName}}</div>
            <div class="menu_header_info_userName">
                {{$userName}}<span>{{$owner}}</span>
            </div>
        </div>
        <input id="left_menu_extend" type="checkbox" />
        <label  class='menu_header_list' for="left_menu_extend"></label>
    </div>
    <div class="left_menu_team_list">
        @foreach($teamIdList as $teamList)
            <a href="{{route('book_dashboard',[$teamList->teamId,'all'])}}" class="team_category">
                <div class="">
                    <img src="{{asset('images/avatar/' . $teamList->teamAvatar)}}" alt="">
                    <span>{{$teamList->teamName}}</span>
                </div>
                <div class="">管理者</div>
            </a>
        @endforeach
        @if($memberIdList)
        @foreach($memberIdList as $memberList)
            <a href="{{route('book_dashboard',[$memberList->team->teamId,'all'])}}" class="team_category">
                <div class="">
                    <img src="{{asset('images/avatar/' . $memberList->team->teamAvatar)}}" alt="">
                    <span>{{$memberList->team->teamName}}</span>
                </div>
                <div class="">メンバー</div>
            </a>
        @endforeach
        @endif
    </div>
    <div class="menu_content">
        <div class="menu_content_list">
            <div class="menu_search">
            </div>
            <div class="menu_content_home book_menu">
                <input id="home_menu" type="checkbox" class="left_home_menu" style="display:none;">
                <label for='home_menu'  class="menu_content_home_title">
                    <img id="home_image" src="{{asset('images/home.svg')}}" alt="">
                    <div class="">ホーム</div>
                </label>
                @if($owner == '管理者')
                <div class="menu_content_home_list">
                    <a href="{{route('team_edit',[$teamId])}}" class="menu_content_home_item">
                        <img src="{{asset('images/edit-2.svg')}}" alt="">
                    <div class="">チーム情報編集</div>
                </a>
                    <a href="{{route('accounting_category_register',[$teamId])}}" class="menu_content_home_item">
                        <img src="{{asset('images/list.svg')}}" alt="">
                        <div class="">会計項目登録・編集</div>
                    </a>
                    <a href="{{route('accounting_register',[$teamId])}}" class="menu_content_home_item">
                        <img src="{{asset('images/dollar-sign.svg')}}" alt="">
                        <div class="">会計登録・編集</div>
                    </a>
                    <a href="{{route('player_register',[$teamId])}}" class="menu_content_home_item">
                        <img src="{{asset('images/users.svg')}}" alt="">
                        <div class="">選手登録・編集</div>
                    </a>
                    <a href="{{route('member_approve',[$teamId])}}" class="menu_content_home_item">
                        <img src="{{asset('images/key.svg')}}" alt="">
                        <div class="">メンバー権限変更</div>
                    </a>
                    <a href="{{route('invite_team',[$teamId])}}" class="menu_content_home_item">
                        <img src="{{asset('images/send.svg')}}" alt="">
                        <div class="">チームへ招待</div>
                    </a>
                    <a href="{{route('ownership_transfer',[$teamId])}}" class="menu_content_home_item">
                        <img src="{{asset('images/repeat.svg')}}" alt="">
                        <div class="">オーナー権限引き継ぎ</div>
                    </a>
                </div>
                @endif
                
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

    
    <script>
        var checkbox = document.getElementById('left_menu_extend');
        var memberList = document.querySelector('.left_menu_team_list');
        var leftMenu = document.querySelector('.menu_content');
        checkbox.addEventListener('click', function(){
            memberList.style.display = checkbox.checked ? "block" : "none";
            leftMenu.style.display = checkbox.checked ? "none" : "block";
        })
    </script>
</div>