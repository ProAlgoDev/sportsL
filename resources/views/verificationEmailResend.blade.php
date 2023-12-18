@extends('main')
@section('content')
<div class="register_container">
    <div class="register_content">
        <div class="register_logo">
            <img src="{{ asset('images/next_logo.png') }}" />
        </div>
        <div class="register_title">
            <h1>メール認証</h1>
        </div>
       
        
        <div class="register_form">
                <h2 class='resend_email_content'>登録しているEmailを入力し、<br>
送信してください。</h2>
                
               <form action="{{route('verify.validate_resend_email')}}" method="POST">
                    @csrf
                    <div class="form-group mb-4 re_input_form">
                        <img src="{{asset('images/email.png')}}" />
                        <input type="text" name="email" placeholder="Email" class="form-control" />
                        @if(session('error'))
                            <span class="text-danger">{{session('error')}}</span>
                        @endif
                        @if($errors->has('email'))
                            <span class="text-danger">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn btn_280px" type="submit">送信する</button>
                    </div>
                </form>
                <div class="register_back">
                    <a href="{{route('validate_back')}}">戻る</a>
                </div>
        </div>
    </div>
</div>
@endsection('content')