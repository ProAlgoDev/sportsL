@extends('main')
@section('content')
@include('bookDashboardLogo')
@include('leftMenuHeader')
<div class="owner_edit_form">
<h3>オーナー権限引き継ぎ</h3>
<p>オーナー権限の引き継ぎ可能です。
オーナー権限を引き継ぎを行いますと、
移行元は編集権限へ変更され、操作できる範囲に制限がかかります。
<br />
<br />
引き継がれる方としっかりコミュニケーションをとり、実行してください。</p>
<form action="{{route('new_team_create2')}}" method="POST">
    <h4>メンバー一覧</h4>
                    @csrf
                    <div class="ownerlist">
                         <label for="1">
                            <img src="{{asset('images/avatar/default_avatar.png')}}" alt="">
                            <span class="user_name">田中一郎</span>
                            <span class="user_id">メンバー</span>
                            <span class="user_style">メンバー</span>
                            <input id="1" type="radio" name="ownerSelect"/>
                        </label>
                                
                        <label for="2">
                            <img src="{{asset('images/avatar/default_avatar.png')}}" alt="">
                            <span class="user_name">田中一郎</span>
                            <span class="user_id">メンバー</span>
                            <span class="user_style">メンバー</span>
                            <input id="2" type="radio" name="ownerSelect"/>
                        </label>
                        <label for="3">
                            <img src="{{asset('images/avatar/default_avatar.png')}}" alt="">
                            <span class="user_name">田中一郎</span>
                            <span class="user_id">メンバー</span>
                            <span class="user_style">メンバー</span>
                            <input id="3" type="radio" name="ownerSelect"/>
                        </label>
                        <label for="4">
                            <img src="{{asset('images/avatar/default_avatar.png')}}" alt="">
                            <span class="user_name">田中一郎</span>
                            <span class="user_id">メンバー</span>
                            <span class="user_style">メンバー</span>
                            <input id="4" type="radio" name="ownerSelect"/>
                        </label>
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn category_register_btn" type="submit">変更する</button>
                    </div>
                </form>
</div>

@endsection('content')