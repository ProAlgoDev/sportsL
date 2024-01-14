@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{route('monthly_report',[$teamId,'all'])}}"><img src="{{asset('images/back.png')}}" alt=""></a>
    </div>
    <div class="left_menu_logo">
        会計登録
    </div>
</div>
<div class="accounting_category_edit_btn">
    <a href="{{route('monthly_report',$teamId)}}">編集</a>
</div>
<div class="accounting_edit_form">


<form action="{{route('validate_accounting_edit',[$teamId])}}" method="post">
                    @csrf
                    <input type="text" name='itemId' value="{{$id}}" class="d-none">
                    <div class="form-group accounting_edit_input">
                        <div class="accounting_edit_date">
                            <span class="">日付</span>
                            <input type="date" name="inputDate" placeholder="" value="{{$book->changeDate}}" class="form-control  date_icon" />
                            @if($errors->has('inputDate'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('inputDate')}}
                                </span>
                            @endif
                        </div>
                        <div class="accounting_edit_category">
                            <span class="">会計項目</span>
                            <select name="categoryList" placeholder="" class="form-control select_template triangle_icon" >
                                @if($categoryList)
                                @foreach($categoryList as $category)
                                <option {{$category == $book->item ? 'selected': ''}}>{{$category}}</option>
                                @endforeach
                                @endif
                            </select>
                            <input name="baseCategory" value={{$book->item}} hidden/>
                            @if($errors->has('categoryList'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('categoryList')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="accounting_edit_io">
                        <span>収支</span>
                        <div class="accounting_register_edit_io_switch">
                            <input type="radio" name='io_switch' id='input' value="0"  {{$book->ioType == "0"?'checked': ''}}/>
                            <label for="input" class="accounting_register_edit_io_input">収入</label>
                            <input type="radio" name='io_switch' id='output' value="1"  {{$book->ioType == "1"?'checked': ''}}/>
                            <label for="output" class="accounting_register_edit_io_output ">支出</label>
                        </div>
                         @if($errors->has('io_switch'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('io_switch')}}
                                </span>
                            @endif
                    </div>
                    <div class="form-group accounting_edit_amount_serial">
                        <div class="accounting_edit_amount">
                            <span >金額</span>
                            <input type="text" value="{{$book->amount}}" pattern="\d+(\.\d+)?" name="amount" placeholder="" class="form-control" />
                            @if($errors->has('amount'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('amount')}}
                                </span>
                            @endif
                        </div>
                        <div class="accounting_edit_serial">
                            <span >レシートNo</span>
                            <input type="text" value="{{$book->serialNumber}}" name="serial" placeholder="" class="form-control"/>
                            @if($errors->has('serial'))
                                <span style="width:166px; display:block;" class="span text-danger">
                                    {{$errors->first('serial')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="accounting_edit_description">
                        <span>詳細</span>
                        <textarea name = 'description' >{{$book->description}}</textarea>
                        @if($errors->has('description'))
                                <span style="width:100%;" class="span text-danger">
                                    {{$errors->first('description')}}
                                </span>
                            @endif
                    </div>
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn category_register_btn mt-3" type="submit">登録する</button>
                    </div>
                </form>
</div>
<script>
    $(document).ready(function(){
        
        $('#cancel_report_modal').on('click', function(){
            $('.accounting_report_modal').css('display','none');
        })
    });
</script>

@endsection('content')