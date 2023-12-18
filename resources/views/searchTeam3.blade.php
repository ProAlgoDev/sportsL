@extends('main')
@section('content')
<div class="register_container">
    <div class="register_content">
        <div class="register_logo">
            <img src="{{ asset('images/next_logo.png') }}" />
        </div>
        <div class="register_title">
            <h1>チームへの参加（3/3）</h1>
        </div>
        
        <div class="team_enter_form">
            @if($team)
                <div class="team_enter_sent">
                    <img src="{{asset("images/sent.png")}}" alt="">
                    <span>
                        {{$team->teamName}}<br>
                        へ参加申請を行いました。<br><br>
                        承認後、チームページへ<br>
                        アクセスできるようになります。
                    </span>
                </div>
                <div class="d-grid mx-auto">
                    <a href="{{route('sample.dashboard')}}" class="btn btn-primary btn_280px register_btn team_enter">チームトップへ</a>
                </div>
            @endif
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