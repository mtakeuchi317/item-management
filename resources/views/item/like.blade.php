@extends('adminlte::page')

@section('title', 'お気に入り一覧')

@section('content_header')
    <h1>お気に入り一覧</h1>
@stop

@section('content')

<!-- 編集成功時のメッセージ -->
@if (session('message'))
    <div class="alert alert-success" role="alert">{{ session('message') }}</div>
@endif

<!-- 商品検索 -->
<div class="search">
    <form action="{{route('item/like')}}" method="get">
    @csrf
        <input type="text" class="form-control" name="keyword" value="{{$keyword}}" placeholder="キーワード検索">
        <button type="submit"  class="btn btn-primary">検索</button>
    </form>
</div>
<!-- 商品一覧 -->
<div class="items">
    @foreach($items as $item)
    <div class="item">
        <a href="{{ route('itemsinfo', ['id' => $item->id]) }}">
            @if($item->img_name)
                <img src="{{ $item->img_name }}" class="card-img-top" alt="Product Image">
            @else
                <div class="no-img">
                    <!-- img_name が存在しない場合の処理 -->
                    <img src="http://design-ec.com/d/e_others_50/m_e_others_500.png" alt="No Image">
                </div>
            @endif
        </a>
        <p class="title">{{ $item->title }}</p>
        <p>{{ $item->author }}</p>
        <p>{{ $item->category }}</p>
        <!-- お気に入り解除ボタン -->
        <form action="{{ route('unlike', ['item' => $item->id]) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-secondary btn-sm">お気に入り解除</button>
        </form>
    </div>
    @endforeach
</div>
<div class="paginate">
    {{ $items->links('pagination::bootstrap-5') }}
</div>
@stop

@section('css')
    <link href="{{ asset('css/item.css') }}" rel="stylesheet">
@stop

@section('js')
@stop
