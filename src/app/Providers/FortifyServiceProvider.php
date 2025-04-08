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
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use Illuminate\Support\Facades\Auth;



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
        // ユーザー登録処理を定義
        Fortify::createUsersUsing(CreateNewUser::class);

        // 新規登録時にメール認証を送信（ただしログインはさせない）
        Event::listen(Registered::class, function ($event) {
            $event->user->sendEmailVerificationNotification();
        });

        // 会員登録画面
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // 会員登録後はログインさせず、thanks 画面へ
        app()->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                return redirect('/thanks');
            }
        });

        // ログイン画面
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // ログイン後の処理（メール未認証ならログアウトして通知ページへ）
        app()->instance(\Laravel\Fortify\Contracts\LoginResponse::class, new class implements \Laravel\Fortify\Contracts\LoginResponse {
            public function toResponse($request)
            {
                $user = Auth::user();

                if (!$user->hasVerifiedEmail()) {
                    // 認証メールを再送信
                    $user->sendEmailVerificationNotification();

                    Auth::logout();
                    return redirect()->route('verification.notice')
                        ->withErrors(['email' => 'メールアドレスの確認が必要です。メールを再送信しました。']);
                }

                return redirect()->intended(config('fortify.home'));
            }
        });


        // ログインのレート制限
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });
    }
}
