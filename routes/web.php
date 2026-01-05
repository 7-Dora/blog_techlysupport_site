<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes - 多语言博客系统
|--------------------------------------------------------------------------
|
| 路由结构说明：
|
| 英语（默认语言，无前缀）:
|   首页：        /
|   分类列表：    /{uri}
|   文章详情：    /{id}
|   公共页面：    /about, /contact, /privacy
|
| 其他语言（de/fr/es，带前缀）:
|   首页：        /{lang}
|   分类列表：    /{lang}/{uri}
|   文章详情：    /{lang}/{id}
|   公共页面：    /{lang}/about, /{lang}/contact, /{lang}/privacy
|
*/

// 支持的语言列表（英语是默认语言，不需要在这里列出）
$defaultLanguage = config('app.default_language', 'en');
$supportedLocales = array_values(array_diff(
    array_keys(\App\Models\MaterielTask::LANGUAGES()),
    [$defaultLanguage]
));

// ========================================
// 其他语言路由（de/fr/es，带语言前缀）
// ========================================
Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => implode('|', $supportedLocales)],  // 限制只能是 de|fr|es
    'middleware' => ['web', 'setLocale']  // 动态设置语言
], function () {

    // 首页
    Route::get('/', [BlogController::class, 'index'])
        ->name('home.localized');

    // 公共页面
    Route::get('/about', [PageController::class, 'about'])
        ->name('about.localized');

    Route::get('/contact', [PageController::class, 'contact'])
        ->name('contact.localized');

    Route::get('/privacy', [PageController::class, 'privacy'])
        ->name('privacy.localized');

    Route::get('/terms', [PageController::class, 'terms'])
        ->name('terms.localized');

    // 分类列表页
    Route::get('/{category}', [BlogController::class, 'category'])
        ->where('category', '[a-z\-]+')
        ->name('category.localized');

    // 文章详情页
    Route::get('/blogs/{title_uniq}', [BlogController::class, 'show'])
        ->name('blog.show.localized');
    Route::fallback([PageController::class, 'error']);
});

// ========================================
// 英语路由（默认语言，无前缀）
// ========================================
Route::group([
    'middleware' => ['web', 'setLocale:en']  // 固定设置为英语
], function () {

    // 首页
    Route::get('/', [BlogController::class, 'index'])
        ->name('home');

    // 公共页面
    Route::get('/about', [PageController::class, 'about'])
        ->name('about');

    Route::get('/contact', [PageController::class, 'contact'])
        ->name('contact');

    Route::get('/privacy', [PageController::class, 'privacy'])
        ->name('privacy');

    Route::get('/terms', [PageController::class, 'terms'])
        ->name('terms');

    // 分类列表页
    // 注意：这个路由必须在文章详情之前，避免冲突
    // 使用正则表达式限制只匹配小写字母、数字、连字符
    Route::get('/{category}', [BlogController::class, 'category'])
        ->where('category', '[a-z\-]+')
        ->name('category');

    // 文章详情页
    // 使用正则表达式限制只匹配数字
    Route::get('/blogs/{title_uniq}', [BlogController::class, 'show'])
        ->name('blog.show');
    Route::fallback([PageController::class, 'error']);
});
Route::fallback([PageController::class, 'error']);

