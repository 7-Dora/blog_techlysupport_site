<?php

if (!function_exists('route_slash')) {
    function route_slash($name, $parameters = [], $absolute = true)
    {
        $url = route($name, $parameters, $absolute);

        // 如果不以 / 结尾且没有查询参数，添加斜杠
        if (!str_ends_with($url, '/') && !str_contains($url, '?')) {
            $url .= '/';
        }

        return $url;
    }
}
