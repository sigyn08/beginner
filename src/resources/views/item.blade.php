@extends('layouts.app')

@section('content')
<div class="item-container">
    <div class="item-image">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
    </div>
    <div class="item-details">
        <h2>{{ $product->name }}</h2>
        <p class="brand">{{ $product->brand }}</p>
        <p class="price">¥{{ number_format($product->price) }}（税込）</p>
        <div class="like-section">
            @auth
            <form action="{{ route('item.like', $product->id) }}" method="POST" class="like-form">
                @csrf
                <button type="submit" class="like-btn" data-liked="{{ Auth::user()->likes->contains('product_id', $product->id) ? 'true' : 'false' }}">
                    @if(Auth::user()->likes->contains('product_id', $product->id))
                    ❤️ いいね済み
                    @else
                    🤍 いいね
                    @endif
                </button>
            </form>
            @endauth
        </div>

        <a href="{{ route('purchase.show', $product->id) }}" class="buy-btn">購入手続きへ</a>


        <h3>商品説明</h3>
        <p>{{ $product->description }}</p>

        <h3>商品の情報</h3>
        <p>カテゴリー：{{ $product->category }}</p>
        <p>状態：{{ $product->condition }}</p>

        {{-- コメントセクション（ダミー例） --}}
        {{-- コメント一覧 --}}
        <div class="comment-section">
            <h3>コメント({{ $product->comments->count() }})</h3>

            @foreach($product->comments as $comment)
            <div class="comment">
                <strong>{{ $comment->user->name }}</strong>
                <p>{{ $comment->content }}</p>
            </div>
            @endforeach

            {{-- コメント投稿フォーム（ログイン時のみ表示） --}}
            @auth
            <form action="{{ route('item.comment', $product->id) }}" method="POST">
                @csrf
                <textarea name="content" placeholder="商品へのコメントを入力してください"></textarea>
                @error('content')
                <p style="color:red;">{{ $message }}</p>
                @enderror
                <button type="submit" class="comment-btn">コメントを送信する</button>
            </form>
            @endauth
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}?v={{ time() }}">
@endsection