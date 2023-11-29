@extends('main')
@section('content')
@include('bookDashboardLogo')
@include('leftMenuHeader')

<div class="player_register_form">

<form action="{{route('new_team_create2')}}" method="POST">
                    @csrf
                    <div class="player_name input_form">
                            <span class="">氏名</span>
                            <input type="text" name="playerName" placeholder="" class="form-control" />
                            @if($errors->has('teamName'))
                                <span class="span text-danger">
                                    {{$errors->first('teamName')}}
                                </span>
                            @endif
                    </div>
                    <div class="player_gender input_form">
                            <span class="">性別</span>
                            <input type="text" name="playerGender" placeholder="" class="form-control triangle_icon" />
                            @if($errors->has('teamName'))
                                <span class="span text-danger">
                                    {{$errors->first('teamName')}}
                                </span>
                            @endif
                    </div>
                    <div class="player_enter_date input_form">
                            <span class="">参加日</span>
                            <input type="date" name="playerDate" placeholder="" class="form-control date_icon" />
                            @if($errors->has('teamName'))
                                <span class="span text-danger">
                                    {{$errors->first('teamName')}}
                                </span>
                            @endif
                    </div>
                    <div class="d-grid mx-auto">
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