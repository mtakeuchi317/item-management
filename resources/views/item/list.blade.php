@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧（管理）<{{ isset($category) ? $category : 'すべての商品' }}></h1>
@stop

@section('content')
<!-- 編集成功時のメッセージ -->
@if ( session('message') )
    <div class="alert alert-success" role="alert">{{ session('message') }}</div>
@endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <!-- 並べ替え用のドロップダウンリスト -->
                            <form id="form">
                                <select class="btn btn-secondary dropdown-toggle" name="sort_by" id="sort_by">
                                    <option value="1" {{ $select == '1' ? 'selected': '' }}>登録が新しい順</option>
                                    <option value="2" {{ $select == '2' ? 'selected': '' }}>登録が古い順</option>
                                    <option value="3" {{ $select == '3' ? 'selected': '' }}>お気に入り数が多い順</option>
                                    <option value="4" {{ $select == '4' ? 'selected': '' }}>お気に入り数が少ない順</option>
                                </select>
                            </form>
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
                                <th>お気に入り数</th>
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
                                    </td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->author }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->likes_count }}</td>
                                    <!-- 編集ボタン -->
                                    <td>
                                        <form action="{{route('item/edit',['id'=>$item->id])}}" method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary">編集</button>
                                        </form>
                                    </td>
                                    <!-- 削除ボタン -->
                                    <td>
                                        <form action="{{route('item/delete',['id'=>$item->id])}}" method="post">
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
    <div class="paginate">
    {{ $items->links('pagination::bootstrap-5') }}
    </div>
@stop

@section('css')
    <link href="{{ asset('css/item.css') }}" rel="stylesheet">
@stop

@section('js')
    <script src="{{ asset('/js/item.js') }}"></script>
@stop
