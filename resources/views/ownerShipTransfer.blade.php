@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{route('book_dashboard',[$teamId,'all'])}}"><img src="{{asset('images/back.png')}}" alt=""></a>
    </div>
    <div class="left_menu_logo">
        {{$title}}
    </div>
</div>
<div class="owner_edit_form">
<h3>オーナー権限引き継ぎ</h3>
<p>オーナー権限の引き継ぎ可能です。
オーナー権限を引き継ぎを行いますと、
移行元は編集権限へ変更され、操作できる範囲に制限がかかります。
<br />
<br />
引き継がれる方としっかりコミュニケーションをとり、実行してください。</p>
<form action="{{route('validate_ownership_transfer',[$teamId])}}" class="owner_transfer_form" method="POST">
    <div class="owner_transfer_confirm">
        <h6>引き継ぎ依頼</h6>
        <p>権限の引き継ぎ依頼を行いますが、間違いないですか？</p>
        <div class="">
            <span class="cancel">キャンセル</span>
            <span class="agree">依頼する</span>
        </div>
    </div>
    <h4>メンバー一覧</h4>
                    @csrf
                    <div class="ownerlist">
                        @if(count($memberList) > 0)
                        @foreach($memberList as $member)
                            <label for = {{$member->id}}>
                                <img src="{{asset("images/avatar/{$member->user->avatar}")}}" alt="">
                                <span class="user_name">{{$member->user->name}}</span>
                                <span class="user_id">{{$member->user->u_id}}</span>
                                <span class="user_style">メンバー</span>
                                <input id={{$member->id}} value={{$member->user_id}} type="radio" name="ownerSelect"/>
                            </label>
                        @endforeach
                        @else
                        <div class="text-center mt-5">メンバーがいない</div>
                        @endif
                         
                    <div class="d-grid mx-auto">
                        <span class="btn btn-primary register_btn category_register_btn result_btn" type="submit">変更する</span>
                    </div>
                </form>
</div>
<script>
    $('.result_btn').click(function(){
        $('.owner_transfer_confirm').css('display', 'block');
    });
    $('.cancel').click(function(){
        $('.owner_transfer_confirm').css('display', 'none');
    });
    $('.agree').click(function(){
        $('.owner_transfer_form').submit();
        $('.owner_transfer_confirm').css('display', 'none');

    });
    
</script>
@endsection('content')