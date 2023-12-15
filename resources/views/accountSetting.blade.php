@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{route('sample.dashboard')}}"><img src="{{asset('images/back.png')}}" alt=""></a>
    </div>
    <div class="left_menu_logo">
        {{$title}}
    </div>
</div>
<div class="accounting_category_edit_btn">
    <button class="change_save">変更する</button>
</div>
<div class="accounting_setting_form">
        <form class="account_edit_post" action="{{route('validate_account_edit')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="personal_info">
                <span id="avatar_edit" onclick="openFileDialog()" class="avatar_edit"><img id="select_avatar" src="{{asset("images/avatar/$user->avatar")}}" alt=""></span>

                <div class="personal_info_content">
                    <p class="user_id">#{{$user->u_id}}</p>
                    <p class="user_name">{{$user->name}}</p>
                </div>
            </div>
            <input id="fileInput" type="file" name="avatar" style="display:none;"/>
            <div class="included_team">
                <h4>所属チーム</h4>
                <table>
                    @if($teamList)
                    @foreach($teamList as $team)
                     <tr>
                        <td>{{$team->teamName}}</td>
                        <td>オーナー</td>
                     </tr>
                    @endforeach
                    @endif
                    @if($memberList)
                    @foreach($memberList as $member)
                    @if($member->approved ==1)
                     <tr>
                        <td>{{$member->team->teamName}}</td>
                        <td>メンバー</td>
                     </tr>
                     @endif
                     @if($member->approved ==0)
                     <tr>
                        <td>{{$member->team->teamName}}</td>
                        <td>申請中</td>
                     </tr>
                     @endif
                    @endforeach
                    @endif
                </table>
            </div>
            <div class="account_detail_info">
                <div class="birthday"  data-name="birth">
                    <div class="title">
                        <span>生年月日</span>
                            <span class="birth dis_value">{{$user->birth}}</span>
                            <input class="data_value" type="date" name="birth"  hidden>
                    </div>
                    <span class="edit"><img src="{{asset('images/chevron-left.svg')}}" alt=""></span>
                </div>
                <div class="gender" data-name="gender">
                    <div class="title">
                        <span>性別</span>
                            <span  class="gender dis_value">{{$user->gender}}</span>
                            <input class="data_value" type="text" name="genders" value="{{$user->gender}}" hidden>
                    </div>
                    <span class="edit"><img src="{{asset('images/chevron-left.svg')}}" alt=""></span>
                </div>
                 @if($errors->has('email'))
                            <span class="span text-danger text-center d-block">
                                {{$errors->first('email')}}
                            </span>
                @endif
                <div class="email"  data-name="email">
                    <div class="title">
                        <span  class="email ">メールアドレス</span>
                        <span class="dis_value">{{$user->email}}</span>
                        <input class="data_value" type="text" name="email" value="{{$user->email}}" hidden>

                    </div>
                    <span class="edit"><img src="{{asset('images/chevron-left.svg')}}" alt=""></span>
                </div>
                 @if($errors->has('password'))
                            <span class="span text-danger text-center d-block">
                                {{$errors->first('password')}}
                            </span>
                @endif
                <div class="password"  data-name="password">
                    <div class="title">
                        <span>パスワード</span>
                        <span class="dis_value">********</span>
                        <input class="data_value" type="text" name="password" value="" hidden>
                    </div>
                    <span class="edit"><img src="{{asset('images/chevron-left.svg')}}" alt=""></span>
                </div>
            </div>
        </form>
            
            <div class="team_relative_btn">
                <a href="{{route('new_team_create1')}}" class="btn btn-primary register_btn category_register_btn">チーム作成</a>
                <a href="{{route('search_team')}}" class="btn btn-primary register_btn category_register_btn">チーム参加</a>
            </div>
            <p class="security">チームオーナー（マスター権限）のアカウントは削除することができません。
                権限を譲渡してからアカウントを削除してください。</p>
                 @if(session('error'))
                            <span class="span text-danger text-center d-block">
                               アカウントを削除する前に、権限を譲渡してください。
                            </span>
                        @endif
                <a href="{{route('account_remove')}}" class="account_delete_btn">アカウントを削除する</a>
</div>
<script>
    $('#fileInput').imageUploadResizer({
        max_width: 150, 
        max_height: 150, 
        quality: 0.8, 
        do_not_resize: ['gif', 'svg'], 
    });
   var avatar = document.getElementById('avatar_edit');
   var fileInput = document.getElementById('fileInput');
   function openFileDialog(){ 
        fileInput.click();
        var fileAlert = $('[id="file_alert"]');
        var fileImage = $('[id="file_image"]');
        if(fileAlert){
           fileAlert.remove();
        }
        if(fileImage) {
            fileImage.remove();
        }
        fileInput.addEventListener('change',function(){
             
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
                img.setAttribute('id','file_image');
            }
        });

   }

   $('.edit').click(function(){
    var parent = $(this).closest('div');
    var div = $('<div>',{
        css:{
            position:"absolute",
            top:'6px',
            right:'0',
            border: 'none',
            width:'100%',
            background:'white'
        },
        
    });
    if(parent.data('name') =='birth'){
        var inputElement = $('<input>',{
            type:"date",
            class:'form-control date_icon'
        });
    }else if(parent.data('name') =='gender'){
        var inputElement = $('<select class="form-control"><option>男</option><option>女</option><option>混合</option></select>');
    }
    else{
        var inputElement = $('<input>',{
            type:"text",
            class:'form-control'
        });
    }
    var btnElement = $('<span>',{
        text:"保存",
        css:{
            padding:'5px',
            margin:'0 0 0 28px',
            width:'100px',
            color:'white',
            background: '#3FBAEE',
            border: 'none',
            textAlign:'center'
        }
    });
    div.append(inputElement);
    div.append(btnElement);
    parent.append(div);
    inputElement.val(parent.find('.dis_value').text());
    if(parent.data('name') =='password'){
        inputElement.val('');
    }
    btnElement.click(function(){
        if(!inputElement.val() && (parent.data('name') =='email' || parent.data('name') =='password')){
            inputElement.css('border','1px solid #ff5200');
            return
        }
        parent.find('.data_value').val(inputElement.val());
        parent.find('.dis_value').text(inputElement.val());
        div.remove();
    });
   });

 $('.change_save').click(function(){
    $('.account_edit_post').submit();
 });
</script>
@endsection('content')