<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'google_categorys';

    protected $fillable = [
        'name', 'slug', 'uri', 'language', 'state'
    ];

    // 关联博客
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    // 查询作用域 - 只获取可用的分类
    public function scopeActive($query)
    {
        return $query->where('state', 1);
    }

    // 查询作用域 - 按语言过滤
    public function scopeByLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    // 获取分类URL
    public function getUrlAttribute()
    {
        $locale = $this->language;
        if ($locale === 'en') {
            return '/'.$this->slug. '/';
//            return route_slash('category', ['category' => $this->slug]);
        }
        return '/'.$locale.'/'.$this->slug. '/';
//        return route_slash('category.localized', ['locale' => $locale, 'category' => $this->slug]);
    }

    public function absoluteUrl() {
        $locale = $this->language;
        if ($locale === 'en') {
            return route_slash('category', ['category' => $this->slug]);
        }
        return route_slash('category.localized', ['locale' => $locale, 'category' => $this->slug]);
    }

    public static function buttonClass($v) {
        if($v == 'computers-and-electronics') {
            return 'bg-success';
        } elseif ($v == 'home-and-lifestyle') {
            return 'bg-primary';
        } elseif ($v == 'health-and-fitness') {
            return 'bg-warning';
        } else {
            return 'bg-danger';
        }
    }
}
