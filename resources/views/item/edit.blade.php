@extends('adminlte::page')

@section('title', '商品編集')

@section('content_header')
    <h1>商品編集</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-primary">
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                    <div class="form-group">
                        <label for="title">タイトル</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $item->title) }}">
                        @if($errors->has('title'))
                            <p class="text-danger">{{ $errors->first('title') }}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="author">作者</label>
                        <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $item->author) }}">
                        @if($errors->has('author'))
                            <p class="text-danger">{{ $errors->first('author') }}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="category">カテゴリー</label>
                        <select class="form-control" id="category" name="category">
                            @foreach($categories as $category)
                                <option value="{{$category}}" @if(old('category', $item->category) == $category) selected @endif>{{$category}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('category'))
                            <p class="text-danger">{{ $errors->first('category') }}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="detail">詳細</label>
                        <textarea class="form-control textarea" id="detail" name="detail" style="height: 200px; resize: none;">{{ old('detail', $item->detail) }}</textarea>
                        @if($errors->has('detail'))
                            <p class="text-danger">{{ $errors->first('detail') }}</p>
                        @endif
                    </div>


                        <!-- 新しい画像を選択するフォームフィールド -->
                        <div class="form-group">
                            <label for="img_name">新しい商品画像</label>
                            <input type="file" class="form-control" name="img_name" id="img_name">
                            @if($errors->has('img_name'))
                                <p class="text-danger">{{ $errors->first('img_name') }}</p>
                            @endif
                        </div>
                        <!-- 商品画像の現在の表示 -->
                        <div class="form-group">
                            <label for="current_img">現在の商品画像</label><br>
                            @if($item->img_name)
                                <img src="{{ $item->img_name }}" alt="Current Product Image" width="200">
                            @else
                                <p>現在登録されている画像はありません</p>
                            @endif
                        </div>
                        <!-- 画像削除用のチェックボックス -->
                        <div class="form-group">
                            <label for="delete_image">画像を削除する</label>
                            <input type="checkbox" name="delete_image" id="delete_image">
                        </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
