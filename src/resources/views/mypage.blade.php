@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">

@php
// 現在どのタブかを判定（URLに ?tab=sell などがついている想定）
$currentTab = request('tab', 'sell');
@endphp

<div class="mypage-container">
    <div class="mypage-header">
        <div class="mypage-avatar">
            <img src="{{ asset('images/default-avatar.png') }}" alt="ユーザーアイコン">
        </div>
        <div class="mypage-info">
            <h2 class="mypage-username">{{ Auth::user()->name ?? 'ユーザー名' }}</h2>
            <a href="{{ route('profile.edit') }}" class="edit-profile-btn">プロフィールを編集</a>
        </div>
    </div>

    {{-- タブ --}}
    <div class="mypage-tabs">
        <a href="{{ route('mypage', ['tab' => 'sell']) }}"
            class="tab {{ $currentTab === 'sell' ? 'active' : '' }}">
            出品した商品
        </a>
        <a href="{{ route('mypage', ['tab' => 'buy']) }}"
            class="tab {{ $currentTab === 'buy' ? 'active' : '' }}">
            購入した商品
        </a>
    </div>

    {{-- 出品した商品 --}}
    @if ($currentTab === 'sell')
    <div class="tab-content">
        @forelse ($soldProducts as $product)
        <div class="product-card">
            <div class="product-image">
                @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                <div class="no-image">画像なし</div>
                @endif
            </div>
            <div class="product-name">{{ $product->name }}</div>
            <div class="product-price">¥{{ number_format($product->price) }}</div>
        </div>
        @empty
        <p class="no-products">出品した商品はありません。</p>
        @endforelse
    </div>
    @endif

    {{-- 購入した商品 --}}
    @if ($currentTab === 'buy')
    <div class="tab-content">
        @forelse ($boughtProducts as $product)
        <div class="product-card">
            <div class="product-image">
                @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                <div class="no-image">画像なし</div>
                @endif
            </div>
            <div class="product-name">{{ $product->name }}</div>
            <div class="product-price">¥{{ number_format($product->price) }}</div>
        </div>
        @empty
        <p class="no-products">購入した商品はありません。</p>
        @endforelse
    </div>
    @endif
</div>
@endsection