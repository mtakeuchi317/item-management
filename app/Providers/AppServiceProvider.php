<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
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
    public function boot(Dispatcher $events): void
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('商品一覧');
            $event->menu->add([
                'text' => '全て',
                'url' => 'items',
            ]);

            $categories = DB::table('items')->distinct()->pluck('category');

            foreach ($categories as $category) {
                $event->menu->add([
                    'text' => $category,
                    'url' => 'items/category/' . urlencode($category),
                ]);
            }
        });

        Validator::extend('katakana', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/[ァ-ヴー]+/u', $value);
        });
    }
}
