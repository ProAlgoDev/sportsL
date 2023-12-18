@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{route('back',['team_edit',"$teamId"])}}"><img src="{{asset('images/back.png')}}" alt=""></a>
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

@if(session('initalEditSuccess'))
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
<div class="team_info_edit_form initial_amount_form">

<form action="{{route('validate_initial_amount',[$teamId])}}" method="POST">
                    @csrf
                    <div class="new_team_create1_description">
                        <h3>会計初期設定</h3>
                        </div>
                    <div class="form-group mb-4 team_edit_info_detail">
                        <span>初期金額</span>
                        <input type="text" name="initialAmount" placeholder="" class="form-control" />
                        @if($errors->has('initialAmount'))
                            <span class="span text-danger">
                                {{$errors->first('initialAmount')}}
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-4 team_edit_info_detail">
                        <span>年  月</span>
                        <input  name="createDate" type='date' placeholder="" class="form-control date_icon" />
                        @if($errors->has('createDate'))
                            <span class="span text-danger">
                                {{$errors->first('createDate')}}
                            </span>
                        @endif
                    </div>
                              
                    <div class="d-grid mx-auto">
                        <button style="display:none;" onclick="postTeamInfo()" id="team_edit_info_post" class="btn btn-primary register_btn" type="submit"></button>
                        <div id="team_edit_btn" onclick="openModal()" class="team_edit_btn">変更する</div>
                    </div>
                </form>
                
                
</div>
<script>
                    function openModal(){
                        document.getElementById("team_edit_modal").style.display= 'block';
                            $('#team_edit_modal').css('opacity','0');
                        setTimeout(() => {
                            $('#team_edit_modal').css('opacity','1');
                        }, 0.5);
                    }
                    function cancelClick(){
                        var modal = document.getElementById("team_edit_modal");
                        modal.opacity=0;
                        setTimeout(() => {
                            modal.style.display = 'none';
                        }, 0.5);
                        var modalSuccess = document.getElementById("team_edit_success_modal");
                        modalSuccess.style.opacity=0;
                        setTimeout(() => {
                            modalSuccess.style.display = 'none';
                        }, 0.5);
                    }
                    function agreeClick(){
                        var post = document.getElementById('team_edit_info_post');
                        post.click();
                        var modal = document.getElementById("team_edit_modal");
                        modal.opacity=0;
                        setTimeout(() => {
                            modal.style.display = 'none';
                        }, 0.5);
                    }
                    $('#team_edit_modal').click(function(){
                        $(this).css('opacity','0');
                        setTimeout(() => {
                            $(this).css('display','none');
                        }, 0.5);
                    });
                    $('#team_edit_success_modal').click(function(){
                        $(this).css('opacity','0');
                        setTimeout(() => {
                            $(this).css('display','none');
                        }, 0.5);
                    });

    // // Enable the year and month picker
    // jSuites.calendar(document.getElementById('calendar'), {
    //     type: 'year-month-picker',
    //     format: 'YYYY-MM',
    //     validRange: ['2000-02-01', '2024-12-31'],
    // });

</script>
@endsection('content')