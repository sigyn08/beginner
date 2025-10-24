@extends('layouts.app')

@section('content')
<div class="address-container">
    <h2 class="address-title">住所の変更</h2>
    <form action="{{ route('address.update') }}" method="POST" class="address-form">
        @csrf
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
            @error('postal_code') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">
            @error('address') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', $user->building) }}">
        </div>

        <button type="submit" class="update-btn">更新する</button>
    </form>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/address_edit.css') }}?v={{ time() }}">
@endsection