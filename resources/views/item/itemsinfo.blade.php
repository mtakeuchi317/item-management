@extends('adminlte::page')

@section('title', '商品情報')

@section('content_header')
    <h1>商品情報</h1>
@stop

@section('content')
    <div class="container">


        <!-- 商品詳細ページのメイン(メインコンテナ)部分 -->
        <div class="itemsinfo-main">
            <!-- メインコンテンツの左側(商品画像とプライス) -->
            <div class="product-image">
                @if (!empty($info->img_name))
                    <!-- img_name が存在する場合の処理 -->
                    <img src="{{ $info->img_name }}" alt="{{ $info->img_name }}" class="img-large">
                @else
                    <!-- img_name が存在しない場合の処理 -->
                    <img src="http://design-ec.com/d/e_others_50/m_e_others_500.png" alt="No Image" class="img-large">
                @endif
            </div>

            <!-- メインコンテンツの右側(メーカー名、商品カテゴリ、型番、コメント) -->
            <div class="product-details">
                <ul>
                    <li style="font-weight: bold; font-size: x-large;">{{ $info->title }}</li>
                    <li>{{ $info->author }} 著</li>
                    <li>カテゴリー：{{ $info->category }}</li>
                    <li>{{ $info->detail }}</li>
                </ul>
                <!-- 編集ボタン -->
                <form action="{{route('item/edit',['id'=>$info->id])}}" method="get">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary">編集</button>
                </form>
                <!-- 削除ボタン -->
                <form action="{{route('item/delete',['id'=>$info->id])}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" onclick="return deleteAlert();">削除</button>
                </form>
            </div>
        </div>
        <div class="page-link">
            <a href="#">前のページ</a>
            <a href="#">次のページ</a>
            <a href="{{ route('index') }}" class="back-link">商品一覧へ戻る</a>
        </div>

    </div>

@stop

@section('css')
<link href="{{ asset('css/item.css') }}" rel="stylesheet">
@stop

@section('js')
@stop