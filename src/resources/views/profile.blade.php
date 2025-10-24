@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="profile-edit-container">
    <h2>プロフィール編集</h2>

    @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="profile_image">プロフィール画像</label>
            <input type="file" name="profile_image">

            @if ($user->profile_image)
            {{-- ユーザーが画像をアップロード済み --}}
            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" class="avatar">
            @else
            {{-- 未設定の場合はデフォルトアイコン --}}
            <div class="avatar default-avatar"></div>
            @endif

            @error('profile_image')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
            @error('postal_code') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="address">住所</label>
            <input type="text" name="address" value="{{ old('address', $user->address) }}">
            @error('address') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="building">建物名</label>
            <input type="text" name="building" value="{{ old('building', $user->building) }}">
            @error('building') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button type="submit">更新</button>
    </form>
</div>
@endsection