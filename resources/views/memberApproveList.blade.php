@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{route('book_dashboard',[$teamId,'all'])}}"><img src="{{asset('images/back.png')}}" alt=""></a>
    </div>
    <div class="left_menu_logo">
        メンバーを承認する
    </div>
</div>
<div class="member_approve_form">
  <h6>メンバー承認リスト</h6>
    <div class="member_approve_list">
        <div class="member_approve_item title">
            <span class="name">名前</span>
            <span></span>
        </div>
        @if($memberList)
        @foreach($memberList as $member)
        <div class="member_approve_item">
            <span>{{$member->user->name}}</span>
            <input class="approve_check" value={{$member->user_id}} type='checkbox'>
        </div>
        @endforeach
        @endif
        <button class="btn btn-primary register_btn approve_btn">承認する</button>
    </div>
                
</div>

<script>
    $(document).ready(function(){
    var currentURL = window.location.href;
    var teamId = currentURL.substring(currentURL.lastIndexOf('/') + 1);

        $('.approve_btn').click(function(){
            let approveList = [];
            var checkbox = $('.approve_check');
            checkbox.each(function(){
                var check = $(this).is(':checked');
                if(check){
                    console.log($(this).val())
                    approveList.push($(this).val());
                }
            });
            if(Object.keys(approveList).length==0){
                return
            }
            $.ajax({
                type: 'POST',
                url: `/validate_approve_member/${teamId}`,
                data:{
                    approveList: approveList,
                    _token: "{{csrf_token()}}"
                },
                success:function(response){
                    window.location.reload();
                    console.log('Category sent successfully', response); 
                },
                error: function (error) {
                    window.location.reload();
                    console.error('Error sending category', error); 
                }
            
            });
        });

       

    });
</script>

@endsection('content')