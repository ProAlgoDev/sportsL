@extends('main')
@section('content')
<div class="register_container">
    <div class="register_content">
        <div class="register_logo">
            <img src="{{ asset('images/next_logo.png') }}" />
        </div>
        <div class="register_title">
            <h1>新規アカウント作成</h1>
        </div>
        <div class="register_progress">
            <img src="{{asset('images/progressbar2.png')}}" alt="">
        </div>
        
        <div class="new_team_create2_form">
                <form action="{{route('new_team_create3')}}" method="POST">
                    @csrf
                    <input name="teamId" value="{{$teamId}}" hidden/>
                    <div class="new_team_create1_description">
                        <p>チームプロフィールを 入力してください</p>
                        </div>
                    <div class="form-group mb-4  m_select">
                        <span>チーム名を入力してください</span>
                        <span class='m_data'>{{$teamName}}</span>
                        <input name="teamName" value="{{$teamName}}" hidden/>
                        @if($errors->has('teamName'))
                            <span class="span text-danger">
                                {{$errors->first('teamName')}}
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-4 m_select">
                        <span>スポーツを選んでください</span>
                        <span class='m_data'>{{$sportsType}}</span>
                        <input name="sportsType" value="{{$sportsType}}" hidden/>

                        @if($errors->has('sportsType'))
                            <span class="span text-danger">
                                {{$errors->first('sportsType')}}
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-4 m_select">
                        <span>活動エリアを選んでください</span>
                        <span class='m_data'>{{$area}}</span>
                        <input name="area" value="{{$area}}" hidden/>
                         @if($errors->has('area'))
                            <span class="span text-danger">
                                {{$errors->first('area')}}
                            </span>
                        @endif
                    </div>
                     <div class="form-group mb-4 m_select">
                        <span>カテゴリを選んでください</span>
                        <span class='m_data'>{{$age}}</span>
                        <input name="age" value="{{$age}}" hidden/>
                        @if($errors->has('age'))
                            <span class="span text-danger">
                                {{$errors->first('age')}}
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-4 m_select">
                        <span>性別を選んでください</span>
                        <span class='m_data'>{{$sex}}</span>
                         @if($errors->has('sex'))
                            <span class="span text-danger">
                                {{$errors->first('sex')}}
                            </span>
                        @endif
                        <input name="sex" value="{{$sex}}" hidden/>
                    </div>
                    
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn" type="submit">完了する</button>
                    </div>
                </form>
                <div class="register_back">
                    <a href="{{route('new_team_create1')}}">戻る</a>
                </div>
        </div>
    </div>
</div>
@endsection('content')