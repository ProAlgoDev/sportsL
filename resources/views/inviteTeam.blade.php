@extends('main')
@section('content')
@include('bookDashboardLogo')
@include('leftMenuHeader')

<div class="invite_team_form">

<form action="{{route('new_team_create2')}}" method="POST">
                    @csrf
                    <h4>招待したい人のメールアドレスを入力</h4>
                    <div class="form-group mb-4">
                        <input type="text" name="email" placeholder="Email" class="form-control" />
                        @if($errors->has('email'))
                            <span class="text-danger">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn category_register_btn" type="submit">招待する</button>
                    </div>
                </form>
</div>

@endsection('content')