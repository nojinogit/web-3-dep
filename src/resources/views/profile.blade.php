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
    <form class="form" action="{{route('profileUpdate')}}" method="post"   enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="profile-img">
            <img src="{{asset($user->path)}}" class="shop-wrap__item-eyecatch" id="preview">
            <label  for="file_upload">画像を選択する<input type="file" name="image" id="file_upload" accept="image/*"></label>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p>ユーザ名</p>
                <div class="form__input--text">
                    <input type="text" name="name" value="{{$user->name}}">
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
                    <input type="text" name="postcode" value="{{$user->postcode}}">
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
                    <input type="text" name="address" value="{{$user->address}}">
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
                    <input type="text" name="building"  value="{{$user->building}}">
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する</button>
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
</script>
@endsection