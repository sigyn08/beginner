<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::loginView(function () {
            return view('login');
        });
        $this->app->singleton(LoginResponse::class, function ($app) {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    return redirect()->route('index'); // ← ログイン後は index.blade.php へ
                }
            };
        });
        // ログアウト後のリダイレクト先
        $this->app->singleton(\Laravel\Fortify\Contracts\LogoutResponse::class, function ($app) {
            return new class implements \Laravel\Fortify\Contracts\LogoutResponse {
                public function toResponse($request)
                {
                    return redirect()->route('login'); // ← ログイン画面に戻す
                }
            };
        });

        Fortify::registerView(function () {
            return view('register');
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        
        // ログイン後にメール未認証なら認証画面へ
        Fortify::authenticateUsing(function ($request) {
            $user = \App\Models\User::where('email', $request->email)->first();

            if (
                $user &&
                \Illuminate\Support\Facades\Hash::check($request->password, $user->password)
            ) {
                if (!$user->hasVerifiedEmail()) {
                    return null; // 認証していない場合はログイン不可
                }
                return $user;
            }
        });
    }
}
