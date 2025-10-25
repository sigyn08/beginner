<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class BeginnerController extends Controller
{
    public function __construct()
    {
        // mypage, create, store はログイン必須に
        $this->middleware('auth')->only(['create', 'store', 'mypage', 'purchase']);
    }

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend'); // デフォルトはおすすめ

        if ($tab === 'mylist' && Auth::check()) {
            // If User model doesn't define a likes() relation, fetch liked product IDs from the likes pivot table
            $likedProductIds = DB::table('likes')->where('user_id', Auth::id())->pluck('product_id');
            $products = Product::whereIn('id', $likedProductIds)->get();
        } else {
            $products = Product::all();
        }

        return view('index', compact('products', 'tab'));
    }


    public function create()
    {
        return view('sell');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'price' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
            'condition' => 'required|string|max:50',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['user_id'] = Auth::id();

        Product::create($validated);

        return redirect()->route('index')->with('success', '商品を出品しました！');
    }

    // マイページ
    public function mypage()
    {
        $user = Auth::user();

        // 出品した商品（自分が seller）
        $soldProducts = Product::where('user_id', $user->id)->get();

        // 購入した商品（自分が buyer）
        $boughtProducts = Product::where('buyer_id', $user->id)->get();

        return view('mypage', compact('soldProducts', 'boughtProducts'));
    }


    // 購入処理（例）
    public function purchase($id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);

        if ($product->user_id === $user->id) {
            return redirect()->back()->with('error', '自分の商品は購入できません。');
        }

        if ($product->buyer_id) {
            return redirect()->back()->with('error', 'この商品はすでに購入されています。');
        }

        DB::transaction(function () use ($product, $user) {
            $product->update(['buyer_id' => $user->id]);
        });

        return redirect()->route('mypage')->with('success', '商品を購入しました！');
    }

    public function edit()
    {
        return view('profile');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function show($id)
    {
        $product = Product::with('comments.user')->findOrFail($id);
        return view('item', compact('product'));
    }

    // コメント投稿メソッド
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $id,
            'content' => $request->content,
        ]);

        return back();
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        // ユーザー作成
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 登録後に自動ログイン
        Auth::login($user);

        // トップページへリダイレクト
        return redirect()->route('index')->with('success', '登録が完了しました！');
    }

    public function login(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended('/');
    }
}
