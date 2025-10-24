@extends('layouts.app')

@section('content')
<div class="form-container">
    <h2>ログイン</h2>

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="password">
            @error('password')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn">ログイン</button>
        {{-- 会員登録リンク --}}
        <div class="register-link">
            <a href="{{ route('register') }}">会員登録はこちら</a>
        </div>
    </form>
</div>
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}?v={{ time() }}">
@endsection