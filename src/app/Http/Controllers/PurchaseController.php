<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    // 購入確認ページ表示
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();

        return view('purchase', compact('product', 'user'));
    }

    // 購入処理
    public function store(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $product = Product::findOrFail($id);

        Purchase::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'payment_method' => $request->payment_method,
            'price' => $product->price,
        ]);

        return redirect()->route('mypage')->with('success', '購入が完了しました！');
    }
}
