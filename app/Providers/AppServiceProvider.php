<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;


class AppServiceProvider extends ServiceProvider
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
        Validator::extend('katakana', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/\A[ァ-ヶー　]+\z/u', $value); // カタカナの正規表現パターン
        });
    
        Validator::replacer('katakana', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', 'フリガナ', ':attributeは全角カタカナで入力してください');
        });

        if(\App::environment(['production'])) {
            \URL::forseScheme('https');
        }
    }
}
