@extends('adminlte::page')

@section('title', '会員情報編集')

@section('content_header')
    <h1>会員情報編集</h1>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('会員情報編集') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user/edit', ['id' => $user->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('名前') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name_kana" class="col-md-4 col-form-label text-md-end">{{ __('フリガナ') }}</label>

                            <div class="col-md-6">
                                <input id="name_kana" type="text" class="form-control @error('name_kana') is-invalid @enderror" name="name_kana" value="{{ $user->name_kana }}" required autocomplete="name_kana" autofocus>

                                @error('name_kana')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                        <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('性別') }}</label>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_male" value="男" {{ $user->gender === '男' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender_male">{{ __('男') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_female" value="女" {{ $user->gender === '女' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender_female">{{ __('女') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_not_specified" value="未回答"  {{ $user->gender === '未回答' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender_not_specified">{{ __('未回答') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">    
                            <label for="birthday" class="col-md-4 col-form-label text-md-end">生年月日<span class="badge text-bg-danger">必須</span></label>
                                <div class="col-md-6" >
                                    <input class="form-control" type="date" name="birthday"  id="birthday" value="{{ $user->birthday }}">
                                        <!-- バリデーション表示 -->
                                        @if($errors->has('birthday'))
                                        <tr>
                                            @foreach($errors->get('birthday') as $message)
                                            <td> <p class="text-danger">{{ $message }} </P></td>
                                            @endforeach
                                        </tr>
                                        @endif
                                </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('電話番号') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('メールアドレス') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="isAdmin" class="col-md-4 col-form-label text-md-end">{{ __('権限') }}</label>
                            <div class="col-md-6">
                                <select id="isAdmin" class="form-control @error('isAdmin') is-invalid @enderror" name="isAdmin" required autocomplete="isAdmin">
                                    <option value="1" @if($user->isAdmin == 1) selected @endif>管理者</option>
                                    <option value="2" @if($user->isAdmin == 2) selected @endif>ユーザー</option>
                                </select>
                                @error('isAdmin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('更新') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
