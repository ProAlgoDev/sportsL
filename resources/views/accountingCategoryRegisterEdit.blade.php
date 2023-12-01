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
                                <span>・{{$defaultCategory->defaultCategory}}</span>
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
                                <td class="category_edit_name" >{{$category->categoryList}}</td>
                                <td class="category_edit_button" data-category={{$category->categoryList}} data-status={{$category->status}}>
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
                                <td class="">
                                </td>
                                <td class="">
                                </td>
                            </tr>
                        @endif
                    </table>
                    <div class="alert_delete_category">
                        <h6>項目を削除できません</h6>
                        <p>この項目は帳簿で利用されているため
削除することができません。<br>

新しい項目名へ変更するか、帳簿で利用されている項目を全て削除してください。</p>
<span id="cancel_alert_delete">閉じる</span>
                    </div>
                    <div class="category_edit_btn">
                        <button id="sendCategoriesButton" class="btn btn-primary register_btn category_register_btn">保存する</button>
                    </div>
                </div>
</div>
<script>

var categoryList = {};
var dCategoryList = {};
    var currentURL = window.location.href;

var teamId = currentURL.substring(currentURL.lastIndexOf('/') + 1);

function defaultListHidden(){
    document.getElementById('default_category_list').style.display = 'none';
    document.getElementById('default_category_show').checked = false;
}
$(document).ready(function() {
    $('.category_edit_button').on('click', function(){
        var row = $(this).closest('tr');
        var categoryData = row.find('.category_edit_button').data('category');
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
            
            $('.category_edit_name').each(function() {
                if(newValue == $(this).text().trim() && newValue != categoryName)  {
                    spanElement.text('すでに存在する名前です。');
                    spanElement.css('background','white');
                    existingName = true;
                }
            });
            if(!existingName){
                if(categoryData !=newValue){
                    categoryList[categoryData] = newValue;
                }
                $(this).closest('tr').find('.category_edit_name').text(newValue);
                $(this).closest('div').remove();
            }
        });
       });

       $('.category_delete_button').on('click', function(){
        var row = $(this).closest('tr');
        var categoryStatus = row.find('.category_edit_button').data('status');
        var categoryData = row.find('.category_edit_button').data('category');
        if(categoryStatus == 0){
            dCategoryList[categoryData] = categoryData;
            row.remove();
        }else if(categoryStatus == 1){
            $('.alert_delete_category').css('display','block');
        }
       });

       $('#cancel_alert_delete').on('click',function(){
         $('.alert_delete_category').css('display','none');
       });
       $('#sendCategoriesButton').on('click', function() {
            if(Object.keys(categoryList).length != 0 || Object.keys(dCategoryList).length != 0){
                $.ajax({
                type: 'POST',
                url: `/validate_category_name_edit/${teamId}`,
                data: { categoryList: categoryList ,
                    deleteCategory: dCategoryList,
                    _token: '{{csrf_token()}}'
                },
                success: function(response) {
                    // window.location.reload();
                    console.log('Category sent successfully', response);       
                },
                error: function(error) {
                    // window.location.reload();
                    console.error('Error sending category', error);              
                }
            });
            }
       });
    });
</script>
@endsection('content')