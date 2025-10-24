<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Product;

class LikeController extends Controller
{
    public function toggle($productId)
    {
        $user = Auth::user();

        $like = Like::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($like) {
            // すでにいいね済み → 解除
            $like->delete();
            $liked = false;
        } else {
            // いいね登録
            Like::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            $liked = true;
        }

        if (request()->ajax()) {
            return response()->json(['liked' => $liked]);
        }

        return back();
    }
}
