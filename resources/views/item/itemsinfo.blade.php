@extends('adminlte::page')

@section('title', '商品情報')

@section('content_header')
    <h1>商品情報 <{{ isset($category) ? $category : 'すべての商品' }}></h1>
@stop

@section('content')
    <div class="container">
        <!-- 商品詳細ページのメイン(メインコンテナ)部分 -->
        <div class="itemsinfo-main">
            <!-- メインコンテンツの左側 -->
            <div class="itemsinfo-left">
                <div class="product-img">
                    @if (!empty($info->img_name))
                        <!-- img_name が存在する場合の処理 -->
                        <img src="{{ $info->img_name }}" alt="{{ $info->img_name }}" class="img-large">
                    @else
                        <!-- img_name が存在しない場合の処理 -->
                        <img src="http://design-ec.com/d/e_others_50/m_e_others_500.png" alt="No Image" class="img-large">
                    @endif
                </div>
                <!-- お気に入りボタン -->
                <span>               
                    <!-- もし$likeがあれば＝ユーザーが「いいね」をしていたら -->
                    @if($like)
                        <!-- 「いいね」取消用ボタンを表示 -->
                        <form action="{{ route('unlike', ['item' => $info->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm like-btn">
                                ★お気に入り解除
                            </button>
                        </form>
                    @else
                        <!-- まだユーザーが「いいね」をしていなければ、「いいね」ボタンを表示 -->
                        <form action="{{ route('like', ['item' => $info->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm like-btn">
                                ☆お気に入り登録
                            </button>
                        </form>
                    @endif
                </span>
                <div class="link">
                    <div class="next-page">
                        @if ($nextItemUrl)
                            <a href="{{ $nextItemUrl }}">次のページ</a>
                        @else
                            <span>次のページ</span>
                        @endif
                    </div>
                    <div class="previous-page">
                        @if ($previousItemUrl)
                            <a href="{{ $previousItemUrl }}">前のページ</a>
                        @else
                            <span>前のページ</span>
                        @endif
                    </div>
                </div>
            </div>
            <!-- メインコンテンツの右側(メーカー名、商品カテゴリ、型番、コメント) -->
            <div class="product-details">
                <ul>
                    <li style="font-weight: bold; font-size: x-large;">{{ $info->title }}</li>
                    <li style="font-weight: bold;">{{ $info->author }} 著</li>
                    <li style="font-weight: bold;">カテゴリー：{{ $info->category }}</li>
                    <li style="font-size:small">{!! nl2br(e($info->detail)) !!}</li>
                </ul>

            </div>
        </div>
    </div>

@stop

@section('css')
    <link href="{{ asset('css/item.css') }}" rel="stylesheet">
@stop

@section('js')
    <script src="{{ asset('/js/item.js') }}"></script>
@stop
