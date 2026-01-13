@extends('layout')

@section('title', $blog->title)
@section('description', $blog->summary)

@push('styles')
    <link rel="stylesheet" href="/css/custom-blog.css?v=1.9">
@endpush

@section('content')

<div class="container mt-3">
    <nav class="breadcrumb">
        <a href="{{ app()->getLocale() === 'en' ? '/' : '/'.app()->getLocale().'/' }}">{{ \App\Models\MaterielTask::home(app()->getLocale()) }}</a>
        &gt;
        <a href="{{ $blog->category ? $blog->category->url : '#' }}">{{ $blog->category_name }}</a>
        &gt;
        <span>{!! $blog->title !!}</span>
    </nav>
</div>
<div class="container mt-4">
    <article class="blog-detail">
        {{-- Article Header --}}
        <div class="col-lg-9 offset-3">
            <header class="mb-4">
                <h1 class="article-title">{!! $blog->title !!}</h1>

                <div class="article-meta">
                    <span class="meta-item">
                        <i class="far fa-user"></i> {{ \App\Models\MaterielTask::by(app()->getLocale()) }}
                        <span>{{ $blog->author }}</span>
                    </span>
                    <span class="meta-item">
                        <i class="far fa-calendar"></i> {{ \App\Models\MaterielTask::detailPublished(app()->getLocale()) }}
                        <time>
                            {{ $blog->published_at->format('Y-m-d') }}
                        </time>
                    </span>
                    <span class="meta-item">
                        <i class="far fa-folder"></i> {{ \App\Models\MaterielTask::filedUnder(app()->getLocale()) }}:
                        <a href="{{ $blog->category->url }}">{{ $blog->category_name }}</a>
                    </span>
                </div>
            </header>
        </div>
        <div class="article-center">
            <div class="latest-article">
                <aside class="sidebar">
                    {{-- Popular Posts in Same Category --}}
                    @if($popularBlogs->isNotEmpty())
                        <div class="sidebar-section mb-4">
                            <div class="sidebar-title">{{ \App\Models\MaterielTask::popular_articles(app()->getLocale()) }}</div>
                            <ul class="sidebar-list">
                                @foreach($popularBlogs as $popularBlog)
                                    <li class="sidebar-item">
                                        <a href="{{ $popularBlog->url }}" class="d-flex align-items-start">
                                            <img src="{{ $popularBlog->head_img }}"
                                                 alt="{{ $popularBlog->head_img_alt }}"
                                                 class="sidebar-thumb me-2">
                                            <div class="flex-grow-1">
                                                <p class="sidebar-post-title">{!! $popularBlog->title !!}</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </aside>
            </div>
            <div class="article-main">
                {{-- Article Content --}}
                <div class="article-content">
                    {!! $blog->content !!}
                </div>

                {{-- FAQ Section (if exists) --}}
                @if(!empty($blog->faq) && count($blog->faq) > 0)
                <div class="faq-section mt-5">
                    <h2 class="section-subtitle">FAQs</h2>
                    <div class="faq-list">
                        @foreach($blog->faq as $faq)
                        <div class="faq-item">
                            <h3 class="faq-question">{!! $faq['question'] !!}</h3>
                            <div class="faq-answer">
                                <div>{!! $faq['answer'] !!}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Related Posts --}}
                @if($relatedBlogs->isNotEmpty())
                <div class="related-posts mt-5">
                    <div class="section-subtitle">{{ \App\Models\MaterielTask::related_posts(app()->getLocale()) }}</div>
                    <div class="category-card-second">
                        @foreach($relatedBlogs as $relatedBlog)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <article class="blog-card">
                                    <div class="blog-card-img-wrapper">
                                        <img src="{{ $relatedBlog->head_img }}" alt="{{ $relatedBlog->head_img_alt}}">
                                    </div>
                                    <div class="blog-card-body">
                                        <a href="{{ $relatedBlog->url }}" class="text-decoration-none">
                                            <p class="blog-card-title">{!! $relatedBlog->title !!}</p>
                                        </a>
                                        <p class="blog-card-text">{!! $relatedBlog->summary !!}</p>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </article>
</div>
@endsection

