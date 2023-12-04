@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{route('book_dashboard',[$teamId,'all'])}}"><img src="{{asset('images/back.png')}}" alt=""></a>
    </div>
    <div class="left_menu_logo">
        会計登録
    </div>
</div>

<div class="player_register_form">

<form action="{{route('validate_player_register',[$teamId])}}" method="POST">
                    @csrf
                    <div class="player_name input_form">
                            <span class="">氏名</span>
                            <input type="text" name="playerName" placeholder="" class="form-control" />
                        </div>
                        @if($errors->has('playerName'))
                            <span class="span text-danger text-center d-block">
                                {{$errors->first('playerName')}}
                            </span>
                        @endif
                    <div class="player_gender input_form">
                            <span class="">性別</span>
                            <select name="gender" id="gender" class="form-control triangle_icon">
                            <option value="1">男子</option>
                            <option value="2">女子</option>
                            <option value="3">混合</option>
                        </select>
                    </div>
                    @if($errors->has('gender'))
                       <span class="span text-danger text-center d-block">
                           {{$errors->first('gender')}}
                       </span>
                   @endif
                    <div class="player_enter_date input_form">
                            <span class="">参加日</span>
                            <input type="date" name="createdDate" placeholder="01-01-2023" class="form-control date_icon" />
                        </div>
                        @if($errors->has('createdDate'))
                            <span class="span text-danger text-center d-block">
                                {{$errors->first('createdDate')}}
                            </span>
                        @endif
                    <div class="d-grid mx-auto mt-4">
                        <button class="btn btn-primary register_btn category_register_btn" type="submit">登録する</button>
                    </div>
                </form>

                <div class="player_result_table">
                    <div class="player_style">
                        <input type="radio" id="register" name="playerStyle" checked/>
                        <label for="register">登録された選手</label>
                        <input type="radio" id="archive" name="playerStyle"/>
                        <label for="archive">アーカイブされた選手</label>
                    </div>
                    <table class="player_edit">
                        <tr>
                            <th class="name">氏名</th>
                            <th class="gender">性別</th>
                            <th class="date">参加日</th>
                            <th class="status"></th>
                        </tr>
                        <tr>
                            <td>田中一郎</td>
                            <td>男性</td>
                            <td>2022/10/10</td>
                            <td>
                                <a class="edit">
                                    <img src="{{asset('images/edit-3.svg')}}" alt="">
                                </a>
                                <a class="visible">
                                    <img src="{{asset('images/eye-off.svg')}}" alt="">
                                </a>
                                <a class="delete">
                                    <img src="{{asset('images/trash-2.svg')}}" alt="">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>田中一郎</td>
                            <td>男性</td>
                            <td>2022/10/10</td>
                            <td>
                                <a class="edit">
                                    <img src="{{asset('images/edit-3.svg')}}" alt="">
                                </a>
                                <a class="visible">
                                    <img src="{{asset('images/eye-off.svg')}}" alt="">
                                </a>
                                <a class="delete">
                                    <img src="{{asset('images/trash-2.svg')}}" alt="">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>田中一郎</td>
                            <td>男性</td>
                            <td>2022/10/10</td>
                            <td>
                                <a class="edit">
                                    <img src="{{asset('images/edit-3.svg')}}" alt="">
                                </a>
                                <a class="visible">
                                    <img src="{{asset('images/eye-off.svg')}}" alt="">
                                </a>
                                <a class="delete">
                                    <img src="{{asset('images/trash-2.svg')}}" alt="">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>田中一郎</td>
                            <td>男性</td>
                            <td>2022/10/10</td>
                            <td>
                                <a class="edit">
                                    <img src="{{asset('images/edit-3.svg')}}" alt="">
                                </a>
                                <a class="visible">
                                    <img src="{{asset('images/eye-off.svg')}}" alt="">
                                </a>
                                <a class="delete">
                                    <img src="{{asset('images/trash-2.svg')}}" alt="">
                                </a>
                            </td>
                        </tr>
                    </table>
                    <div class="category_edit_btn">
                        
                        <button class="btn btn-primary register_btn category_register_btn">保存する</button>
                    </div>
                </div>
</div>

@endsection('content')