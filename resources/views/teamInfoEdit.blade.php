<div class="team_info_edit_form">

<form action="{{route('new_team_create2')}}" method="POST">
                    @csrf
                    <div class="new_team_create1_description">
                        <p>チームプロフィールを 入力してください</p>
                        </div>
                    <div class="form-group mb-4 ">
                        <span>チーム名を入力してください</span>
                        <input type="text" name="teamName" placeholder="" class="form-control" />
                        @if($errors->has('teamName'))
                            <span class="span text-danger">
                                {{$errors->first('teamName')}}
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-4 m_selectlist">
                        <span>スポーツを選んでください</span>
                        <select name="sports_list" id="sports_list" class="form-control">
                            {{-- @foreach ($sportsList as $sports)
                                <option value="{{$sports->sportsId}}">{{$sports->sportsType}}</option>
                            @endforeach --}}
                        </select>
                        @if($errors->has('sports_list'))
                            <span class="span text-danger">
                                {{$errors->first('sports_list')}}
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-4  m_selectlist">
                        <span>活動エリアを選んでください</span>
                        <select name="area_list" id="area_list" class="form-control">
                            {{-- @foreach ($areaList as $area)
                                <option value="{{$area->areaId}}">{{$area->areaName}}</option>
                            @endforeach --}}
                        </select>
                         @if($errors->has('area_list'))
                            <span class="span text-danger">
                                {{$errors->first('area_list')}}
                            </span>
                        @endif
                    </div>
                     <div class="form-group mb-4  m_selectlist">
                        <span>カテゴリを選んでください</span>
                        <select name="age" id="age" class="form-control">
                            <option value="1">12歳以下</option>
                            <option value="2">13-18</option>
                            <option value="3">大学</option>
                            <option value="4">社会人</option>
                        </select>
                        @if($errors->has('age'))
                            <span class="span text-danger">
                                {{$errors->first('age')}}
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-4  m_selectlist">
                        <span>性別を選んでください</span>
                        <select name="sex" id="sex" class="form-control">
                            <option value="1">男子</option>
                            <option value="2">女子</option>
                            <option value="3">混合</option>
                        </select>
                         @if($errors->has('sex'))
                            <span class="span text-danger">
                                {{$errors->first('sex')}}
                            </span>
                        @endif
                    </div>
                    
                    <div class="d-grid mx-auto">
                        <button class="btn btn-primary register_btn" type="submit">確認する</button>
                    </div>
                </form>
</div>
