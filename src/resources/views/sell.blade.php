@extends('layouts.layouts')

@section('title','sell')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css')}}">
@endsection

@section('content')

<div class="sell__content">
    <div class="sell-form__heading">
        <h1>商品の出品</h1>
    </div>
    <form class="form" action="{{route('exhibit')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
        <div class="sell-img-box">
            <img id="preview" class="sell-img-img">
            <label  for="file_upload"  class="sell-img-label">画像を選択する<input type="file" name="image" id="file_upload"  class="sell-img-input"></label>
        </div>
        <div class="form__error">
            @error('image')
            {{ $message }}
            @enderror
            </div>
        <div class="sell-title">
            <h2>商品の詳細</h2>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <div class="flex__item">
                    <p class="form__group-content-p">カテゴリー</p>
                    <button id="add" type="button">記入欄を追加</button>
                </div>
                <div id="category-input">
                    <input type="text" name="category[]" class="form__input--text">
                </div>
            <div class="form__error">
            @error('category[]')
            {{ $message }}
            @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-content-p">
                <p class="form__group-content-p">商品の状態</p>
                <div>
                    <input type="text" name="condition" value="{{ old('condition') }}" class="form__input--text">
                </div>
                <div class="form__error">
                @error('condition')
                {{ $message }}
                @enderror
                </div>
            </div>
        </div>
        <div class="sell-title">
            <h2>商品名と説明</h2>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p class="form__group-content-p">商品名</p>
                <div>
                    <input type="text" name="name" value="{{ old('name') }}" class="form__input--text">
                </div>
                <div class="form__error">
                @error('name')
                {{ $message }}
                @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p class="form__group-content-p">ブランド・メーカー名</p>
                <div>
                    <input type="text" name="brand" value="{{ old('brand') }}" class="form__input--text">
                </div>
                <div class="form__error">
                @error('brand')
                {{ $message }}
                @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p class="form__group-content-p">商品の説明</p>
                <div>
                    <textarea name="explanation" id="" cols="20" rows="5"  value="{{ old('explanation') }}" class="textarea"></textarea>
                </div>
                <div class="form__error">
                @error('explanation')
                {{ $message }}
                @enderror
                </div>
            </div>
        </div>
        <div class="sell-title">
            <h2>販売価格</h2>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p class="form__group-content-p">販売価格</p>
                <div>
                    <input type="number" name="price"  value="{{ old('price') }}" class="form__input--text">
                </div>
                <div class="form__error">
                @error('price')
                {{ $message }}
                @enderror
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">出品する</button>
        </div>
    </form>
</div>
<script>
    $('#file_upload').on('change', function(){
	var $fr = new FileReader();
	$fr.onload = function(){
		$('#preview').attr('src', $fr.result);
	}
	$fr.readAsDataURL(this.files[0]);
    });
    $(function() {
        $('#add').click(function() {
            $('#category-input').append('<input type="text" name="category[]" class="form__input--text">');
        });
    });
</script>

@endsection