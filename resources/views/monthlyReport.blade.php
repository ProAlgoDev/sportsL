@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{route('accounting_register',[$teamId])}}"><img src="{{asset('images/back.png')}}" alt=""></a>
    </div>
    <div class="left_menu_logo">
        会計登録
    </div>
</div>
@if(session('accountingEdit'))
<div class="accounting_report_modal">

    <form action="{{route('monthly_report',$teamId)}}" method="GET" class="accounting_report_modal_content">
        <h6>会計が登録されました</h6>
        <p>登録した情報の編集を行う場合は、
            月次レポートから編集をお願いします。</p>
            <div class="report_modal_btn">
                {{-- <button type="submit" id="month_report">月次レポートを見る</button> --}}
                <span id="cancel_report_modal">閉じる</span>
            </div>
        </form>
    </div>
@endif
<div class="accounting_register_edit_form">
<form action="{{route('monthly_report_search',[$teamId])}}" method="POST">
                    @csrf
                    <div class="form-group mb-4 accounting_register_edit_input">
                        <div class="monthly_report_year">
                            <span class="">年度</span>
                            <input  id="yearpicker"  name="year" class="form-control  date_icon date-own" 
                              @if(isset($year))
                                value={{$year}}
                                @else
                                value=''
                            @endif>
                            @if($errors->has('year'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('year')}}
                                </span>
                            @endif
                        </div>
                        <div class="monthly_report_year">
                            <span class="">月</span>
                           <input  id="monthpicker"  name="month"  class="form-control  date_icon date-own" 
                           @if(isset($month))
                            value={{$month}}
                            @else
                            value=''
                           @endif>
                            @if($errors->has('month'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('month')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="d-none mx-auto">
                        <button id="report_retrive" type="submit">submit</button>
                    </div>
                </form>
                <div class="accounting_register_edit_preview monthly_report_table">
                    <form id="send_book_id" action='{{route("accounting_edit",[$teamId])}}' class="d-none" method="POST">
                        @csrf
                        <input name="id" id="book_id" type="text">
                        <button id="send_book_id_btn" type="submit"></button>
                    </form>
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
                                <tr class="monthly_report_content_even monthly_report_edit" data-team={{$teamId}}  data-id={{$value->id}}>

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
                                    <tr class="monthly_description_even monthly_report_edit"  data-team={{$teamId}}  data-id={{$value->id}}>
                                        <td colspan="5">{{$value->description}}</td>
                                    </tr>
                                    @endif
                                    @if($key % 2==1)
                                    <tr class="monthly_report_content_odd monthly_report_edit"  data-team={{$teamId}}  data-id={{$value->id}}>
                                        <td>{{$value->changeDate}}</td>
                                        <td>{{$value->item}}</td>
                                        <td>
                                            @if($value->ioType == 0)
                                    収入
                                    @elseif($value->ioType == 1)
                                    支出
                                    @endif
                                </td>
                                <td>{{$value->amount}}円</td>
                                <td>{{$value->serialNumber}}</td>
                            </tr>
                            <tr class="monthly_description_odd monthly_report_edit"  data-team={{$teamId}}  data-id={{$value->id}}>
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
    $(document).ready(function(){
        

        $('#cancel_report_modal').on('click', function(){
            $('.accounting_report_modal').css('display','none');
        })
        
        $('.monthly_report_edit').on('click',function(){
        var id = $(this).data('id');
        var teamId = $(this).data('team');
        $('#book_id').val(id);
        $('#send_book_id_btn').click();

        });
        $('#yearpicker').on('change',function(){
           
           $('#report_retrive').click();
        });
         $('#monthpicker').on('change',function(){
             $('#report_retrive').click();
        });
        $("#yearpicker").datepicker({
         format: "yyyy",
         viewMode: "years", 
         minViewMode: "years",
         autoclose:true //to close picker once year is selected
     });
     $('.accounting_report_modal').click(function(){
        $(this).css('display', 'none');
     });
     $("#monthpicker").datepicker({
         format: "mm",
         viewMode: "months", 
         minViewMode: "months",
         autoclose:true //to close picker once year is selected
     });

    });
</script>

@endsection('content')