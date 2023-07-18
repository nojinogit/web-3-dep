@extends('layouts.layouts')

@section('title','sell')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css')}}">
@endsection

@section('content')

<div class="register__content">
    <div class="register-form__heading">
        <h1>商品の出品</h1>
    </div>
    <form class="form" action="/register" method="post">
        @csrf
        <div class="sell-img">
            <label  for="file_upload">画像を選択する<input type="file" name="image"  id="file_upload"></label>
        </div>
        <div class="sell-title">
            <h2>商品の詳細</h2>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p>カテゴリー</p>
                <div class="form__input--text">
                    <input type="text" name="name" value="{{ old('name') }}">
                </div>
            <div class="form__error">
            @error('name')
            {{ $message }}
            @enderror
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p>商品の詳細</p>
                <div class="form__input--text">
                    <input type="email" name="email" value="{{ old('email') }}">
                </div>
                <div class="form__error">
                @error('email')
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
                <p>商品名</p>
                <div class="form__input--text">
                    <input type="password" name="password">
                </div>
                <div class="form__error">
                @error('password')
                {{ $message }}
                @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p>商品の説明</p>
                <div class="form__input--text">
                    <textarea name="" id="" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>
        <div class="sell-title">
            <h2>販売価格</h2>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p>販売価格</p>
                <div class="form__input--text">
                    <input type="password" name="password">
                </div>
                <div class="form__error">
                @error('password')
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

@endsection