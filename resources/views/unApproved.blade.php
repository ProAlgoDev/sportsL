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
        
        <div class="search_team_form">
           
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