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
<div class="accounting_category_edit_btn">
    <a href="{{route('monthly_report',$teamId)}}">編集</a>
</div>
<div class="accounting_register_edit_form">
@if(session('accountingRegister'))
<form action="{{route('monthly_report',$teamId)}}" method="GET" class="accounting_report_modal">
    <h6>会計が登録されました</h6>
    <p>登録した情報の編集を行う場合は、
月次レポートから編集をお願いします。</p>
    <div class="report_modal_btn">
        <button type="submit" id="month_report">月次レポートを見る</button>
        <span id="cancel_report_modal">閉じる</span>
    </div>
</form>
@endif

<form action="{{route('validate_accounting_register',[$teamId])}}" method="POST">
                    @csrf
                    <div class="form-group mb-4 accounting_register_edit_input">
                        <div class="accounting_register_edit_date">
                            <span class="">日付</span>
                            <input type="date" name="inputDate" placeholder="" class="form-control  date_icon" />
                            @if($errors->has('inputDate'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('inputDate')}}
                                </span>
                            @endif
                        </div>
                        <div class="accounting_register_edit_category">
                            <span class="">会計項目</span>
                            <select name="categoryList" placeholder="" class="form-control select_template triangle_icon" >
                                @if($categoryList)
                                @foreach($categoryList as $category)
                                <option>{{$category}}</option>
                                @endforeach
                                @endif
                            </select>
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
                            <span >レシートNo</span>
                            <input type="text" value="{{$teamId}}_{{$serial}}" name="serial" placeholder="" class="form-control" readonly/>
                            @if($errors->has('serial'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('serial')}}
                                </span>
                            @endif
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
    $(document).ready(function(){
        const currentTimestampInSeconds = Math.floor(Date.now() / 1000);
console.log(currentTimestampInSeconds);
        var serialId = $('input[name="serial"]').val();
        var serial = $('#previewSerial').text(serialId);
        $('input[name="inputDate"]').change(function()
        {
            $('#previewDate').text($(this).val());
        });
         $('select[name="categoryList"]').change(function()
        {
            $('#previewCategory').text($(this).val());
        });

        $('input[name="amount"]').change(function()
        {
            $('#previewAmount').text($(this).val()+"円");
        });
        $('input[name="serial"]').change(function()
        {
            $('#previewSerial').text($(this).val());
        });
        $('input[name="io_switch"]').change(function()
        {
            if($(this).val() == 0){
                $('#previewIo').text('収入');
            }
            if($(this).val() ==1){
                $('#previewIo').text('支出');
            }
        });
        $('textarea[name="description"]').change(function()
        {
            $('#previewDescription').text($(this).val());
        });

        $('#cancel_report_modal').on('click', function(){
            $('.accounting_report_modal').css('display','none');
        })
    });
</script>

@endsection('content')