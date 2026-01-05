<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">

    <link rel="canonical" href="{{ url()->current() }}/">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="/css/all.min.css?v=1.1">
    <link rel="stylesheet" href="/css/main.css?v=1.6">

    @if(!empty($alternate_tag)) {!! $alternate_tag !!} @endif
    @if(!empty($gtag)){!! $gtag !!}@endif

    @if (isset($crumbs) && count($crumbs) > 0)
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [
                @foreach($crumbs as $index => $crumb)
                {
                    "@type": "ListItem",
                    "position": {{$index + 1}},
                        "name": "{!! str_replace("\"", "\\\"", $crumb['title']) !!}",
                        "item": "{{$crumb['absolute_url']}}"
                    }@if(!$loop->last),@endif
            @endforeach
            ]
        }
    </script>
    @endif
    @if (isset($blog) && $blog and in_array(\Illuminate\Support\Facades\Route::currentRouteName(), ['blog', 'blog.show', 'blog.show.localized']))
        <script type="application/ld+json">
    [
        {
            "@context": "https://schema.org",
            "@type": "Article",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{request()->url()}}"
            },
            "headline": "{!! str_replace("\"", "\\\"", $blog->title) !!}",
            "datePublished": "{{date("Y-m-d\TH:i:sP", strtotime($blog->published_at))}}",
            "dateModified": "{{date("Y-m-d\TH:i:sP", strtotime($blog->published_at))}}",
            "description": "{!! str_replace("\"", "\\\"", $blog->summary) !!}",
            "image": {
                "@type": "ImageObject",
                "url": "{{request()->root().$blog->head_img}}",
                "contentUrl": "{{request()->root().$blog->head_img}}"
            }
        }
        @if(!empty($blog->faq)),
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                @foreach($blog->faq as $faq)
                [
                   {
                       "@type": "Question",
                       "name": "{!! str_replace("\"", "\\\"", $faq['question']) !!}",
                           "acceptedAnswer": [
                               {
                                   "@type": "Answer",
                                   "text": "{!! str_replace("\"", "\\\"", $faq['answer']) !!}"
                               }
                           ]
                       }
                    ]
                    @if(!$loop->last),@endif
            @endforeach
            ]
        }
        @endif
            ]
</script>
    @endif
    @stack('styles')
</head>
<body>
    {{-- Navigation（sticky-top属性） --}}
    <nav class="navbar navbar-expand-lg" id="header">
        <div class="container">
            <a class="navbar-brand" href="{{ app()->getLocale() === 'en' ? '/' : '/'.app()->getLocale(). '/' }}">
                <img src="/images/logo.png?v=1.1" alt="{{ config('app.name') }}">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is(trim($category->slug, '/')) ? 'active' : '' }}"
                           href="{{ $category->url }}">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>

                {{-- Language Selector --}}
                <div class="dropdown language-selector">
                    <button class="btn dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-globe"></i> {{ strtoupper(app()->getLocale()) }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach(\App\Models\MaterielTask::LANGUAGES() as $key => $value)
                        <li>
                            @if(app()->getLocale() != $key)
                                <a class="dropdown-item" href="{{ $key === 'en' ? '/' : '/'.$key.'/' }}">
                                    {{ $value }}
                                </a>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>
    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" onclick="scrollToTop()" aria-label="Scroll to top">↑</button>

    {{-- Footer --}}
    <footer class="footer">
        <div class="container message">
            <div>
                <p class="footer-title"><i class="fas fa-gift"></i> {{ config('app.name') }}</p>
                <p>{{ \App\Models\MaterielTask::slogan(app()->getLocale()) }}</p>
            </div>

            <div>
                <p class="footer-title">{{ \App\Models\MaterielTask::quickLinks(app()->getLocale()) }}</p>
                <ul class="list-unstyled">
                    <li><a href="{{ app()->getLocale() === 'en' ? '/' : '/'.app()->getLocale().'/'}}">{{ \App\Models\MaterielTask::home(app()->getLocale()) }}</a></li>
                    @foreach(\App\Models\MaterielTask::SUPPORTS(app()->getLocale()) as $key=>$value)
                        @if(in_array($key, [1,2]))
                            @if(app()->getLocale() === 'en')
                                <li><a href="{{ "/".$value['uri']."/" }}">{{$value['name']}}</a></li>
                            @else
                                <li><a href="{{ "/".app()->getLocale().'/'.$value['uri']."/" }}">{{$value['name']}}</a></li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="footer-title">{{ \App\Models\MaterielTask::categoryName(app()->getLocale()) }}</p>
                <ul class="list-unstyled">
                    @foreach($categories->take(4) as $category)
                    <li><a href="{{ $category->url }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="footer-title">{{ \App\Models\MaterielTask::legal(app()->getLocale()) }}</p>
                <ul class="list-unstyled">
                    @foreach(\App\Models\MaterielTask::SUPPORTS(app()->getLocale()) as $key=>$value)
                        @if(in_array($key, [3,4]))
                            @if(app()->getLocale() === 'en')
                                <li><a href="{{ "/".$value['uri']."/" }}">{{$value['name']}}</a></li>
                            @else
                                <li><a href="{{ "/".app()->getLocale().'/'.$value['uri']."/" }}">{{$value['name']}}</a></li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="footer-bottom container">
            <p>&copy; {{ date('Y') }} {{ config('app.domain')}}. All rights reserved.</p>
        </div>
    </footer>

    <script src="/js/jquery-3.7.0.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/main.js"></script>
    @stack('scripts')
</body>
</html>
