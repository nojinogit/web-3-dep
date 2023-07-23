@extends('layouts.layouts')

@section('title','address')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css')}}">
@endsection

@section('content')

<div class="login__content">
<div class="login-form__heading">
    <h2>配達先の変更</h2>
</div>
<form class="form" action="{{route('addressChange')}}" method="post">
    @csrf
    <input type="hidden" name="item_id" value="{{$item->id}}">
    <input type="hidden" name="user_id" value="{{$user->id}}">
    <div class="form__group">
    <div class="form__group-content">
        <p>郵便番号</p>
        <div class="form__input--text">
        <input type="text" name="postcode" value="{{$user->postcode }}">
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
        <input  type="text" name="address" value="{{$user->address }}">
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
        <input  type="text" name="building" value="{{$user->building }}">
        </div>
        <div class="form__error">
        @error('password')
        {{ $message }}
        @enderror
        </div>
    </div>
    </div>
    <div class="form__button">
    <button class="form__button-submit" type="submit">変更する</button>
    </div>
</form>

</div>

@endsection