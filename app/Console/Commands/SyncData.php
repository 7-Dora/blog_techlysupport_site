<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Category;
use App\Models\MaterielTask;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Site;

class SyncData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步站点数据';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $site = DB::connection('center')
            ->table('sites')
            ->where('id', 8)
            ->first();

        if ($site) {

            $siteData = ['name'=> $site->name, 'domain' => $site->domain];

            Site::updateOrCreate($siteData, $siteData);


//            $categorys = DB::connection('center')
//                ->table('categorys')
//                ->whereIn('id', explode(',', $site->category_ids))
//                ->get();
//            if ($categorys) {
//
//                $categoryData = [];
//
//                foreach ($categorys as $k => $category) {
//                    $categoryData[$k]['id'] = $category->id;
//                    $categoryData[$k]['name'] = $category->name;
//                    $categoryData[$k]['slug'] = $category->slug;
//                    $categoryData[$k]['language'] = $category->language;
//                    $categoryData[$k]['state'] = $category->state;
//                    if ($category->language == $site->default_language) {
//                        $categoryData[$k]['uri'] = '/' . $category->slug;
//                    } else {
//                        $categoryData[$k]['uri'] = '/'. $category->language . '/' . $category->slug;
//                    }
//
//                    $categoryData[$k]['created_at'] = date('Y-m-d H:i:s');
//                    $categoryData[$k]['updated_at'] = date('Y-m-d H:i:s');
//
//                }
//
//                Category::insert($categoryData);
//
//            }
//
//
//            $materiels = DB::connection('center')->table('materiel_tasks')
//                ->where('site_id', $site->id)
//                ->where('state', 2)
//                ->get();
//
//
//            if ($materiels) {
//
//                $materielData = [];
//
//                foreach ($materiels as $k => $materiel) {
//                    $materielData[$k]['site_id'] = $materiel->site_id;
//                    $materielData[$k]['language_code'] = $materiel->language_code;
//                    $materielData[$k]['type'] = $materiel->type;
//                    $materielData[$k]['category_id'] = $materiel->category_id;
//                    $materielData[$k]['seo_title'] = $materiel->seo_title;
//                    $materielData[$k]['seo_desc'] = $materiel->seo_desc;
//                    $materielData[$k]['h1'] = $materiel->h1;
//                    $materielData[$k]['path'] = $materiel->path;
//                    $materielData[$k]['slogan'] = $materiel->slogan;
//                    $materielData[$k]['content'] = $materiel->content;
//                    $materielData[$k]['state'] = $materiel->state;
//                }
//
//                MaterielTask::insert($materielData);
//
//            }

            $blogs = DB::connection('center')->table('blogs')
                ->where('use_domain', $site->domain)
                ->where('used_num', 0)
                ->where('category_id', 88)
                ->orderBy('language')
                ->limit(2)
                ->get();
            dump($blogs->count());

            if (!empty($blogs)) {
                $blogData = [];
                $updateData = [];
                foreach ($blogs as $k => $blog) {

                    // 发布时间 策略 每个语言每天发两篇 往前推
                    if ($k % 10 == 0) {
                        $day = 0;
                    }

                    if ($k % 2  == 0) {
                        $day++;
                    }

                    $blogData[$k]['title'] = $blog->title;
                    $blogData[$k]['title_uniq'] = $blog->title_uniq;
                    $blogData[$k]['h1'] = $blog->h1;
                    $blogData[$k]['summary'] = $blog->summary;
                    $blogData[$k]['content'] = $blog->content;
                    $blogData[$k]['content_faq'] = $blog->content_faq;
                    $blogData[$k]['head_img'] = $blog->head_img;
                    $blogData[$k]['head_img_alt'] = $blog->head_img_alt;
                    $blogData[$k]['keyword'] = $blog->keyword;
                    $blogData[$k]['language'] = $blog->language;
                    $blogData[$k]['published_at'] = date('Y-m-d', strtotime('-'.$day.' day', time()));
                    $blogData[$k]['category_id'] = $blog->category_id;
                    $blogData[$k]['category_name'] = $blog->category_name;
                    $blogData[$k]['author'] = $blog->author;
                    $blogData[$k]['volume'] = rand(1000, 10000);


                    array_push($updateData, $blog->id);
                }

                DB::connection('center')->table('blogs')
                    ->whereIn('id', $updateData)
                    ->update(['used_num' => 1]);


                Blog::insert($blogData);

            }



        }



    }
}
