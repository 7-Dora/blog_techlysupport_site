<?php


namespace App\Providers;


use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    /**
     * 获取当前语言的活跃分类（带缓存）
     */
    public static function getActiveCategories(?string $locale = null): Collection
    {
        $locale = $locale ?? app()->getLocale();
        return Cache::remember("categories_{$locale}", 3600, function () use ($locale) {
            return Category::active()
                ->byLanguage($locale)
                ->select('id', 'name', 'slug', 'language')
                ->where('state', 1)
                ->get()
                ->keyBy('id');
        });
    }
}
