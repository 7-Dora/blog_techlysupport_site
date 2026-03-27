<?php

namespace App\Services;

class ThemeManager
{
    protected string $theme;

    public function __construct(string $theme = 'techlysupport')
    {
        $this->theme = $theme;
    }

    /**
     * 获取主题 CSS 路径
     */
    public function css(string $file): string
    {
        return "/css/themes/{$this->theme}/{$file}";
    }

    /**
     * 获取主题 JS 路径
     */
    public function js(string $file): string
    {
        return "/js/themes/{$this->theme}/{$file}";
    }
}
