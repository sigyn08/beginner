@extends('layouts.app')

@section('content')
<div class="sell-container">
    <h2 class="sell-title">商品の出品</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-group">
            <label for="image" class="form-label">商品画像</label>
            <div class="image-upload-box">
                <input type="file" id="image" name="image" hidden>
                <label for="image" class="image-label">画像を選択する</label>
            </div>
            @error('image')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- カテゴリー --}}
        <div class="form-group">
            <label class="form-label">カテゴリー</label>
            <div class="category-tags">
                @php
                $categories = [
                'ファッション', '家電', 'インテリア', 'レディース', 'メンズ',
                'コスメ', '本', 'ゲーム', 'スポーツ', 'キッチン',
                'ハンドメイド', 'アクセサリー', 'おもちゃ', 'ベビー・キッズ'
                ];
                @endphp

                @foreach ($categories as $category)
                <label class="tag">
                    <input type="radio" name="category_id" value="{{ $category }}" {{ old('category_id') == $category ? 'checked' : '' }} required>
                    <span>{{ $category }}</span>
                </label>
                @endforeach
            </div>
            @error('category_id')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品の状態 --}}
        <div class="form-group">
            <label for="condition" class="form-label">商品の状態</label>
            <select id="condition" name="condition" required>
                <option value="" disabled {{ old('condition') ? '' : 'selected' }}>選択してください</option>
                <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>良好</option>
                <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="poor" {{ old('condition') == 'poor' ? 'selected' : '' }}>状態が悪い</option>
            </select>
            @error('condition')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品名 --}}
        <div class="form-group">
            <label for="name" class="form-label">商品名</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品説明 --}}
        <div class="form-group">
            <label for="description" class="form-label">商品の説明</label>
            <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
            @error('description')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 価格 --}}
        <div class="form-group">
            <label for="price" class="form-label">販売価格</label>
            <input type="number" id="price" name="price" placeholder="¥" value="{{ old('price') }}" required>
            @error('price')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>


        <div class="form-group">
            <button type="submit" class="btn-sell">出品する</button>
        </div>
    </form>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}?v={{ time() }}">
@endsection