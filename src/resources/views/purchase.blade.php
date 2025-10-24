@extends('layouts.app')

@section('content')
<div class="purchase-container">
    <div class="purchase-left">
        <div class="product-summary">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            <div class="product-info">
                <h2>{{ $product->name }}</h2>
                <p class="price">¥{{ number_format($product->price) }}</p>
            </div>
        </div>

        <hr>

        <div class="payment-method">
            <h3>支払い方法</h3>
            <form action="{{ route('purchase', ['id' => $product->id]) }}" method="POST">
                @csrf
                <select name="payment_method" required>
                    <option value="">選択してください</option>
                    <option value="コンビニ払い">コンビニ払い</option>
                    <option value="カード支払い">カード支払い</option>
                </select>

                <hr>

                <div class="address">
                    <h3>配送先</h3>
                    <p>〒 {{ $user->postal_code ?? 'XXX-YYYY' }}</p>
                    <p>{{ $user->address ?? 'ここには住所と連絡先が入ります' }}</p>
                    <a href="{{ route('address.edit') }}" class="change-link">変更する</a>
                </div>

                <hr>

                <div class="summary-box">
                    <table>
                        <tr>
                            <td>商品代金</td>
                            <td>¥{{ number_format($product->price) }}</td>
                        </tr>
                        <tr>
                            <td>支払い方法</td>
                            <td id="payment-display">未選択</td>
                        </tr>
                    </table>
                    <button type="submit" class="buy-btn">購入する</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}?v={{ time() }}">
@endsection

@section('scripts')
<script>
    const select = document.querySelector('select[name="payment_method"]');
    const display = document.getElementById('payment-display');
    select.addEventListener('change', () => {
        display.textContent = select.value || '未選択';
    });
</script>
@endsection