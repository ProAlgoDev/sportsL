@extends('main')
@section('content')
@include('bookDashboardLogo')
@include('leftMenuHeader')
<div class="owner_report_form">
<h3>{{$user->user->name}}</h3>
<p>#{{$user->user->u_id}}-{{$user->team->teamId}}</p>
<div class="owner_report_form">
    <p>へマスター権限引き継ぎ依頼を行いました。<br>
承認されますと、マスターから編集権限へ移行します。<br><br>
承認時間は72時間の制限があります。<br>72時間を過ぎ、承認されなかった場合は、再度、マスター権限引き継ぎ依頼を行なってください。</p>
        <div class="d-grid mx-auto">
            <a class="btn btn-primary register_btn category_register_btn result_btn"  href="{{route('sample.dashboard')}}">ホームへ戻る</a>
        </div>
    </div>
</div>
<script>
    
</script>
@endsection('content')