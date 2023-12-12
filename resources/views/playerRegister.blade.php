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

<div class="player_register_form">

<form action="{{route('validate_player_register',[$teamId])}}" method="POST">
                    @csrf
                    <div class="player_name input_form">
                            <span class="">氏名</span>
                            <input type="text" name="playerName" placeholder="" class="form-control" />
                        </div>
                        @if($errors->has('playerName'))
                            <span class="span text-danger text-center d-block">
                                {{$errors->first('playerName')}}
                            </span>
                        @endif
                    <div class="player_gender input_form">
                            <span class="">性別</span>
                            <select name="gender" id="gender" class="form-control triangle_icon">
                            <option value="1">男</option>
                            <option value="2">女</option>
                            <option value="3">混合</option>
                        </select>
                    </div>
                    @if($errors->has('gender'))
                       <span class="span text-danger text-center d-block">
                           {{$errors->first('gender')}}
                       </span>
                   @endif
                    <div class="player_enter_date input_form">
                            <span class="">参加日</span>
                            <input type="date" name="createdDate" placeholder="01-01-2023" class="form-control date_icon" />
                        </div>
                        @if($errors->has('createdDate'))
                            <span class="span text-danger text-center d-block">
                                {{$errors->first('createdDate')}}
                            </span>
                        @endif
                    <div class="d-grid mx-auto mt-4">
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
                    <table class="player_edit register_table">
                        <tr>
                            <th class="name">氏名</th>
                            <th class="gender">性別</th>
                            <th class="date">参加日</th>
                            <th class="status"></th>
                        </tr>
                        @if($register)
                            @foreach($register as $item)
                            <tr data-id={{$item->id}}>
                                <td class="player_name">{{$item->name}}</td>
                                <td class="player_gender">{{$item->gender}}</td>
                                <td class="player_date">{{$item->createdDate}}</td>
                                <td>
                                    <a data-type="edit" class="player_edit_btn">
                                        <img src="{{asset('images/edit-3.svg')}}" alt="">
                                    </a>
                                    <a data-type="invisible" class="player_edit_btn">
                                        <img src="{{asset('images/eye-off.svg')}}" alt="">
                                    </a>
                                    <a data-type="delete" class="player_edit_btn">
                                        <img src="{{asset('images/trash-2.svg')}}" alt="">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        
                    </table>

                    <table class="player_edit archive_table">
                        <tr>
                            <th class="name">氏名</th>
                            <th class="gender">性別</th>
                            <th class="date">参加日</th>
                            <th class="status"></th>
                        </tr>
                        @if($archive)
                            @foreach($archive as $item)
                            <tr data-id={{$item->id}}>
                                <td class="player_name">{{$item->name}}</td>
                                <td class="player_gender">{{$item->gender}}</td>
                                <td class="player_date">{{$item->createdDate}}</td>
                                <td>
                                    <a data-type="visible" class="player_edit_btn">
                                        <img src="{{asset('images/eye.svg')}}" alt="">
                                    </a>
                                    <a data-type="delete" class="player_edit_btn">
                                        <img src="{{asset('images/trash-2.svg')}}" alt="">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        
                    </table>
                    <div class="category_edit_btn">
                        <button class="btn btn-primary register_btn category_register_btn" id="player_edit_save">保存する</button>
                    </div>
                </div>
</div>
<script>
    let editList=[]
    let archiveList=[]
    let deleteList=[]
    let visibleList =[]
    var currentURL = window.location.href;
    var teamId = currentURL.substring(currentURL.lastIndexOf('/') + 1);
    $(document).ready(function(){
        var archiveTable = $('.archive_table tr:last');
        var registerTable = $('.register_table tr:last');
        $('input[name="playerStyle"]').change(function() {
      var value = $(this).attr('id');
      if(value == 'register'){
        $('.register_table').css('display','block');
        $('.archive_table').css('display','none');
      }
      if(value == 'archive'){
        $('.register_table').css('display','none');
        $('.archive_table').css('display','block');
      }
    });

    $('.player_edit_btn').click(function(){
        var row = $(this).closest('tr');
        var id = row.data('id');
        var status = $(this).data('type');
        var oldName = row.find('.player_name');
        var oldGender = row.find('.player_Gender');
        var oldDate = row.find('.player_date');
        let edit = {}
        
        if (status == 'edit'){
            var divElement = $('<div class="player_edit_modal"></div>');
            var btnElement = $('<button class="player_edit_modal_btn">保存</button>');
            var nameElement = $('<input class="player_edit_modal_name" value="'+oldName.text().trim()+'"/>');
            var genderElement = $('<select class="player_edit_modal_gender"><option>男</option><option>女</option><option>混合</option></select>');
            var dateElement = $('<input class="player_edit_modal_date date-icon" value="'+oldDate.text().trim()+'" type="date" />');
            var spanElement = $('<span class="player_edit_modal_danger text-danger" >すべてのフィールドは必須です</span>');
            divElement.append(nameElement);
            divElement.append(genderElement);
            divElement.append(dateElement);
            divElement.append(btnElement);
            divElement.append(spanElement);
            row.append(divElement);
            btnElement.click(function(){
                name = nameElement.val();
                gender = genderElement.val();
                date = dateElement.val();
                if(name!='' && gender!='' && date!=''){
                    edit['id'] = id;
                    edit['name'] = name;
                    edit['gender'] = gender;
                    edit['date'] = date;
                    editList.push(edit);
                    oldName.text(name);
                    oldDate.text(date);
                    oldGender.text(gender);
                    divElement.remove();
                }else{
                    spanElement.css('display', 'block');
                    btnElement.css('background','red');
                }
            });
        }
        if(status=='invisible'){
            archiveList.push(id);
            row.remove();
        }
        if(status=='visible'){
            visibleList.push(id);
            row.remove();

        }
        if(status == 'delete'){
            deleteList.push(id);
            row.remove();
        }
    });
    $('#player_edit_save').click(function(){
        $.ajax({
            type: "POST",
            url: `/validate_player_register_edit/${teamId}`,
            data:{
                editList:editList,
                archiveList:archiveList,
                deleteList:deleteList,
                visibleList:visibleList,
                _token:'{{csrf_token()}}'
            },
            success: function(response) {
                    window.location.reload();
                    console.log('successfully', response);       
            },
            error: function(error) {
                window.location.reload();
                console.error('Error', error);              
            }

        });
    });
    });
    </script>
@endsection('content')