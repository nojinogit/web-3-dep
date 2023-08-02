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
        <div class="profile-imgbox">
            <img src="{{asset($user->path)}}" class="profile-imgbox-img" id="preview">
            <label for="file_upload"  class="profile-imgbox-label">画像を選択する<input type="file" name="image" id="file_upload" accept="image/*" class="profile-imgbox-input"></label>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p class="form__group-content-p">ユーザ名</p>
                <div>
                    <input type="text" name="name" value="{{$user->name}}"  class="form__input--text">
                </div>
            <div class="form__error">
            @error('name')
            {{ $message }}
            @enderror
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p class="form__group-content-p">郵便番号</p>
                <div>
                    <input type="text" name="postcode" value="{{$user->postcode}}" class="form__input--text">
                </div>
                <div class="form__error">
                @error('postcode')
                {{ $message }}
                @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p class="form__group-content-p">住所</p>
                <div>
                    <input type="text" name="address" value="{{$user->address}}" class="form__input--text">
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <p class="form__group-content-p">建物名</p>
                <div>
                    <input type="text" name="building"  value="{{$user->building}}" class="form__input--text">
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