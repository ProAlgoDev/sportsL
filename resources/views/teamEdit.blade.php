@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{route('book_dashboard',[$teamInfo->teamId,'all'])}}"><img src="{{asset('images/back.png')}}" alt=""></a>
    </div>
    <div class="left_menu_logo">
        {{$title}}
    </div>
</div>
<div id="team_edit_modal" style="display:none;" class="team_edit_modal">
    <div class="team_edit_modal_content">
            <h4>変更しますか？</h4>
            <p>チーム情報を変更した場合、チームに参加されているメンバーの画面も変更されます。<br/>
                ご注意ください。</p>
                <div class="team_edit_modal_btn">
                    <button onclick="cancelClick()">キャンセル</button>
                    <button onclick="agreeClick()">変更する</button>
                </div>
        </div>
</div>
@if(session('teamEditSuccess'))
    <div id="team_edit_success_modal" class="team_edit_success_modal">
        <div class="team_edit_success_modal_content">
            <h4>変更しました</h4>
            <p>チーム情報が変更されました。<br />
                チームに参加されている画面も変更されています。<br />
                必要に応じてアナウンスをお願いします。</p>
            <div class="team_edit_success_modal_btn">
                <button onclick="cancelClick()">閉じる</button>
            </div>
        </div>
    </div>
@endif
<div id="team_edit_modal_initial" style="display:none;" class="team_edit_modal">
    <div class="team_edit_modal_content">
        <h4>変更しますか？</h4>
        <p>会計関連の情報を変更すると、レポートへ影響がでます。<br>
ご注意ください。</p>
        <div class="team_edit_modal_btn">
            <button onclick="cancelClickInitial()">キャンセル</button>
            <button onclick="agreeClickInitial()">変更する</button>
        </div>
    </div>
</div>

@if(session('initalEditSuccess'))
    <div id="team_edit_success_modal_initial" class="team_edit_success_modal">
        <div class="team_edit_success_modal_content">
            <h4>変更しました</h4>
            <p>会見関連の情報が変更されました。<br>
チームに参加されている画面も変更されています。<br>
必要に応じてアナウンスをお願いします。</p>
            <div class="team_edit_success_modal_btn">
                <button onclick="cancelClickInitial()">閉じる</button>
            </div>
        </div>
    </div>
@endif

<div class="team_info_edit">
    <div class="team_info_edit_form">

        <form action={{route('validate_team_edit',[$teamInfo->teamId])}} method="post" enctype="multipart/form-data">
        @csrf
                        <div class="new_team_create1_description">
                            <h3>基本情報</h3>
                            </div>
                        <div class="team_avatar_edit">
                            
                            <div>
                                <img onclick="openFileDialog()" id="select_avatar" src="{{asset('images/avatar/'.$teamInfo->teamAvatar)}}" alt="">
                                <input id="fileInput" type="file" name="image" style="display:none;" accept=".png, .jpg, .jpeg"/>
                            </div>
                        </div>
                        <div class="form-group mb-4 team_edit_info_detail">
                            <span class="team_edit_info_detail_title">チーム名</span>
                            <input type="text" name="teamName" id="teamEditDetailTeamName" placeholder="" class="form-control" value="{{$teamInfo->teamName}}" />
                            @if($errors->has('teamName'))
                                <span class="span text-danger">
                                    {{$errors->first('teamName')}}
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-4 m_selectlist team_edit_info_detail">
                            <span class="team_edit_info_detail_title">スポーツ</span>
                            <select name="sportsList"  id="teamEditDetailTeamSports" class="form-control">
                                @foreach ($sportsList as $sports)
                                    <option value="{{$sports->sportsId}}" {{ $teamInfo->sportsType == $sports->sportsType ? 'selected' : '' }}>{{$sports->sportsType}} </option>
                                @endforeach
                            </select>
                            @if($errors->has('sportsList'))
                                <span class="span text-danger">
                                    {{$errors->first('sportsList')}}
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-4  m_selectlist team_edit_info_detail">
                            <span class="team_edit_info_detail_title">活動エリア</span>
                            <select name="areaList" id="teamEditDetailTeamArea"  class="form-control" value="{{$teamInfo->area}}">
                                @foreach ($areaList as $area)
                                    <option value="{{$area->areaId}}" {{ $teamInfo->area == $area->areaName ? 'selected' : '' }}>{{$area->areaName}}</option>
                                @endforeach
                            </select>
                             @if($errors->has('area_list'))
                                <span class="span text-danger">
                                    {{$errors->first('area_list')}}
                                </span>
                            @endif
                        </div>
                         <div class="form-group mb-4  m_selectlist team_edit_info_detail">
                            <span class="team_edit_info_detail_title">カテゴリ</span>
                            <select name="age" id="teamEditDetailTeamAge" class="form-control">
                                <option value="1" {{ $teamInfo->age == "社会人" ? 'selected' : '' }}>社会人</option>
                                <option value="2" {{ $teamInfo->age == "大学" ? 'selected' : '' }}>大学</option>
                                <option value="3" {{ $teamInfo->age == "13-18" ? 'selected' : '' }}>13-18</option>
                                <option value="4" {{ $teamInfo->age == "0-12" ? 'selected' : '' }}>0-12</option>
                                <option value="5" {{ $teamInfo->age == "その他" ? 'selected' : '' }}>その他</option>
                            </select>
                            @if($errors->has('age'))
                                <span class="span text-danger">
                                    {{$errors->first('age')}}
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-4  m_selectlist team_edit_info_detail">
                            <span class="team_edit_info_detail_title">性別</span>
                            <select name="sex" id="teamEditDetailTeamSex" class="form-control">
                                <option value="1" {{ $teamInfo->sex == "男" ? 'selected' : '' }}>男</option>
                                <option value="2" {{ $teamInfo->sex == "女" ? 'selected' : '' }}>女</option>
                                <option value="3" {{ $teamInfo->sex == "混合" ? 'selected' : '' }}>混合</option>
                            </select>
                            @if($errors->has('sex'))
                                <span class="span text-danger">
                                    {{$errors->first('sex')}}
                                </span>
                            @endif
                        </div>
                        
                        <div class="d-grid mx-auto">
                            <button style="display:none;" onclick="postTeamInfo()" id="team_edit_info_post" class="btn btn-primary register_btn" type="submit"></button>
                            <div id="team_edit_btn" onclick="openModal()" class="team_edit_btn">編集する</div>
                        </div>
                    </form>
    </div>


