<?php

namespace App\Models;

use QL\QueryList;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'google_blogs';

    protected $fillable = [
        'title', 'title_uniq', 'h1', 'summary', 'content', 'content_faq',
        'head_img', 'keyword', 'language', 'published_at', 'category_id',
        'category_name', 'volume', 'author', 'state'
    ];

    protected $dates = ['published_at', 'create_time', 'update_time'];

    public $timestamps = false;

    // 关联分类
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // 查询作用域 - 只获取可用的博客
    public function scopeActive($query)
    {
        return $query->where('state', 1);
    }

    // 查询作用域 - 按语言过滤
    public function scopeByLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    // 查询作用域 - 按分类过滤
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeGetPerCategory($query, array $categoryIds, $limit = 6)
    {
        return $query->whereIn('category_id', $categoryIds)
            ->orderBy('published_at', 'desc')
            ->get()
            ->groupBy('category_id')
            ->map(function($items) use ($limit) {
                return $items->take($limit);
            })
            ->flatten();
    }

    // 增加阅读量
    public function incrementVolume()
    {
        $this->increment('volume');
    }

    // 获取URL
    public function getUrlAttribute()
    {
        $locale = $this->language;
        if ($locale === 'en') {
            return '/blogs/' . $this->title_uniq . '/';
//            return route_slash('blog.show', ['title_uniq' => $this->title_uniq]);
        }
        return '/'.$locale.'/' . 'blogs/' . $this->title_uniq . '/';
//        return route_slash('blog.show.localized', ['locale' => $locale, 'title_uniq' => $this->title_uniq]);
    }

    public function absoluteUrl()
    {
        $locale = $this->language;
        if ($locale === 'en') {
            return route_slash('blog.show', ['title_uniq' => $this->title_uniq]);
        }
        return route_slash('blog.show.localized', ['locale' => $locale, 'title_uniq' => $this->title_uniq]);
    }

    public function getFaqAttribute()
    {
        $faqData = [];
        $queryList = QueryList::html($this->content_faq);
        if($this->content_faq) {
            $html = $this->content_faq;

            // 匹配每个h3及其后面直到下一个h3或结尾的所有内容
            $pattern = '/<h3>(.*?)<\/h3>\s*((?:<p>.*?<\/p>\s*)*)/s';

            preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $answers = '';
                $question = trim($match[1]);
                $content = trim($match[2]);
                // 提取所有p标签内容
                if (preg_match_all('/<p>(.*?)<\/p>/s', $content, $pMatches)) {
                    $answers .= implode('', array_map('trim', $pMatches[1]));
                } else {
                    $answers = '';
                }

                $faqData[] = [
                    'question' => $question,
                    'answer' => $answers
                ];
            }
        }
        return $faqData;
    }
//    public function getContentAttribute() {
//        $value = $this->attributes['content'] ?? null;
//
//        if ($value) {
//            return str_replace('https://global-ec-1251174242.cos.ap-hongkong.myqcloud.com', '/image', $value);
//        }
//
//        return $value;
//    }
//
//    public function getHeadImgAttribute() {
//        $value = $this->attributes['head_img'] ?? null;
//
//        if ($value) {
//            return str_replace('https://global-ec-1251174242.cos.ap-hongkong.myqcloud.com', '/image', $value);
//        }
//
//        return $value;
//    }

}
