@extends('layout')

@section('title', $seoInfo->seo_title)
@section('description', $seoInfo->seo_desc)

@push('styles')
    <link rel="stylesheet" href="/css/home.css?v=1.2">
@endpush

@section('content')
{{-- Hero Section --}}
<div class="hero-section">
    <div class="container">
        <div class="top-decription">
            <div class="col-lg-6 mb-4">
                <h1>{{ \App\Models\MaterielTask::homeH1(app()->getLocale()) }}</h1>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <p>{{ \App\Models\MaterielTask::heroDesc(app()->getLocale()) }}</p>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    {{-- Popular Posts Section --}}
    @if($hotBlogs->isNotEmpty())
    <section class="mb-5 top-module">
        <div class="col-lg-6 mb-4 right-card">
            @php $firstPost = $hotBlogs->first(); @endphp
            <div class="blog-card featured-card">
                <div class="blog-card-img-wrapper">
                    <img src="{{ $firstPost->head_img }}" alt="{{ $firstPost->head_img_alt }}">
                    <div class="blog-card-overlay">
                        <div class="category category-1">
                            <a href="{{ $firstPost->category->url }}"><span class="blog-card-badge">{{ $firstPost->category_name }}</span></a>
                            <small class="card-date">{{ $firstPost->published_at->format('d M Y') }}</small>
                        </div>
                        <a href="{{ $firstPost->url }}" class="text-decoration-none">
                            <p class="h4 mb-2 category-article-title">{!! $firstPost->title !!}</p>
                        </a>
                        <p class="small mb-0">{!! $firstPost->summary !!}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row top-left-card">
            @foreach($hotBlogs->skip(1)->take(3) as $hotBlog)
            <div class="col-12 mb-3">
                <div class="d-flex align-items-center hover-shadow top-card">
                    <img src="{{ $hotBlog->head_img }}" alt="{{ $hotBlog->head_img_alt}}" class="rounded me-3">
                    <div class="flex-grow-1">
                        <div class="home-right-card">
                            <a href="{{ $hotBlog->category->url }}">
                                <span class="badge button-green mb-2">{{ $hotBlog->category_name }}</span>
                            </a>
                            <small class="text-muted card-date">{{ $hotBlog->published_at->format('d M Y') }}</small>
                        </div>
                        <a href="{{ $hotBlog->url }}" class="text-decoration-none">
                            <p class="h6 mb-1 little-card-desc">{!! $hotBlog->title !!}</p>
                        </a>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Categories Sections --}}
    @foreach($blogs as $categoryId => $categoryBlogs)
        @php
            // 直接通过 keyBy 后的索引访问，O(1) 复杂度，不触发查询
            $category = $categories[$categoryId] ?? null;
        @endphp
        <h2 class="section-title">{{ $category->name }}</h2>
        @if($loop->odd)
            @if($category)
            <section class="mb-5">
                <div class="category-card-first">
                    {{-- Featured Post (First 2 with overlay) --}}
                    @foreach($categoryBlogs->take(2) as $blog)
                    <div class="col-lg-6 mb-4">
                        <div class="blog-card">
                            <div class="blog-card-img-wrapper">
                                <img src="{{ $blog->head_img }}" alt="{{ $blog->head_img_alt }}">
                                <div class="blog-card-overlay">
                                    <div class="category">
                                        <a href="{{ $blog->category->url }}"><span class="blog-card-badge">{{ $blog->category_name }}</span></a>
                                        <small class="card-date">{{ $blog->published_at->format('d M Y') }}</small>
                                    </div>
                                    <a href="{{ $blog->url }}" class="text-decoration-none">
                                        <p class="h5 mb-2 category-article-title">{!! $blog->title !!}</p>
                                    </a>
                                    <p class="small mb-0">{!! $blog->summary !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{-- Regular Cards (Rest of posts) --}}
                @if($categoryBlogs->count() > 2)
                <div class="category-card-second">
                    @foreach($categoryBlogs->skip(2) as $blog)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <article class="blog-card">
                            <div class="blog-card-img-wrapper">
                                <img src="{{ $blog->head_img }}" alt="{{ $blog->head_img_alt }}" itemprop="image">
                            </div>
                            <div class="blog-card-body">
                                <div class="category">
                                    <a href="{{ $blog->category->url }}"><span class="blog-card-badge">{{ $blog->category_name }}</span></a>
                                    <small class="little-card-date">{{ $blog->published_at->format('d M Y') }}</small>
                                </div>
                                <a href="{{ $blog->url }}" class="text-decoration-none">
                                    <p class="blog-card-title" itemprop="headline">{!! $blog->title !!}</p>
                                </a>
                                <p class="blog-card-text" itemprop="description">{!! $blog->summary !!}</p>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>
                @endif
            </section>
            @endif
        @else
            <section class="mb-5 top-module">
                <div class="col-lg-6 mb-4 right-card">
                    @php $firstPost = $categoryBlogs->first(); @endphp
                    <div class="blog-card featured-card">
                        <div class="blog-card-img-wrapper">
                            <img src="{{ $firstPost->head_img }}" alt="{{ $firstPost->head_img_alt }}">
                            <div class="blog-card-overlay">
                                <div class="category category-1">
                                    <a href="{{ $firstPost->category->url }}"><span class="blog-card-badge">{{ $firstPost->category_name }}</span></a>
                                    <small class="card-date">{{ $firstPost->published_at->format('d M Y') }}</small>
                                </div>
                                <a href="{{ $firstPost->url }}" class="text-decoration-none">
                                    <p class="h4 mb-2 category-article-title">{!! $firstPost->title !!}</p>
                                </a>
                                <p class="small mb-0">{!! $firstPost->summary !!}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row top-left-card">
                    @foreach($categoryBlogs->skip(1)->take(3) as $hotBlog)
                        <div class="col-12 mb-3">
                            <div class="d-flex align-items-center hover-shadow top-card">
                                <img src="{{ $hotBlog->head_img }}" alt="{{ $hotBlog->head_img_alt}}" class="rounded me-3">
                                <div class="flex-grow-1">
                                    <div class="home-right-card">
                                        <a href="{{ $hotBlog->category->url }}">
                                            <span class="badge button-green  mb-2">{{ $hotBlog->category_name }}</span>
                                        </a>
                                        <small class="text-muted card-date">{{ $hotBlog->published_at->format('d M Y') }}</small>
                                    </div>
                                    <a href="{{ $hotBlog->url }}" class="text-decoration-none">
                                        <p class="h6 mb-1 little-card-desc">{!! $hotBlog->title !!}</p>
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    @endforeach

    {{-- Latest Posts Section --}}
    @if($latestBlogs->isNotEmpty())
    <section class="mb-5">
        <p class="section-title">Latest Post</p>
        <div class="row bottom-card">
            @foreach($latestBlogs as $latestBlog)
            <div class="col-md-6 mb-3">
                <div class="align-items-center border rounded-3 p-3 hover-shadow">
                    <div class="latest-card">
                        <a href="{{ $latestBlog->category->url }}"><span class="badge button-green mb-2">{{ $latestBlog->category_name }}</span></a>
                        <small class="text-muted">{{ $latestBlog->published_at->format('d M Y') }}</small>
                    </div>
                    <a href="{{ $latestBlog->url }}" class="text-decoration-none">
                    <div class="h6 mb-0">{!! $latestBlog->title !!}</div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
