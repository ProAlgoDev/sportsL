@extends('main')
@section('content')
<div class="register_container">
    <div class="register_content">
        <div class="register_logo">
            <img src="{{ asset('images/next_logo.png') }}" />
        </div>
        <div class="register_title">
            <h1>チームへの参加（2/3）</h1>
        </div>
        
        <div class="search_team_form">
            @if($team)
            <form action="{{route('validate_team_enter')}}" method="POST">
                @csrf
                <input type="text" name="id" value="{{$team->id}}" hidden>
                <div class="team_info_result">
                    <div class="team_id">
                        <img src="{{asset("images/avatar/$team->teamAvatar")}}" alt="">
                        <div class="">
                            <span>#{{$team->teamId}}</span>
                            <span>{{$team->teamName}}</span>
                        </div>
                    </div>
                    <div class="team_sports">
                        <span>スポーツ</span>
                        <span>{{$team->sportsType}}</span>
                    </div>
                    <div class="team_area">
                        <span>活動エリア</span>
                        <span>{{$team->area}}</span>
                    </div>
                </div>
                <div class="d-grid mx-auto">
                    <button type="submit" class="btn btn-primary register_btn team_enter">参加申請をする</button>
                </div>
            </form>
            @endif
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
    });
</script>
@endsection('content')