@extends('main')
@section('content')
@include('bookDashboardLogo')
<div class="header_menu_title">
    <div class="left_menu_back">
        <a href="{{route('book_dashboard',[$teamId,'all'])}}"><img src="{{asset('images/back.png')}}" alt=""></a>
    </div>
    <div class="left_menu_logo">
        会計項目登録・編集
    </div>
</div>
@vite('resources/js/app.js')
<div class="accounting_category_register_edit_form">
<form action='{{route("validate_default_category_register",[$teamId])}}' method="POST">
                    @csrf
                    <div class="account_register_edit_category_name">
                        <span>基本項目として以下の登録がされています。</span>
                        <input type="checkbox" id="default_category_show" style="display:none;">
                        <label for="default_category_show" class="default_category_show">>>登録されている基本項目</label>
                        
                        <div id="default_category_list" class="default_category_list">
                            <h4>登録されている基本項目</h4>
                            <div class="default_category_list_content">
                                @foreach($defaultList as $defaultCategory)
                                <span>・{{$defaultCategory}}</span>
                                @endforeach
                            </div>
                            <span onclick="defaultListHidden()" id="default_category_list_hidden">閉じる</span>
                        </div>
                        @if(session('existingName'))
                        <span class="span text-danger">
                               項目名はすでに存在します。
                        </span>
                        @endif
                        </div>
                    <div class="form-group mb-4 account_register_edit_input">
                        <span class="category">登録したい項目名を入力してください</span>
                        <input type="text" name="categoryName" placeholder="" class="form-control" />
                        @if($errors->has('categoryName'))
                            <span class="span text-danger">
                                {{$errors->first('categoryName')}}
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
                        @if($categoryList)
                            @foreach($categoryList as $category)
                            <tr>
                                <td class="category_edit_name" >{{$category}}</td>
                                <td class="category_edit_button" date-category={{$category}}>
                                    <button><img src="{{asset('images/edit-3.svg')}}" /></button>
                                </td>
                                <td class="category_delete_button">
                                    <button><img src="{{asset('images/trash-2.svg')}}" /></button>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="category_edit_name">登録されている項目名がありません。</td>
                                <td class="category_edit_button">
                                </td>
                                <td class="category_delete_button">
                                </td>
                            </tr>
                        @endif
                        
                    </table>
                    <div class="category_edit_btn">
                        <button id="sendCategoriesButton" class="btn btn-primary register_btn category_register_btn">保存する</button>
                    </div>
                </div>
</div>
<script>
    function defaultListHidden(){
        document.getElementById('default_category_list').style.display = 'none';
        document.getElementById('default_category_show').checked = false;
    }
    $(document).ready(function() {
       $('.category_edit_button').on('click', function(){
        var row = $(this).closest('tr');
        var categoryName = row.find('.category_edit_name').text().trim();
        var inputElement = $('<input type = "text", class="category_input" value="' + categoryName + '">');
        var divElement = $('<div class="category_edit_div">');
        var buttonElement = $('<button class="save_button">編集</button>');
        var spanElement = $('<span class="text-danger alert_existing_name"></span>');
        divElement.append(inputElement);
        divElement.append(buttonElement);
        divElement.append(spanElement);
        row.append(divElement);
        $('.save_button').on('click', function() {
            var newValue = $(this).siblings('.category_input').val();
            let existingName = false;
            
            console.log(categoryName)
            $('.category_edit_name').each(function() {
                if(newValue == $(this).text().trim() && newValue != categoryName)  {
                    spanElement.text('すでに存在する名前です。');
                    spanElement.css('background','white');
                    existingName = true;
                }
            });
            if(!existingName){
                $(this).closest('tr').find('.category_edit_name').text(newValue);
                $(this).closest('div').remove();
            }
        });
       });
    });
</script>
@endsection('content')