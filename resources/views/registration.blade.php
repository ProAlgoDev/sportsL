@extends('main')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Registartion
            </div>
            <div class="card-body">
                <form action="{{route('sample.validate_registration')}}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="text" name="name" placeholder="Name" class="form-control" />
                        @if($errors->has('name'))
                            <span class="span text-danger">
                                {{$errors->first('name')}}
                            </span>
                        @endif
                        
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" name="email" placeholder="Email" class="form-control" />
                        @if($errors->has('email'))
                            <span class="text-danger">{{$errors->has('email')}}</span>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" name="password" class="form-control" />
                        @if($errors->has('password'))
                            <span class="text-danger">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                    <div class="d-grid mx-auto">
                        <button class="btn btn-dark btn-block" type="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection('content')