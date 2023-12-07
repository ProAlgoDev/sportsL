@extends('main')
@section('content')
<div class="register_container">
    <div class="register_content">
        <div class="register_logo">
            <img src="{{ asset('images/next_logo.png') }}" />
        </div>
        <div class="register_title">
            <h1>チームへの参加（1/3）</h1>
        </div>
        <div class="search_team_form">
                    <div class="form-group mb-4 search_input">
                        <form action="validate_search_team" method="POST">
                            @csrf
                            <input type="number" name="search" placeholder="チームIDを入力で検索" class="form-control" />
                            @if($errors->has('search'))
                                <span class="span text-danger">
                                    {{$errors->first('search')}}
                                </span>
                            @endif
                            <button class="search_team_btn d-none"></button>
                        </form>
                    </div>
                    <div class="team_list">
                        @if(session('teamError'))
                <span class="span text-danger">
                        あなたはすでにチーム参加申請を送信しています。
                </span>
            @endif
                        @if(count($teamList) > 0)
                        @foreach($teamList as $team)
                            <form action="{{route('search_team2')}}" method="POST" class="team">
                                @csrf
                                <input type="text" name="id" value="{{$team->id}}" hidden>
                                <img src='{{asset("images/avatar/$team->teamAvatar")}}' alt="">
                                <div class="team_info">
                                    <span>{{$team->teamName}}</span>
                                    <span>{{$team->area}}</span>
                                </div>
                                <div class="teamId">
                                    #{{$team->teamId}}
                                </div>
                            </form>
                        @endforeach
                        @else
                         <div class="">チームがありません</div>
                        @endif
                    </div>
                <div class="register_back">
                    <a href="{{route('sample.dashboard')}}">戻る</a>
                </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('[name="search"]').on('change', function(){
            $('.search_team_btn').click();
        });
        $('.team').click(function(){
            $(this).submit()
        });
    });
</script>
@endsection('content')