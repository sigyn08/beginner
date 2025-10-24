@extends('layouts.app')

@section('content')
<div class="container">

    {{-- ヘッダー --}}
    <header class="header">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="COACHTECH">
        </div>
        <div class="search-box">
            <form action="{{ route('index') }}" method="GET">
                <input type="text" name="keyword" placeholder="なにをお探しですか？">
            </form>
        </div>
        <nav class="nav">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">ログアウト</button>
            </form>
            <a href="{{ route('mypage') }}">マイページ</a>
            <a href="{{ route('products.sell') }}" class="btn-exhibit">出品</a>
        </nav>
    </header>

    {{-- タブ --}}
    <div class="tabs">
        <a href="{{ route('index', ['tab' => 'recommend']) }}"
            class="tab {{ $tab === 'recommend' ? 'active' : '' }}">おすすめ</a>

        @auth
        <a href="{{ route('index', ['tab' => 'mylist']) }}"
            class="tab {{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
        @endauth
    </div>


    {{-- 商品一覧 --}}
    <div class="product-list">
        @if($tab === 'mylist')
        @auth
        @forelse($products as $product)
        <div class="product-card">
            <a href="{{ route('item.show', $product->id) }}" class="product-image">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            </a>
            <div class="product-name">{{ $product->name }}</div>
        </div>
        @empty
        <p style="text-align:center;">まだ「いいね」した商品がありません。</p>
        @endforelse
        @else
        <p style="text-align:center;">マイリストを見るにはログインしてください。</p>
        @endauth
        @else
        @foreach($products as $product)
        <div class="product-card">
            <a href="{{ route('item.show', $product->id) }}" class="product-image">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            </a>
            <div class="product-name">{{ $product->name }}</div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}?v={{ time() }}">
@endsection