<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BeginnerController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LikeController;

// トップページ
Route::get('/', [BeginnerController::class, 'index'])->name('index');

// マイページ
Route::get('/mypage', [BeginnerController::class, 'mypage'])->name('mypage')->middleware('auth');
Route::post('/purchase/{id}', [BeginnerController::class, 'purchase'])->name('purchase')->middleware('auth');

// 出品ページ（GET）
Route::get('/sell', [BeginnerController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('products.sell');

// 出品処理（POST）
Route::post('/sell', [BeginnerController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('products.store');

// メール認証
Route::get('/email/verify', function () {
    return view('verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証メールを再送しました！');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ログアウト
Route::post('/logout', [BeginnerController::class, 'destroy'])->name('logout');

// プロフィール編集・更新（認証済みのみ）
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

Route::get('/item/{id}', [BeginnerController::class, 'show'])->name('item.show');

Route::post('/item/{id}/comment', [BeginnerController::class, 'addComment'])->name('item.comment');

Route::get('/purchase/{id}', [PurchaseController::class, 'show'])->name('purchase.show');
Route::post('/purchase/{id}', [BeginnerController::class, 'purchase'])->name('purchase')->middleware('auth');

Route::post('/item/{id}/like', [LikeController::class, 'toggle'])
    ->middleware('auth')
    ->name('item.like');

// 住所変更ページ
Route::get('/address/edit', [ProfileController::class, 'editAddress'])
    ->middleware('auth')
    ->name('address.edit');

// 住所更新処理
Route::post('/address', [ProfileController::class, 'updateAddress'])
    ->name('address.update')
    ->middleware('auth');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [BeginnerController::class, 'register'])->name('register.store');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [BeginnerController::class, 'login'])->name('login.store');
