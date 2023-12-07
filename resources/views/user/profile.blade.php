@extends('adminlte::page')

@section('title', 'プロフィール')

@section('content_header')
    <h1>プロフィール</h1>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('プロフィール') }}</div>

                <div class="card-body">
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('名前') }}</label>

                        <div class="col-md-6">
                            <p>{{ $user->name }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="name_kana" class="col-md-4 col-form-label text-md-end">{{ __('フリガナ') }}</label>

                        <div class="col-md-6">
                            <p>{{ $user->name_kana }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('性別') }}</label>
                        
                        <div class="col-md-6">
                            <p>{{ $user->gender }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="birthday" class="col-md-4 col-form-label text-md-end">生年月日</label>
                        
                        <div class="col-md-6">
                            <p>{{ $user->birthday }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('電話番号') }}</label>

                        <div class="col-md-6">
                            <p>{{ $user->phone }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('メールアドレス') }}</label>

                        <div class="col-md-6">
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
                <form action="{{route('user/profile_edit',['id'=>$user->id])}}" method="get">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary">編集</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
