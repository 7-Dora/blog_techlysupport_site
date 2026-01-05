<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 为所有视图共享分类和Support菜单数据
        View::composer('*', function ($view) {
            $categories = CategoryService::getActiveCategories();
            $view->with('categories', $categories);
        });
    }
}
