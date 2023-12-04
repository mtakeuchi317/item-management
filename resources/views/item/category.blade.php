@extends('adminlte::page')

@section('title', 'カテゴリーごとの商品一覧')

@section('content_header')
    <h1>カテゴリーごとの商品一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">カテゴリーごとの商品一覧</h3>
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
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td class="img_name">
                                        <a href="{{ route('itemsinfo', ['id'=>$item->id]) }}">
                                            @if($item->img_name)
                                                <!-- img_name が存在する場合の処理 -->
                                                <img src="{{ $item->img_name }}" alt="Product Image">
                                            @else
                                                <!-- img_name が存在しない場合の処理 -->
                                                <img src="http://design-ec.com/d/e_others_50/m_e_others_500.png" alt="No Image">
                                            @endif
                                        </a>
                                    </td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->author }}</td>
                                    <td>{{ $item->category }}</td>
                                    <!-- 編集ボタン -->
                                    <td>
                                        <form action="{{ route('item/edit', ['id'=>$item->id]) }}" method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary">編集</button>
                                        </form>
                                    </td>
                                    <!-- 削除ボタン -->
                                    <td>
                                        <form action="{{ route('item/delete', ['id'=>$item->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return deleteAlert();">削除</button>
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
    <link href="{{ asset('css/item.css') }}" rel="stylesheet">
@stop

@section('js')
@stop
