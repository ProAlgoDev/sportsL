@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{route('accounting_register',[$teamId])}}"><img src="{{asset('images/back.png')}}" alt=""></a>
    </div>
    <div class="left_menu_logo">
        会計項目登録・編集
    </div>
</div>
<div class="accounting_category_edit_btn">
    <a href="{{route('monthly_report',$teamId)}}">編集</a>
</div>
<div class="accounting_register_edit_form">

<form action="{{route('validate_accounting_register',[$teamId])}}" method="POST">
                    @csrf
                    <div class="form-group mb-4 accounting_register_edit_input">
                        <div class="accounting_register_edit_date">
                            <span class="">日付</span>
                            <input  id="yearpicker"  name="inputDate" placeholder="" class="form-control  date_icon date-own" />
                            @if($errors->has('inputDate'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('inputDate')}}
                                </span>
                            @endif
                        </div>
                        <div class="accounting_register_edit_category">
                            <span class="">会計項目</span>
                           <input  id="monthpicker"  name="inputDate" placeholder="" class="form-control  date_icon date-own" />
                            @if($errors->has('categoryList'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('categoryList')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="accounting_register_edit_io">
                        <span>収支</span>
                        <div class="accounting_register_edit_io_switch">
                            <input type="radio" name='io_switch' id='input' value="0"  />
                            <label for="input" class="accounting_register_edit_io_input">収入</label>
                            <input type="radio" name='io_switch' id='output' value="1"  checked/>
                            <label for="output" class="accounting_register_edit_io_output ">支出</label>
                        </div>
                         @if($errors->has('io_switch'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('io_switch')}}
                                </span>
                            @endif
                    </div>
                    <div class="form-group mb-4 accounting_register_edit_amount_serial">
                        <div class="accounting_register_edit_amount">
                            <span >金額</span>
                            <input type="text" pattern="\d+(\.\d+)?" name="amount" placeholder="" class="form-control" />
                            @if($errors->has('amount'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('amount')}}
                                </span>
                            @endif
                        </div>
                        <div class="accounting_register_edit_serial">
                           
                        </div>
                    </div>
                    <div class="accounting_register_edit_description">
                        <span>詳細</span>
                        <textarea name = 'description' ></textarea>
                        @if($errors->has('description'))
                                <span style="width:100%;" class="span text-danger">
                                    {{$errors->first('description')}}
                                </span>
                            @endif
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
                            <td id="previewDate"></td>
                            <td id="previewCategory"></td>
                            <td id="previewIo"></td>
                            <td id="previewAmount"></td>
                            <td id="previewSerial"></td>
                        </tr>
                    </table>
                    <div class="accounting_register_edit_preview_description">
                        <span>詳細</span>
                        <p id="previewDescription"></p>
                    </div>
                </div>
                <style>
                    
</style>
                
</div>
<script>
   $("#yearpicker").datepicker({
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years",
    autoclose:true //to close picker once year is selected
});

$("#monthpicker").datepicker({
    format: "mm",
    viewMode: "months", 
    minViewMode: "months",
    autoclose:true //to close picker once year is selected
});
</script>

@endsection('content')