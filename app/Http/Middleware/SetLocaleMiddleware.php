<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/**
 * 语言设置中间件
 * 
 * 功能：
 * 1. 从URL参数或中间件参数设置应用语言
 * 2. 验证语言是否支持
 * 3. 将语言信息共享到视图
 * 4. 保存语言到Session（可选）
 */
class SetLocaleMiddleware
{
    /**
     * 支持的语言列表
     * 
     * @var array
     */
    protected $supportedLocales = ['en', 'de', 'fr', 'es'];
    
    /**
     * 默认语言
     * 
     * @var string
     */
    protected $defaultLocale = 'en';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $locale  固定语言（可选）
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $locale = null)
    {
        // ========================================
        // 步骤1: 确定当前语言
        // ========================================
        
        // 如果中间件传入了固定语言（如 'setLocale:en'）
        if ($locale) {
            $currentLocale = $locale;
        }
        // 否则从路由参数获取（如 /de/about 中的 'de'）
        else {
            $currentLocale = $request->route('locale') ?? $this->defaultLocale;
        }
        
        // ========================================
        // 步骤2: 验证语言是否支持
        // ========================================
        
        if (!in_array($currentLocale, $this->supportedLocales)) {
            // 如果语言不支持，返回404
            abort(404, 'Language not supported');
        }
        
        // ========================================
        // 步骤3: 设置应用语言
        // ========================================
        
        // 设置Laravel应用语言
        App::setLocale($currentLocale);
        
        // 保存到Session（用于记住用户选择的语言）
        Session::put('locale', $currentLocale);
        
        // ========================================
        // 步骤4: 共享数据到视图
        // ========================================
        
        // 当前语言
        view()->share('currentLocale', $currentLocale);
        
        // 所有支持的语言
        view()->share('supportedLocales', $this->supportedLocales);
        
        // 语言名称映射（用于语言切换器）
        view()->share('localeNames', [
            'en' => 'English',
            'de' => 'Deutsch',
            'fr' => 'Français',
            'es' => 'Español'
        ]);
        
        // ========================================
        // 步骤5: 继续处理请求
        // ========================================
        
        return $next($request);
    }
}

/*
|--------------------------------------------------------------------------
| 使用说明
|--------------------------------------------------------------------------
|
| 1. 注册中间件（app/Http/Kernel.php）:
|
| protected $routeMiddleware = [
|     // ... 其他中间件
|     'setLocale' => \App\Http\Middleware\SetLocaleMiddleware::class,
| ];
|
|--------------------------------------------------------------------------
| 2. 在路由中使用
|--------------------------------------------------------------------------
|
| 方式A：固定语言（用于英语路由）
| Route::get('/', [HomeController::class, 'index'])
|     ->middleware('setLocale:en');
|
| 方式B：动态语言（从URL获取）
| Route::group([
|     'prefix' => '{locale}',
|     'middleware' => 'setLocale'
| ], function () {
|     Route::get('/', [HomeController::class, 'index']);
| });
|
|--------------------------------------------------------------------------
| 3. 在控制器中获取当前语言
|--------------------------------------------------------------------------
|
| public function index()
| {
|     $locale = app()->getLocale();  // 'en', 'de', 'fr', 或 'es'
|     
|     // 或从Session获取
|     $locale = Session::get('locale', 'en');
| }
|
|--------------------------------------------------------------------------
| 4. 在视图中使用
|--------------------------------------------------------------------------
|
| {{-- 当前语言 --}}
| <p>Current Language: {{ $currentLocale }}</p>
|
| {{-- 所有支持的语言 --}}
| @foreach($supportedLocales as $lang)
|     <a href="{{ switch_locale_url($lang) }}">{{ $localeNames[$lang] }}</a>
| @endforeach
|
| {{-- 使用Laravel的翻译功能 --}}
| <h1>{{ __('home.welcome') }}</h1>
|
|--------------------------------------------------------------------------
| 5. 扩展功能示例
|--------------------------------------------------------------------------
*/

/**
 * 扩展版：带更多功能的中间件
 */
class SetLocaleMiddleware_Advanced
{
    protected $supportedLocales = ['en', 'de', 'fr', 'es'];
    protected $defaultLocale = 'en';

