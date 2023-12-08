@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品登録</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">

            <div class="card card-primary">
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">タイトル <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="タイトル" value="{{ old('title') }}">
                            @if($errors->has('title'))
                                <p class="text-danger">{{ $errors->first('title') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="type">作者 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="author" name="author" placeholder="作者" value="{{ old('author') }}">
                            @if($errors->has('author'))
                                <p class="text-danger">{{ $errors->first('author') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="type">カテゴリー <span class="text-danger">*</span></label>
                            <select class="form-control" id="category" name="category">
                                <option value="" disabled @if(old('category') == '') selected @endif>選択してください</option>
                                @foreach($categories as $category)
                                    <option value="{{$category}}" @if(old('category') == $category) selected @endif>{{$category}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category'))
                                <p class="text-danger">{{ $errors->first('category') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細（900文字以内）</label>
                            <textarea class="form-control textarea" id="detail" name="detail" placeholder="詳細説明" style="height: 200px; resize: none;">{{ old('detail') }}</textarea>
                            @if($errors->has('detail'))
                                <p class="text-danger">{{ $errors->first('detail') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="img_name">商品画像</label>
                            <input type="file" class="form-control" name="img_name" id="img_name">
                            @if($errors->has('img_name'))
                                <p class="text-danger">{{ $errors->first('img_name') }}</p>
                            @endif
                        </div>
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
<link href="{{ asset('css/item.css') }}" rel="stylesheet">
@stop

@section('js')
@stop
