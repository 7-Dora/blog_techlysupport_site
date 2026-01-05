<?php

namespace App\Http\Controllers;

use App\Models\MaterielTask;

class PageController extends Controller
{
    /**
     * About Us 页面
     */
    public function about()
    {
        $pageInfo = $this->seoInfo(MaterielTask::TYPE_ABOUT);
        if (!$pageInfo) {
            return response()->view('errors.404', ['categories' => $this->categories], 404);
        }

        return view('page', [
            'gtag' => $this->site->gtag,
            'pageInfo' => $pageInfo,
            'categories' => $this->categories
        ]);
    }

    /**
     * Contact Us 页面
     */
    public function contact()
    {
        $pageInfo = $this->seoInfo(MaterielTask::TYPE_CONTACT);
        if (!$pageInfo) {
            return response()->view('errors.404', ['categories' => $this->categories], 404);
        }

        return view('page', [
            'gtag' => $this->site->gtag,
            'pageInfo' => $pageInfo,
            'categories' => $this->categories
        ]);
    }

    /**
     * Privacy Policy 页面
     */
    public function privacy()
    {
        $pageInfo = $this->seoInfo(MaterielTask::TYPE_POLICY);
        if (!$pageInfo) {
            return response()->view('errors.404', ['categories' => $this->categories], 404);
        }

        return view('page', [
            'gtag' => $this->site->gtag,
            'pageInfo' => $pageInfo,
            'categories' => $this->categories
        ]);
    }

    /**
     * Terms 页面
     */
    public function terms()
    {
        $pageInfo = $this->seoInfo(MaterielTask::TYPE_TERMS);
        if (!$pageInfo) {
            return response()->view('errors.404', ['categories' => $this->categories], 404);
        }

        return view('page', [
            'gtag' => $this->site->gtag,
            'pageInfo' => $pageInfo,
            'categories' => $this->categories
        ]);
    }

    public function error() {
        return response()->view('errors.404', ['categories' => $this->categories], 404);
    }
}
