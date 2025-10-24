<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'postal_code'   => 'nullable|string|max:10',
            'address'       => 'nullable|string|max:255',
            'building'      => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048', // 画像アップロードの場合
        ]);

        $user = Auth::user();

        // 画像アップロード処理
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->postal_code = $request->postal_code;
        $user->address     = $request->address;
        $user->building    = $request->building;
        $user->save();

        return redirect()->route('index')->with('status', 'プロフィールを更新しました');
    }

    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    public function editAddress()
    {
        $user = Auth::user();
        return view('address', compact('user')); // Blade名をaddress.blade.phpに変更
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save(); // ← DBに反映

        $productId = session('current_product_id');

        if ($productId) {
            return redirect()->route('purchase.show', ['id' => $productId])
                ->with('success', '住所を更新しました！');
        } else {
            return redirect()->route('mypage')
                ->with('success', '住所を更新しました！');
        }
    }
}
