@extends('layout')

@section('title', $seoInfo->seo_title ?? '')
@section('description', $seoInfo->seo_desc ?? '')

@push('styles')
    <link rel="stylesheet" href="/css/category.css?v=1.6">
@endpush

@section('content')
<div class="container mt-3">
    <nav class="breadcrumb">
        <a href="{{ app()->getLocale() === 'en' ? '/' : '/'.app()->getLocale().'/' }}">{{ \App\Models\MaterielTask::home(app()->getLocale()) }}</a>
        &gt;
        <span>{{ $categoryInfo->name }}</span>
    </nav>
</div>
{{-- Category Header --}}
<div class="hero-section py-5">
    <div class="container text-center categroy-summary">
        <h1>{{ $categoryInfo->name }}</h1>
        <p>{!! $seoInfo->content !!}</p>
    </div>
</div>

<div class="container mb-5">
    {{-- Popular Posts in Category --}}
    @if($hotBlogs->count()>0)
    <section class="mb-5">
        <p class="section-title">{{ \App\Models\MaterielTask::popular_articles(app()->getLocale()) }}</p>
        <div class="top-module">
            <div class="col-lg-6 mb-4 right-card">
                @php $firstPost = $hotBlogs->first(); @endphp
                @if($firstPost)
                <div class="blog-card featured-card">
                    <div class="blog-card-img-wrapper">
                        <img src="{{ $firstPost->head_img }}" alt="{{ $firstPost->head_img_alt ?? $firstPost->title }}">
                        <div class="blog-card-overlay">
                            <div class="category">
                                <span class="meta-item">
                                    <i class="far fa-user"></i> {{ \App\Models\MaterielTask::by(app()->getLocale()) }}
                                    <span itemprop="author">{{ $firstPost->author }}</span>
                                </span>
                                <span class="meta-item">
                                    <i class="far fa-calendar"></i> {{ \App\Models\MaterielTask::detailPublished(app()->getLocale()) }}
                                    <time itemprop="datePublished" datetime="{{ $firstPost->published_at->toIso8601String() }}">
                                        {{ $firstPost->published_at->format('Y-m-d') }}
                                    </time>
                                </span>
                            </div>
                            <a href="{{ $firstPost->url }}" class="text-decoration-none">
                                <p class="h4 mb-2 category-article-title">{{ $firstPost->title }}</p>
                            </a>
                            <p class="small mb-0">{{ $firstPost->summary }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="top-left-card">
                @foreach($hotBlogs->skip(1)->take(3) as $hotBlog)
                <div class="col-12 mb-3">
                        <div class="d-flex align-items-center hover-shadow top-card">
                            <img src="{{ $hotBlog->head_img }}" alt="{{ $hotBlog->head_img_alt}}"
                                 class="rounded me-3">
                            <div class="flex-grow-1">
                                <div class="right-card-2">
                                    <span class="meta-item">
                                        <i class="far fa-user"></i> {{ \App\Models\MaterielTask::by(app()->getLocale()) }}
                                        <span itemprop="author">{{ $hotBlog->author }}</span>
                                    </span>
                                    <span class="meta-item">
                                        <i class="far fa-calendar"></i> {{ \App\Models\MaterielTask::detailPublished(app()->getLocale()) }}
                                        <time itemprop="datePublished" datetime="{{ $hotBlog->published_at->toIso8601String() }}">
                                            {{ $hotBlog->published_at->format('Y-m-d') }}
                                        </time>
                                    </span>
                                </div>
                                <a href="{{ $hotBlog->url }}" class="text-decoration-none">
                                    <p class="h6 mb-1 little-card-desc">{{ $hotBlog->title }}</p>
                                </a>
                            </div>
                        </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Latest Posts Section --}}
    <section class="mb-5">
        <p class="section-title">{{ \App\Models\MaterielTask::recent_posts(app()->getLocale()) }}</p>

        {{-- Article List Container --}}
        <div id="article-list">
            @include('partials.article-list', ['blogs' => $blogs])
        </div>

        <!-- Improved Pagination -->
        {{--        @if($blogs->hasPages())--}}
        <div class="pagination-wrapper">
            <div class="pagination" id="pagination-container"
                 data-current-page="{{ $blogs->currentPage() }}"
                 data-last-page="{{ $blogs->lastPage() }}">
                {{-- Previous Page Link --}}
                @if ($blogs->onFirstPage())
                    <span class="disabled page-nav">‹</span>
                @else
                    <a href="javascript:void(0)" data-page="{{ $blogs->currentPage() - 1 }}" class="page-nav page-link">‹</a>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $currentPage = $blogs->currentPage();
                    $lastPage = $blogs->lastPage();
                    $start = max(1, $currentPage - 2);
                    $end = min($lastPage, $currentPage + 2);
                @endphp

                {{-- First Page --}}
                @if($start > 1)
                    <a href="javascript:void(0)" data-page="1" class="page-link">1</a>
                    @if($start > 2)
                        <span class="ellipsis">...</span>
                    @endif
                @endif

                {{-- Page Numbers --}}
                @for($page = $start; $page <= $end; $page++)
                    @if($page == $currentPage)
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="javascript:void(0)" data-page="{{ $page }}" class="page-link">{{ $page }}</a>
                    @endif
                @endfor

                {{-- Last Page --}}
                @if($end < $lastPage)
                    @if($end < $lastPage - 1)
                        <span class="ellipsis">...</span>
                    @endif
                    <a href="javascript:void(0)" data-page="{{ $lastPage }}" class="page-link">{{ $lastPage }}</a>
                @endif

                {{-- Next Page Link --}}
                @if ($blogs->hasMorePages())
                    <a href="javascript:void(0)" data-page="{{ $blogs->currentPage() + 1 }}" class="page-nav page-link">›</a>
                @else
                    <span class="disabled page-nav">›</span>
                @endif
            </div>

        </div>
    </section>
</div>
@endsection
@push('scripts')
<script src="/js/category.js" defer></script>
@endpush
