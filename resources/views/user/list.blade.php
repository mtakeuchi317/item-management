@extends('adminlte::page')

@section('title', '会員一覧')

@section('content_header')
    <h1>会員一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">会員一覧</h3>
                    <!-- <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th>フリガナ</th>
                                <th>性別</th>
                                <th>誕生日</th>
                                <th>電話番号</th>
                                <th>メールアドレス</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->name_kana }}</td>
                                    <td>{{ $user->gender }}</td>
                                    <td>{{ $user->birthday }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td></td>
                                    <td></td>
                                    <!-- 編集ボタン -->
                                    <td>
                                        <form action="{{route('user/edit',['id'=>$user->id])}}" method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary">編集</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
@stop

@section('js')
@stop
