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
<div class="accounting_category_edit_btn">
    <button>編集</button>
</div>
<div class="accounting_register_edit_form">

<form action="{{route('new_team_create2')}}" method="POST">
                    @csrf
                    <div class="form-group mb-4 accounting_register_edit_input">
                        <div class="accounting_register_edit_date">
                            <span class="">日付</span>
                            <input type="text" name="teamName" placeholder="" class="form-control" />
                            @if($errors->has('teamName'))
                                <span class="span text-danger">
                                    {{$errors->first('teamName')}}
                                </span>
                            @endif
                        </div>
                        <div class="accounting_register_edit_category">
                            <span class="">会計項目</span>
                            <input type="text" name="teamName" placeholder="" class="form-control" />
                            @if($errors->has('teamName'))
                                <span class="span text-danger">
                                    {{$errors->first('teamName')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="accounting_register_edit_io">
                        <span>収支</span>
                        <div class="accounting_register_edit_io_switch">
                            <input type="radio" name='io_switch' id='input' value="input"  />
                            <label for="input" class="accounting_register_edit_io_input">収入</label>
                            <input type="radio" name='io_switch' id='output' value="output"  checked/>
                            <label for="output" class="accounting_register_edit_io_output ">支出</label>
                        </div>
                    </div>
                    <div class="form-group mb-4 accounting_register_edit_amount_serial">
                        <div class="accounting_register_edit_amount">
                            <span >金額</span>
                            <input type="text" name="teamName" placeholder="" class="form-control" />
                            @if($errors->has('teamName'))
                                <span class="span text-danger">
                                    {{$errors->first('teamName')}}
                                </span>
                            @endif
                        </div>
                        <div class="accounting_register_edit_serial">
                            <span >レシートNo</span>
                            <input type="text" name="teamName" placeholder="" class="form-control" />
                            @if($errors->has('teamName'))
                                <span class="span text-danger">
                                    {{$errors->first('teamName')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="accounting_register_edit_description">
                        <span>詳細</span>
                        <textarea name = 'description' >asdfasdfasdfadf</textarea>
                    </div>
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn category_register_btn" type="submit">登録する</button>
                    </div>
                </form>
                <div class="accounting_register_edit_preview">
                    <h4>仕分けプレビュー</h4>
                    <table>
                        <tr>
                            <th class="date">発生日</th>
                            <th class="category">項目</th>
                            <th class="io">収支</th>
                            <th class="amount">金額</th>
                            <th class="serial">レシートNo</th>
                        </tr>
                        <tr>
                            <td>2021/10/10</td>
                            <td>保険</td>
                            <td>支出</td>
                            <td>2,000円</td>
                            <td>10</td>
                        </tr>
                    </table>
                    <div class="accounting_register_edit_preview_description">
                        <span>詳細</span>
                        <p>テキストテキストテキストテキストテキストテキストテキストテ
テキストテキストテキストテキストテキストテキストテキスト</p>
                    </div>
                </div>
                <style>
                    
</style>
                
</div>

@endsection('content')