</div>
<div class="team_info_edit_form initial_amount_form">

<form action="{{route('validate_initial_amount',[$teamInfo->teamId])}}" method="POST">
                    @csrf
                    <div class="new_team_create1_description">
                        <h3>会計初期設定</h3>
                        </div>
                    <div class="form-group team_edit_info_detail">
                        <span class="team_edit_info_detail_title">初期金額</span>
                        <input type="text" name="initialAmount" placeholder="" class="form-control" value={{($initialAmount)?$initialAmount->amount:"-"
                        }}>
                    </div>
                    @if($errors->has('initialAmount'))
                        <span class="span text-danger">
                            {{$errors->first('initialAmount')}}
                        </span>
                    @endif
                    <div class="form-group mt-4 team_edit_info_detail">
                        <span class="team_edit_info_detail_title">年  月</span>
                        <input  name="createDate" type='date' placeholder="" class="form-control date_icon" value={{$amount?$amount:"-"}}>
                    </div>
                    @if($errors->has('createDate'))
                        <span class="span text-danger">
                            {{$errors->first('createDate')}}
                        </span>
                    @endif
                              
                    <div class="d-grid mx-auto mt-4">
                        <button style="display:none;" id="team_edit_info_post_initial" class="btn btn-primary register_btn" type="submit"></button>
                        <div id="team_edit_btn" onclick="openModalInitial()" class="team_edit_btn">変更する</div>
                    </div>
                </form>
                
                
</div>
<script>
function openModalInitial(){
                        document.getElementById("team_edit_modal_initial").style.display= 'block';
                    }
                    function cancelClickInitial(){
                        var modal = document.getElementById("team_edit_modal_initial");
                        modal.style.display = 'none';
                        var modalSuccess = document.getElementById("team_edit_success_modal_initial");
                        modalSuccess.style.display = 'none';
                    }
                    function agreeClickInitial(){
                        var post = document.getElementById('team_edit_info_post_initial');
                        post.click();
                        var modal = document.getElementById("team_edit_modal_initial");
                        modal.style.display = 'none';
                    }
                    $('#team_edit_modal_initial').click(function(e){
                        if(e.target.id=='team_edit_modal_initial'){
                            $(this).css('display','none');
                        }
                    });
                    $('#team_edit_success_modal_initial').click(function(e){
                        if(e.target.id=='team_edit_success_modal_initial'){
                            $(this).css('display','none');
                        }
                    });




    $('#fileInput').imageUploadResizer({
                        max_width: 150, 
                        max_height: 150, 
                        quality: 0.8, 
                        do_not_resize: ['gif', 'svg'], 
                    });
                    function openModal(){
                        document.getElementById("team_edit_modal").style.display= 'block';
                    }
                    function cancelClick(){
                        var modal = document.getElementById("team_edit_modal");
                        modal.style.display = 'none';
                        var modalSuccess = document.getElementById("team_edit_success_modal");
                        modalSuccess.style.display = 'none';
                    }
                    $('#team_edit_modal').click(function(e){
                        if(e.target.id == 'team_edit_modal'){
                            $(this).css('display', 'none');
                        }
                    } );
                    $('#team_edit_success_modal').click(function(e){
                        if(e.target.id =='team_edit_success_modal'){
                            $(this).css('display', 'none');
                        }
                    } );
                    function agreeClick(){
                        var post = document.getElementById('team_edit_info_post');
                        post.click();
                        var modal = document.getElementById("team_edit_modal");
                        modal.style.display = 'none';
                    }

                    function openFileDialog() {
                        
                        var fileInput = document.getElementById('fileInput');
                        fileInput.click();
                        fileInput.addEventListener('change', function() {
                        if (fileInput.files && fileInput.files[0]) {
                                var img = new Image();
                                img.onload = function() {
                                        var reader = new FileReader();
                                        reader.onload = function(e){
                                            var blob = new Blob([fileInput.files[0]], { type: fileInput.files[0].type });
                                            var blobUrl = URL.createObjectURL(blob);
                                            document.getElementById('select_avatar').src = blobUrl;
                                        }
                                        reader.readAsArrayBuffer(fileInput.files[0]);
                                };
                                img.src = URL.createObjectURL(fileInput.files[0]);
                            }
                        });
                    }
</script>
@endsection('content')