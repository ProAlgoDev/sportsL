@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{URL::previous()}}"><img src="{{asset('images/back.png')}}" alt=""></a>
    </div>
    <div class="left_menu_logo">
        会計項目登録・編集
    </div>
</div>
<div class="accounting_category_register_edit_form">

<form action="{{route('new_team_create2')}}" method="POST">
                    @csrf
                    <div class="account_register_edit_category_name">
                        <span>基本項目として以下の登録がされています。</span>
                        <a href="#">>>登録されている基本項目</a>
                        </div>
                    <div class="form-group mb-4 account_register_edit_input">
                        <span class="category">登録したい項目名を入力してください</span>
                        <input type="text" name="teamName" placeholder="" class="form-control" />
                        @if($errors->has('teamName'))
                            <span class="span text-danger">
                                {{$errors->first('teamName')}}
                            </span>
                        @endif
                    </div>
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn category_register_btn" type="submit">変更する</button>
                    </div>
                </form>
                <div class="category_edit">
                    <div class="category_edit_title">
                        <span>登録された項目名</span>
                    </div>
                    <table class="category_edit_list">
                        <tr>
                            <td class="category_edit_name">雑費</td>
                            <td class="category_edit_button"><button><img src="{{asset('images/edit-3.svg')}}" /></button></td>
                            <td class="category_delete_button"><button><img src="{{asset('images/trash-2.svg')}}" /></button></td>
                        </tr>
                        <tr>
                            <td class="category_edit_name">通信費</td>
                            <td class="category_edit_button"><button><img src="{{asset('images/edit-3.svg')}}" /></button></td>
                            <td class="category_delete_button"><button><img src="{{asset('images/trash-2.svg')}}" /></button></td>
                        </tr>
                        <tr>
                            <td class="category_edit_name">返金</td>
                            <td class="category_edit_button"><button><img src="{{asset('images/edit-3.svg')}}" /></button></td>
                            <td class="category_delete_button"><button><img src="{{asset('images/trash-2.svg')}}" /></button></td>
                        </tr>
                    </table>
                    <div class="category_edit_btn">
                        
                        <button class="btn btn-primary register_btn category_register_btn">保存する</button>
                    </div>
                </div>
</div>

@endsection('content')