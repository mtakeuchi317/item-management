@extends('adminlte::page')

@section('title', '商品情報')

@section('content_header')
    <h1>商品情報</h1>
@stop

@section('content')
    <div class="container">
        <!-- 商品詳細ページのメイン(メインコンテナ)部分 -->
        <div class="itemsinfo-main">
            <!-- メインコンテンツの左側(商品画像) -->
            <div class="product-img">
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

            <!-- お気に入りボタン -->
            <span>               
                <!-- もし$likeがあれば＝ユーザーが「いいね」をしていたら -->
                @if($like)
                    <!-- 「いいね」取消用ボタンを表示 -->
                    <form action="{{ route('unlike', ['item' => $info->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">
                            ★お気に入り解除
                        </button>
                    </form>
                @else
                    <!-- まだユーザーが「いいね」をしていなければ、「いいね」ボタンを表示 -->
                    <form action="{{ route('like', ['item' => $info->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">
                            ☆お気に入り登録
                        </button>
                    </form>
                @endif
            </span>


                <div class="link">
                    <div class="previous-page">
                        @if ($previousItemUrl)
                            <a href="{{ $previousItemUrl }}">前のページ</a>
                        @else
                            <span>前のページ</span>
                        @endif
                    </div>
                    <div class="next-page">
                        @if ($nextItemUrl)
                            <a href="{{ $nextItemUrl }}">次のページ</a>
                        @else
                            <span>次のページ</span>
                        @endif
                    </div>
                </div>
                <div class="back-link">
                    <a href="{{ route('item/index') }}">商品一覧へ戻る</a>
                </div>
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
