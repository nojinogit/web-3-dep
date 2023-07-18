@extends('layouts.layouts')

@section('title','profile')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css')}}">
@endsection

@section('content')

<div class="register__content">
    <div class="register-form__heading">
        <h1>プロフィール設定</h1>
    </div>
    <form class="form" action="/register" method="post">
        @csrf
        <div class="profile-img">
            <img src="storage/sample/ドラム式洗濯機.jpg" class="shop-wrap__item-eyecatch">
            <label  for="file_upload">画像を選択する<input type="file" name="image"  id="file_upload"></label>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p>ユーザ名</p>
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
                <p>郵便番号</p>
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
        <div class="form__group">
            <div class="form__group-content">
                <p>住所</p>
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
                <p>建物名</p>
                <div class="form__input--text">
                    <input type="password" name="password_confirmation">
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">会員登録</button>
        </div>
    </form>
</div>

@endsection