@extends('main')
@section('content')
@include('bookDashboardLogo')
@include('leftMenuHeader')
<div class="team_info_edit_form">

<form action="{{route('new_team_create2')}}" method="POST">
                    @csrf
                    <div class="new_team_create1_description">
                        <h3>会計初期設定</h3>
                        </div>
                    <div class="form-group mb-4 team_edit_info_detail">
                        <span>初期金額</span>
                        <input type="text" name="teamName" placeholder="" class="form-control" />
                        @if($errors->has('teamName'))
                            <span class="span text-danger">
                                {{$errors->first('teamName')}}
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-4 team_edit_info_detail">
                        <span>年  月</span>
                        <input  name="teamName" id="calendar" placeholder="" class="form-control" />
                        @if($errors->has('teamName'))
                            <span class="span text-danger">
                                {{$errors->first('teamName')}}
                            </span>
                        @endif
                    </div>
                              
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn" type="submit">変更する</button>
                    </div>
                </form>
</div>
<script>
    // Enable the year and month picker
    jSuites.calendar(document.getElementById('calendar'), {
        type: 'year-month-picker',
        format: 'YYYY-MM',
        validRange: ['2000-02-01', '2024-12-31'],
    });
</script>
@endsection('content')