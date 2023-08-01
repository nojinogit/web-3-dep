@extends('layouts.layouts')

@section('title','register')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css')}}">
@endsection

@section('content')

<div class="register__content">
    <div class="register-form__heading">
        <h1>会員登録</h1>
    </div>
    <form class="form" action="/register" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-content-p">
                <p class="form__group-content-p">お名前</p>
                <div>
                    <input type="text" name="name" value="{{ old('name') }}"  class="form__input--text">
                </div>
            <div class="form__error">
            @error('name')
            {{ $message }}
            @enderror
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p class="form__group-content-p">メールアドレス</p>
                <div>
                    <input type="email" name="email" value="{{ old('email') }}"  class="form__input--text">
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
                <p class="form__group-content-p">パスワード</p>
                <div>
                    <input type="password" name="password"  class="form__input--text">
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
                <p class="form__group-content-p">確認用パスワード</p>
                <div>
                    <input type="password" name="password_confirmation"  class="form__input--text">
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">会員登録</button>
        </div>
    </form>
    <div class="login__link">
        <a class="login__button-submit" href="/login">ログインはこちら</a>
    </div>
</div>

@endsection