<?php

namespace App\Http\Controllers;

use App\Models\MaterielTask;
use App\Models\Site;
use App\Providers\CategoryService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $categories;
    protected $locale;
    protected $alternate_tag;
    protected $site;
    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->locale = app()->getLocale();
            $this->categories = CategoryService::getActiveCategories();
            return $next($request);
        });
        $alt_tag_list = [];
        foreach (MaterielTask::LANGUAGES() as $key=>$value) {
            if ($key == 'en') {
                $url = route('home');
            } else {
                $url = route('home.localized', ['locale' => $key]);
            }

            array_push($alt_tag_list,'    <link rel="alternate" href="'.$url.'/" hreflang="'.$key.'">');
        }
        $this->alternate_tag = implode("\n", $alt_tag_list);
        $this->site = Site::query()->first();
    }

    public function seoInfo($type, $categoryId=0) {
        $seoInfo = MaterielTask::byLanguage($this->locale)
            ->where('category_id', $categoryId)
            ->byType($type)
            ->first();
        return $seoInfo;
    }

    public function crumbs($categoryInfo=null, $blog=null) {
        $crumbs = [
            [
                'title'=>'Home',
                'absolute_url'=>$this->locale === 'en' ? route_slash('home') : route_slash('home.localized', ['locale' => $this->locale])
            ]
        ];
        if($categoryInfo) {
            array_push($crumbs, [
                'title' => $categoryInfo->name,
                'absolute_url'=>$categoryInfo->absoluteUrl(),
            ]);
        }
        if($blog) {
            array_push($crumbs, [
                'title' => $blog->title,
                'absolute_url' => $blog->absoluteUrl(),
            ]);
        }
        return $crumbs;
    }
}
