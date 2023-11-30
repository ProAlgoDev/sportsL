@extends('main')
@section('content')
@include('bookDashboardLogo')
@include('leftMenuHeader')
<div class="team_info_edit_form">

<form action={{route('validate_team_edit')}} method="post" enctype="multipart/form-data">
    @csrf
                    <div class="new_team_create1_description">
                        <h3>基本情報</h3>
                        </div>
                    <div class="team_avatar_edit">
                        
                        <div>
                            <img onclick="openFileDialog()" id="select_avatar" src="{{asset('images/avatar/'.$teamInfo->teamAvatar)}}" alt="">
                            <input id="fileInput" type="file" name="image" style="display:none;"/>
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
                            <option value="1" {{ $teamInfo->age == "12歳以下" ? 'selected' : '' }}>12歳以下</option>
                            <option value="2" {{ $teamInfo->age == "13-18" ? 'selected' : '' }}>13-18</option>
                            <option value="3" {{ $teamInfo->age == "大学" ? 'selected' : '' }}>大学</option>
                            <option value="4" {{ $teamInfo->age == "社会人" ? 'selected' : '' }}>社会人</option>
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
                            <option value="1" {{ $teamInfo->sex == "男子" ? 'selected' : '' }}>男子</option>
                            <option value="2" {{ $teamInfo->sex == "女子" ? 'selected' : '' }}>女子</option>
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
                        <div id="team_edit_btn" onclick="openModal()" class="team_edit_btn">変更する</div>
                    </div>
                </form>
                <div id="team_edit_modal" style="display:none;" class="team_edit_modal">
                    <h4>変更しますか？</h4>
                    <p>チーム情報を変更した場合、チームに参加されているメンバーの画面も変更されます。<br/>
                        ご注意ください。</p>
                    <div class="team_edit_modal_btn">
                        <button onclick="cancelClick()">キャンセル</button>
                        <button onclick="agreeClick()">変更する</button>
                    </div>
                </div>
                @if(session('teamEditSuccess'))
                <div id="team_edit_success_modal" class="team_edit_success_modal">
                    <h4>変更しました</h4>
                    <p>チーム情報が変更されました。<br />
チームに参加されている画面も変更されています。<br />
必要に応じてアナウンスをお願いします。</p>
                    <div class="team_edit_success_modal_btn">
                        <button onclick="cancelClick()">閉じる</button>
                    </div>
                </div>
                @endif
                <script>
                    function openModal(){
                        document.getElementById("team_edit_modal").style.display= 'block';
                    }
                    function cancelClick(){
                        var modal = document.getElementById("team_edit_modal");
                        modal.style.display = 'none';
                        var modalSuccess = document.getElementById("team_edit_success_modal");
                        modalSuccess.style.display = 'none';
                    }
                    function agreeClick(){
                        var post = document.getElementById('team_edit_info_post');
                        post.click();
                        var modal = document.getElementById("team_edit_modal");
                        modal.style.display = 'none';
                    }
                    function openFileDialog() {
                        var fileInput = document.getElementById('fileInput');

                        // Trigger a click event on the hidden file input
                        fileInput.click();

                        // Listen for the change event on the file input
                        fileInput.addEventListener('change', function() {
                            // Check if a file was selected
                            if (fileInput.files && fileInput.files[0]) {
                                var img = new Image();

                                // Set up a callback function to handle the file read
                                img.onload = function() {
                                    if (img.width > 300 || img.height > 300) {
                                        var spanElement = document.createElement('span');
                                        spanElement.textContent = '画像のサイズは 300x300 ピクセル以下である必要があります。';
                                        spanElement.style.color='red';
                                        spanElement.style.display='block';
                                        spanElement.setAttribute('id','file_alert');
                                        fileInput.insertAdjacentElement('afterend',spanElement);

                                        fileInput.value = '';
                                        
                                    } else{
                                        var fileAlert = document.getElementById('file_alert');
                                        if(fileAlert){
                                            fileAlert.remove();
                                        }
                                        var reader = new FileReader();
                                        reader.onload = function(e){
                                            var blob = new Blob([fileInput.files[0]], { type: fileInput.files[0].type });
                                            var blobUrl = URL.createObjectURL(blob);
                                            document.getElementById('select_avatar').src = blobUrl;
                                        }
                                        reader.readAsArrayBuffer(fileInput.files[0]);
                                    }
                                };
                                img.src = URL.createObjectURL(fileInput.files[0]);
                                // Read the selected file
                            }
                        });
                    }
                    // function postTeamInfo() {
                    //    var avatar =  document.getElementById('fileInput');
                    //    var file = avatar.files[0];
                    //    var teamName = document.getElementById('teamEditDetailTeamName').value;
                    //    var teamSports = document.getElementById('teamEditDetailTeamSports').value;
                    //    var teamArea = document.getElementById('teamEditDetailTeamArea').value;
                    //    var teamAge = document.getElementById('teamEditDetailTeamAge').value;
                    //    var teamGender = document.getElementById('teamEditDetailTeamSex').value;
                        
                    //    var formData = new FormData();
                    //    if(file){
                    //     formData.append('image',file);
                    //    }
                    //    formData.append('teamName',teamName);
                    //    formData.append('teamSports',teamSports);
                    //    formData.append('teamArea',teamArea);
                    //    formData.append('teamAge',teamAge);
                    //    formData.append('teamGender',teamGender);

                    //    fetch("{{route('validate_team_edit')}}",{
                    //     method:"POST",
                    //     body:formData,
                    //     headers:{
                    //         'X-CSRF-TOKEN':'{{csrf_token()}}',
                    //     },
                    //    })
                    //    .then(res => res.json())
                    //    .then(data => {
                    //     console.log('UPload successful',data);
                    //    })
                    //    .catch(error => {
                    //     console.log('Error', error);
                    //    })
                    // }
                </script>
</div>
@endsection('content')