    public function handle(Request $request, Closure $next, $locale = null)
    {
        // 确定语言的优先级：
        // 1. 中间件参数（最高优先级）
        // 2. URL参数
        // 3. Session记忆
        // 4. 浏览器语言
        // 5. 默认语言（最低优先级）
        
        $currentLocale = $this->determineLocale($request, $locale);
        
        // 验证语言
        if (!in_array($currentLocale, $this->supportedLocales)) {
            abort(404, 'Language not supported');
        }
        
        // 设置语言
        App::setLocale($currentLocale);
        Session::put('locale', $currentLocale);
        
        // 设置Carbon（日期）语言
        \Carbon\Carbon::setLocale($currentLocale);
        
        // 共享到视图
        $this->shareToViews($currentLocale);
        
        // 添加响应头（用于调试）
        $response = $next($request);
        
        if (method_exists($response, 'header')) {
            $response->header('X-App-Locale', $currentLocale);
        }
        
        return $response;
    }
    
    /**
     * 确定当前语言
     */
    protected function determineLocale(Request $request, $locale = null)
    {
        // 1. 中间件参数
        if ($locale) {
            return $locale;
        }
        
        // 2. URL参数
        if ($routeLocale = $request->route('locale')) {
            return $routeLocale;
        }
        
        // 3. Session记忆
        if ($sessionLocale = Session::get('locale')) {
            if (in_array($sessionLocale, $this->supportedLocales)) {
                return $sessionLocale;
            }
        }
        
        // 4. 浏览器语言
        $browserLocale = $this->getBrowserLocale($request);
        if ($browserLocale) {
            return $browserLocale;
        }
        
        // 5. 默认语言
        return $this->defaultLocale;
    }
    
    /**
     * 从浏览器获取首选语言
     */
    protected function getBrowserLocale(Request $request)
    {
        $acceptLanguage = $request->server('HTTP_ACCEPT_LANGUAGE');
        
        if (!$acceptLanguage) {
            return null;
        }
        
        // 解析 Accept-Language 头
        // 例如: "en-US,en;q=0.9,de;q=0.8"
        preg_match_all('/([a-z]{2})(?:-[A-Z]{2})?(?:;q=([0-9.]+))?/', 
                       $acceptLanguage, $matches);
        
        if (empty($matches[1])) {
            return null;
        }
        
        // 查找第一个支持的语言
        foreach ($matches[1] as $lang) {
            if (in_array($lang, $this->supportedLocales)) {
                return $lang;
            }
        }
        
        return null;
    }
    
    /**
     * 共享数据到视图
     */
    protected function shareToViews($currentLocale)
    {
        view()->share([
            'currentLocale' => $currentLocale,
            'supportedLocales' => $this->supportedLocales,
            'localeNames' => [
                'en' => 'English',
                'de' => 'Deutsch',
                'fr' => 'Français',
                'es' => 'Español'
            ],
            'localeFlags' => [
                'en' => '🇬🇧',
                'de' => '🇩🇪',
                'fr' => '🇫🇷',
                'es' => '🇪🇸'
            ],
            'localeDirections' => [
                'en' => 'ltr',
                'de' => 'ltr',
                'fr' => 'ltr',
                'es' => 'ltr'
                // 如果支持阿拉伯语等：'ar' => 'rtl'
            ]
        ]);
    }
}

/*
|--------------------------------------------------------------------------
| 测试中间件
|--------------------------------------------------------------------------
|
| 在 tinker 中测试：
|
| php artisan tinker
|
| >>> app()->setLocale('de');
| >>> app()->getLocale();
| => "de"
|
| >>> __('home.welcome');
| => "Willkommen"  // 如果翻译文件已配置
|
|--------------------------------------------------------------------------
| 调试技巧
|--------------------------------------------------------------------------
|
| 1. 在控制器中查看当前语言：
| dd(app()->getLocale());
|
| 2. 在视图中查看：
| {{ app()->getLocale() }}
|
| 3. 查看所有翻译文件：
| ls -la resources/lang/
|
| 4. 测试路由是否正确设置语言：
| curl -H "Accept-Language: de" http://localhost:8000/
|
|--------------------------------------------------------------------------
| 性能优化
|--------------------------------------------------------------------------
|
| 如果网站流量大，可以考虑：
|
| 1. 缓存语言设置（减少Session读写）
| 2. 使用Cookie代替Session
| 3. 将语言配置移到config文件
| 4. 使用CDN缓存不同语言版本的静态资源
|
*/
