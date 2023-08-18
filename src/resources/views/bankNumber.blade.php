@extends('layouts.layouts')

@section('title','bankNumber')

@section('css')
<link rel="stylesheet" href="{{ asset('css/bankNumber.css')}}">
@endsection

@section('content')

<div class="register__content">
    <div class="register-form__heading">
        <h1>銀行口座登録</h1>
    </div>
    <form class="form" action="{{route('bankNumberUpdate')}}" method="post">
        @method('put')
        @csrf
        <div class="form__group">
            <div class="form__group-content">
                <p class="form__group-content-p">銀行名</p>
                <div>
                    <input type="text" name="bank" value="{{$user->bank}}"  class="form__input--text" placeholder="みずほ銀行">
                </div>
            <div class="form__error">
            @error('bank')
            {{ $message }}
            @enderror
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p class="form__group-content-p">支店名</p>
                <div>
                    <input type="text" name="bank_branch" value="{{$user->bank_branch}}" class="form__input--text" placeholder="いろは支店">
                </div>
                <div class="form__error">
                @error('bank_branch')
                {{ $message }}
                @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p class="form__group-content-p">口座種類</p>
                <div>
                    <input type="text" name="bank_type" value="{{$user->bank_type}}" class="form__input--text" placeholder="普通">
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p class="form__group-content-p">口座番号</p>
                <div>
                    <input type="text" name="bank_number"  value="{{$user->bank_number}}" class="form__input--text" placeholder="1234567">
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する</button>
        </div>
    </form>
    @if (session('key'))
    <div class="key">{{ session('key') }}</div>
    @endif
</div>
@endsection