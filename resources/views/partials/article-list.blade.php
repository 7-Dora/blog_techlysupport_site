<div class="article-list category-card-second">
    @forelse($blogs as $blog)
        <div class="col-lg-4 col-md-6 mb-4">
            <article class="blog-card" itemscope itemtype="https://schema.org/BlogPosting">
                <div class="blog-card-img-wrapper">
                    <img src="{{ $blog->head_img }}" alt="{{ $blog->head_img_alt }}" itemprop="image">
                </div>
                <div class="blog-card-body">
                    <div class="category right-card-2">
                        <span class="meta-item">
                            <i class="far fa-user"></i> {{ \App\Models\MaterielTask::by(app()->getLocale()) }}
                            <span>{{ $hotBlog->author }}</span>
                        </span>
                        <span class="meta-item">
                            <i class="far fa-calendar"></i> {{ \App\Models\MaterielTask::detailPublished(app()->getLocale()) }}
                            <time>
                                {{ $hotBlog->published_at->format('Y-m-d') }}
                            </time>
                        </span>
                    </div>
                    <a href="{{ $blog->url }}" class="text-decoration-none">
                        <p class="blog-card-title">{!! $blog->title !!}</p>
                    </a>
                    <p class="blog-card-text">{!! $blog->summary !!}</p>
                </div>
            </article>
        </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No articles found in this category yet.
        </div>
    </div>
    @endforelse
</div>
