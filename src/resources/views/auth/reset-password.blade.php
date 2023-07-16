@extends('../layouts.layouts')

@section('title','reset-password')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reset-pass.css')}}">
@endsection

@section('content')
<div class="container">
    <div class="card">
        <form method="POST" action="{{ route('password.update') }}" class="form">
        @csrf
            <input type="hidden" name="token" value="{{ request()->token }}">
            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">リセットメールアドレス</label>
                <div class="input-area">
                    <input id="email" type="email" class="input" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="メールアドレス">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">パスワード</label>
                <div class="input-area">
                    <input id="password" type="password" class="input" name="password" required autocomplete="new-password" placeholder="新しいパスワード">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">パスワード確認</label>
                    <div class="input-area">
                        <input id="password-confirm" type="password" class="input" name="password_confirmation" required autocomplete="new-password" placeholder="新しいパスワード確認用">
                    </div>
            </div>
            <div class="button-area">
                <button type="submit" class="btn btn-primary">
                    パスワードリセット
                </button>
            </div>
        </form>
    </div>
</div>
@endsection