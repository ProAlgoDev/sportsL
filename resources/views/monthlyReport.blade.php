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

<div class="accounting_register_edit_form">
<form action="{{route('validate_accounting_register',[$teamId])}}" method="POST">
                    @csrf
                    <div class="form-group mb-4 accounting_register_edit_input">
                        <div class="monthly_report_year">
                            <span class="">年度</span>
                            <input  id="yearpicker"  name="year" placeholder="" class="form-control  date_icon date-own" />
                            @if($errors->has('year'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('year')}}
                                </span>
                            @endif
                        </div>
                        <div class="monthly_report_year">
                            <span class="">月</span>
                           <input  id="monthpicker"  name="month" placeholder="" class="form-control  date_icon date-own" />
                            @if($errors->has('month'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('month')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="d-none mx-auto">
                        <button id="report_retrive" type="submit"></button>
                    </div>
                </form>
                <div class="accounting_register_edit_preview monthly_report_table">
                    <table>
                            <tr>
                                <th class="date">発生日</th>
                                <th class="category">項目</th>
                                <th class="io">収支</th>
                                <th class="amount">金額</th>
                                <th class="serial">レシートNo</th>
                            </tr>
                            @if($book)
                            @foreach($book as $key=>$value)
                            @if($key % 2==0)
                                <tr class="monthly_report_content_even">
                                        <td>{{$value->changeDate}}</td>
                                        <td>{{$value->item}}</td>
                                        <td>
                                            @if($value->ioType == 0)
                                            収入
                                            @elseif($value->ioType ==1)
                                            支出
                                            @endif
                                        </td>
                                        <td>{{$value->amount}}円</td>
                                        <td>{{$value->serialNumber}}</td>
                                    </tr>
                                    <tr class="monthly_description_even">
                                        <td colspan="5">{{$value->description}}</td>
                                    </tr>
                                    @endif
                                    @if($key % 2==1)
                                    <tr class="monthly_report_content_odd" >
                                        <td>{{$value->changeDate}}</td>
                                        <td>{{$value->item}}</td>
                                        <td>
                                            @if($value->ioType == 0)
                                    収入
                                    @elseif($value->ioType ==1)
                                    支出
                                    @endif
                                </td>
                                <td>{{$value->amount}}円</td>
                                <td>{{$value->serialNumber}}</td>
                            </tr>
                            <tr  style="" class="monthly_description_odd">
                                <td colspan="5">{{$value->description}}</td>
                            </tr>
                            @endif
                            @endforeach
                            @endif
                          
                        </table>
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