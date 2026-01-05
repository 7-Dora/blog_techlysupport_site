<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $locale
     * @return mixed
     */
    public function handle($request, Closure $next, $locale = null)
    {
        // 如果直接传入了语言参数（如 setLocale:en），使用它
        if ($locale) {
            app()->setLocale($locale);
            return $next($request);
        }

        // 否则从路由参数中获取
        $locale = $request->route('locale');

        // 支持的语言列表
        $supportedLocales = ['en', 'de', 'fr', 'es'];

        // 如果语言有效，设置它
        if ($locale && in_array($locale, $supportedLocales)) {
            app()->setLocale($locale);
        } else {
            // 默认使用英语
            app()->setLocale('en');
        }
        return $next($request);
    }
}
