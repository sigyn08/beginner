@extends('layouts.app')

@section('content')
<div class="verify-container">
    <h2>メールアドレスの確認が必要です</h2>
    <p>登録したメールアドレスに確認用リンクを送信しました。</p>

    @if (session('message'))
    <div class="alert">{{ session('message') }}</div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">認証メールを再送する</button>
    </form>
</div>
@endsection