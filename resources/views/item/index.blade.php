@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>画像</th>
                                <th>タイトル</th>
                                <th>作者</th>
                                <th>カテゴリー</th>
                                <th>詳細</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @if($item->img_name)
                                        <img src="{{ $item->img_name }}" alt="Product Image">
                                        @else
                                            <div class="no-img">
                                                <p>No Image</p>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->author }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->detail }}</td>
                                    <!-- 編集ボタン -->
                                    <td>
                                        <form action="{{route('item/edit',['id'=>$item->id])}}" method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary">編集</button>
                                        </form>
                                    </td>
                                    <!-- 削除ボタン -->
                                    <td>
                                        
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
@stop

@section('js')
@stop
