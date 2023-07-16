@extends('../layouts.layouts')

@section('title','forgot-password')

@section('css')
<link rel="stylesheet" href="{{ asset('css/forgot-pass.css')}}">
@endsection

@section('content')
<div class="main">
    <div class="card">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}" class="form">
            @csrf
            <div class="form-title">
                リセットメールアドレス
            </div>
            <div class="form-input-area">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="メールアドレス">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
            <div class="button-area">
                <button type="submit" class="btn btn-primary">
                    リセットメール送信
                </button>
            </div>
        </form>
    </div>
</div>
@endsection