<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Category;
use App\Models\MaterielTask;

class SitemapService
{

    private $homePageUri = ['/', '/about/', '/contact/', '/privacy/', '/terms/'];

    private $blogPageUri = '/blogs/{title_uniq}/';

    private $pidPageUri = '/{category}/';

    private $language = [];

    private $domain = "";


    public function __construct()
    {
        $this->language = array_keys(MaterielTask::LANGUAGES());
        $this->domain = "https://www.".config('app.domain')."/";

    }

    public function createSiteMap() :void
    {
//        $syncDisk = Storage::disk('root');
        $path = public_path('sitemap.xml');

        foreach ($this->language as $lang) {

            $this->domain = "https://www.".config('app.domain')."/";

            if ($lang != config('app.default_language')) {
                $this->domain = $this->domain . $lang;
            } else {
                $this->domain = 'https://www.'.config('app.domain');
            }

            $content = $this->_createSitemapContent($lang);
            file_put_contents(public_path($lang.'-sitemap.xml'), $content);
        }

        $content = $this->_createIndexSitemapContent();
//        $path = $syncDisk->path('sitemap.xml');
        file_put_contents($path, $content);

    }

    protected function _createIndexSitemapContent() :string
    {
        $this->domain = "https://www.".config('app.domain');
        $content = "<?xml version='1.0' encoding='UTF-8'?>\n";
        $content .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.google.com/schemas/sitemap/0.84 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
        foreach ($this->language as $lang) {
            $time = date("Y-m-d\TH:i:sP", time());
            $url = rtrim($this->domain, '/'). '/' . $lang . '-sitemap.xml';
            $content .= "<url>\n<loc>" . $url . "</loc>\n<lastmod>" . $time . "</lastmod>\n</url>\n";
        }
        $content .= "\n</urlset>";
        return $content;
    }

    protected function _createSitemapContent($lang) :string
    {
        $urls = $this->getUrl($lang);
        $content = "<?xml version='1.0' encoding='UTF-8'?>\n";
        $content .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.google.com/schemas/sitemap/0.84 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
        foreach ($urls as $url => $time) {
            $time = date("Y-m-d\TH:i:sP", $time);
            $content .= "<url>\n<loc>" . $url . "</loc>\n<lastmod>" . $time . "</lastmod>\n</url>\n";
        }
        $content .= "\n</urlset>";
        return $content;
    }

    protected function getUrl($lang) :array
    {

        $urls = [];

        foreach ($this->homePageUri as $uri) {
            $urls = array_merge($urls, $this->getPageUrl($uri));
        }

        $urls = array_merge($urls, $this->getBlogUrl($lang));

        $urls = array_merge($urls, $this->getCategoryPageUrl($lang));


        return $urls;
    }

    public function getBlogUrl($lang) :array
    {
        $urls = [];
        $articles = Blog::where('language', $lang)->where('state', 1)->select('title_uniq', 'published_at')->get();
        foreach($articles as $article) {
            $detailUrl = $this->domain . str_replace('{title_uniq}', $article->title_uniq, $this->blogPageUri);
            $urls[$detailUrl] = strtotime($article->published_at);
        }

        return $urls;
    }

    public function getCategoryPageUrl($lang) :array
    {
        $urls = [];

        $keywords = Category::where('language', $lang)->where('state', 1)->select('slug', 'updated_at')->get();
        foreach($keywords as $keyword) {
            $detailUrl = $this->domain . str_replace('{category}', $keyword->slug, $this->pidPageUri);
            $urls[$detailUrl] = strtotime($keyword->updated_at);
        }

        return $urls;
    }

    protected function getPageUrl(string $uri) :array
    {
        $urls = [];
        $url = $this->domain . $uri ;
        $urls[$url] = time();
        return $urls;
    }


}
