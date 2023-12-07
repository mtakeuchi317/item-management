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
                            <input type="text" class="form-control" id="title" name="title" placeholder="タイトル">
                            @if($errors->has('title'))
                                <p class="text-danger">{{ $errors->first('title') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="type">作者 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="author" name="author" placeholder="作者">
                            @if($errors->has('author'))
                                <p class="text-danger">{{ $errors->first('author') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="type">カテゴリー <span class="text-danger">*</span></label>
                            <select class="form-control" id="category" name="category">
                                <option value="" selected disabled>選択してください</option>
                                <option value="文芸書">文芸書</option>
                                <option value="人文書">人文書</option>
                                <option value="専門書">専門書</option>
                                <option value="実用書">実用書</option>
                                <option value="ビジネス・経済・経営">ビジネス・経済・経営</option>
                                <option value="児童書・絵本">児童書・絵本</option>
                                <option value="学習参考書">学習参考書</option>
                                <option value="マンガ・コミックス">マンガ・コミックス</option>
                            </select>
                            @if($errors->has('category'))
                                <p class="text-danger">{{ $errors->first('category') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="詳細説明">
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
@stop

@section('js')
@stop
