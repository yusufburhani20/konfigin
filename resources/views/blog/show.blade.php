@extends('layout')

@section('title', $post->title)



@push('styles')
<style>
    /* ===== BLOG DETAIL HERO ===== */
    #blog-hero {
        background: #0b0f19;
        position: relative;
        overflow: hidden;
        padding: 140px 2rem 5rem;
        margin-top: 0;
    }

    #blog-hero .hero-gradient-bg {
        display: none;
    }

    #blog-hero .hero-glow-spots {
        display: none;
    }

    #blog-hero .hero-inner {
        max-width: 860px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .blog-breadcrumb {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 1.75rem;
    }
    .blog-breadcrumb a {
        color: #38bdf8;
        text-decoration: none;
        transition: color 0.2s;
    }
    .blog-breadcrumb a:hover { color: #ffffff; }
    .blog-breadcrumb i { font-size: 0.6rem; opacity: 0.5; color: rgba(255, 255, 255, 0.4); }

    .blog-post-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: clamp(1.8rem, 4.5vw, 3.25rem);
        font-weight: 900;
        color: #ffffff;
        line-height: 1.15;
        letter-spacing: -0.5px;
        margin: 1.5rem 0 2rem;
    }

    .blog-hero-meta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-top: 0.5rem;
    }

    .blog-hero-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.7);
        font-weight: 500;
    }

    .blog-hero-meta-item strong {
        color: #ffffff;
    }

    .blog-hero-meta-item i {
        color: #38bdf8;
        font-size: 0.85rem;
    }

    .blog-hero-author-avatar {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.95rem;
        box-shadow: 0 4px 12px rgba(0,114,255,0.3);
        flex-shrink: 0;
    }

    /* ===== ARTICLE CONTENT WRAPPER ===== */
    .blog-article-section {
        background: #ffffff;
        padding: 0;
    }

    .blog-article-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 4rem 2rem 5rem;
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 4rem;
        align-items: start;
    }

    /* Back button row */
    .blog-back-row {
        margin-bottom: 2.5rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Article content styles */
    .article-body-wrapper {
        font-size: 1.1rem;
        line-height: 1.9;
        color: #334155;
    }
    .article-body-wrapper h1,
    .article-body-wrapper h2,
    .article-body-wrapper h3 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #0f172a;
        margin-top: 3rem;
        margin-bottom: 1.25rem;
        font-weight: 800;
        line-height: 1.3;
    }
    .article-body-wrapper h2 { font-size: 1.75rem; }
    .article-body-wrapper h3 { font-size: 1.35rem; }
    .article-body-wrapper p { margin-bottom: 1.5rem; }
    .article-body-wrapper img {
        max-width: 100%;
        height: auto !important;
        border-radius: 20px;
        margin: 3rem 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        display: block;
    }
    .article-body-wrapper a {
        color: var(--primary);
        text-decoration: underline;
        text-decoration-style: dotted;
    }
    .article-body-wrapper blockquote {
        margin: 3rem 0;
        padding: 2rem 2.5rem;
        background: linear-gradient(135deg, rgba(0,114,255,0.04), rgba(0,198,255,0.04));
        border-left: 4px solid var(--primary);
        border-radius: 0 16px 16px 0;
        font-style: italic;
        font-size: 1.2rem;
        color: #1e293b;
    }
    .article-body-wrapper ul, .article-body-wrapper ol {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .article-body-wrapper li { margin-bottom: 0.5rem; }

    /* Featured image */
    .featured-img-wrap {
        border-radius: 24px;
        overflow: hidden;
        margin-bottom: 3.5rem;
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        aspect-ratio: 16/9;
    }
    .featured-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ===== AUTHOR BOX (PREMIUM) ===== */
    .author-box-premium {
        margin-top: 4rem;
        padding: 0;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.07);
        border: 1px solid #e2e8f0;
    }

    .author-box-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
        padding: 1.5rem 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .author-box-header span {
        font-size: 0.75rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .author-box-header i {
        color: #38bdf8;
        font-size: 0.9rem;
    }

    .author-box-body {
        background: #ffffff;
        padding: 2rem;
        display: flex;
        gap: 1.75rem;
        align-items: flex-start;
    }

    .author-avatar-xl {
        width: 80px;
        height: 80px;
        flex-shrink: 0;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 2rem;
        font-weight: 900;
        box-shadow: 0 8px 20px rgba(0,114,255,0.25);
    }

    .author-info-block h3 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.2rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 0.25rem;
    }

    .author-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(0,114,255,0.08);
        color: var(--primary);
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 3px 10px;
        border-radius: 100px;
        margin-bottom: 0.85rem;
    }

    .author-info-block p {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.65;
        margin: 0;
    }

    .author-box-footer {
        background: #f8fafc;
        padding: 1rem 2rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .author-date-info {
        font-size: 0.8rem;
        color: #94a3b8;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .author-date-info i { color: var(--primary); }

    /* ===== SIDEBAR ===== */
    .blog-sidebar {
        position: sticky;
        top: 100px;
    }

    .sidebar-widget {
        background: white;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    }

    .sidebar-widget-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 1rem;
        color: #0f172a;
    }

    .sidebar-widget-header i {
        color: var(--primary);
    }

    .sidebar-widget-body {
        padding: 1.25rem 1.5rem;
    }

    .recent-post-item {
        display: flex;
        gap: 1rem;
        align-items: center;
        padding: 0.85rem 0;
        text-decoration: none;
        border-bottom: 1px solid #f8fafc;
        transition: transform 0.2s;
    }

    .recent-post-item:last-child { border-bottom: none; }

    .recent-post-item:hover { transform: translateX(4px); }

    .recent-post-thumb {
        width: 68px;
        height: 68px;
        object-fit: cover;
        border-radius: 10px;
        flex-shrink: 0;
        background: #f1f5f9;
    }

    .recent-post-thumb-placeholder {
        width: 68px;
        height: 68px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        border-radius: 10px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
    }

    .recent-post-info h4 {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.35;
        margin: 0 0 0.3rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .recent-post-info span {
        font-size: 0.75rem;
        color: #94a3b8;
        font-weight: 500;
    }

    .sidebar-cta {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
        border-radius: 20px;
        padding: 2rem 1.5rem;
        text-align: center;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .sidebar-cta::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 150px; height: 150px;
        background: rgba(0,114,255,0.15);
        border-radius: 50%;
    }

    .sidebar-cta::after {
        content: '';
        position: absolute;
        bottom: -30px; left: -30px;
        width: 100px; height: 100px;
        background: rgba(0,198,255,0.1);
        border-radius: 50%;
    }

    .sidebar-cta h4 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 1.1rem;
        margin: 0 0 0.75rem;
        position: relative;
        z-index: 1;
    }

    .sidebar-cta p {
        font-size: 0.875rem;
        opacity: 0.8;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .sidebar-cta a {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        text-decoration: none;
        padding: 0.7rem 1.5rem;
        border-radius: 100px;
        font-weight: 700;
        font-size: 0.875rem;
        position: relative;
        z-index: 1;
        box-shadow: 0 6px 20px rgba(0,114,255,0.4);
        transition: all 0.2s;
    }

    .sidebar-cta a:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,114,255,0.5);
    }

    /* Swiper */
    .show-swiper {
        width: 100%;
        border-radius: 24px;
        overflow: hidden;
        margin-bottom: 3.5rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        aspect-ratio: 16/9;
    }
    .show-swiper-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .swiper-button-next, .swiper-button-prev {
        width: 36px !important;
        height: 36px !important;
        background: rgba(255,255,255,0.95);
        border-radius: 50%;
        color: var(--primary) !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .swiper-button-next:after, .swiper-button-prev:after {
        font-size: 12px !important;
        font-weight: 900;
    }
    .swiper-pagination-bullet-active {
        background: var(--primary) !important;
    }

    @media (max-width: 768px) {
        #blog-hero { padding: 110px 1.25rem 3rem; }
        .blog-post-title { font-size: 1.75rem; }
        .blog-article-inner { grid-template-columns: 1fr; gap: 2.5rem; padding: 2rem 1.25rem 3rem; }
        .blog-sidebar { position: static; }
        .author-box-body { flex-direction: column; align-items: center; text-align: center; }
    }
</style>
@endpush

@section('content')
{{-- ===== BLOG DETAIL HERO ===== --}}
<section id="blog-hero" aria-label="Post Detail Hero">
    <div class="hero-bg" aria-hidden="true" style="background-color: #0a0e17;">
    </div>

    <div class="hero-inner">
        {{-- Breadcrumb --}}
        <nav class="blog-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Beranda</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('blog.index') }}">Blog & Berita</a>
            @if($post->category)
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('blog.category', $post->category->slug) }}">{{ $post->category->name }}</a>
            @endif
        </nav>

        {{-- Category Badge --}}
        @if($post->category)
            <div class="hero-badge-modern" style="display:inline-flex; margin: 0 auto 0.5rem; background: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.2);">
                <span class="badge-dot"></span>
                <span class="badge-text" style="color: #38bdf8;"><i class="fas fa-tag" style="margin-right:5px"></i>{{ $post->category->name }}</span>
            </div>
        @endif

        {{-- Title --}}
        <h1 class="blog-post-title">{{ $post->title }}</h1>

        {{-- Meta Row --}}
        <div class="blog-hero-meta">
            <div class="blog-hero-meta-item">
                <div class="blog-hero-author-avatar">{{ substr($post->author->nama ?? 'A', 0, 1) }}</div>
                <span><strong>{{ $post->author->nama ?? 'Redaksi Konfigin' }}</strong></span>
            </div>
            <div class="blog-hero-meta-item">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ $post->created_at->translatedFormat('d F Y') }}</span>
            </div>
            <div class="blog-hero-meta-item">
                <i class="fas fa-clock"></i>
                <span>{{ max(1, intval(str_word_count(strip_tags($post->content)) / 200)) }} menit baca</span>
            </div>
        </div>
    </div>
</section>

<div class="section-divider"></div>

{{-- ===== ARTICLE CONTENT ===== --}}
<div class="blog-article-section">
    <div class="blog-article-inner">

        {{-- MAIN CONTENT --}}
        <main>
            {{-- Back button --}}
            <div class="blog-back-row">
                <a href="{{ route('blog.index') }}" class="btn btn-outline btn-sm" style="border-radius:100px;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Blog
                </a>
            </div>

            {{-- Featured Media --}}
            @if($post->images->count() > 1)
                <div class="swiper show-swiper">
                    <div class="swiper-wrapper">
                        @foreach($post->images as $img)
                        <div class="swiper-slide">
                            <img src="{{ asset(ltrim($img->image_path, '/')) }}" alt="{{ $post->title }}" class="show-swiper-img">
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            @elseif($post->featured_image)
                <div class="featured-img-wrap">
                    <img src="{{ asset(ltrim($post->featured_image, '/')) }}" alt="{{ $post->title }}">
                </div>
            @endif

            {{-- Article Body --}}
            <div class="article-body-wrapper">
                {!! $post->content !!}
            </div>

            {{-- ===== PREMIUM AUTHOR BOX ===== --}}
            <div class="author-box-premium">
                <div class="author-box-header">
                    <i class="fas fa-pen-nib"></i>
                    <span>Tentang Penulis</span>
                </div>
                <div class="author-box-body">
                    <div class="author-avatar-xl">{{ substr($post->author->nama ?? 'A', 0, 1) }}</div>
                    <div class="author-info-block">
                        <h3>{{ $post->author->nama ?? 'Admin Konfigin' }}</h3>
                        <div class="author-role-badge">
                            <i class="fas fa-shield-check"></i> Kontributor Resmi Konfigin IT Solutions
                        </div>
                        <p>Kontributor aktif yang berfokus pada perkembangan teknologi informasi, infrastruktur jaringan terstruktur, dan pengembangan perangkat lunak kustom di Konfigin IT Solutions.</p>
                    </div>
                </div>
                <div class="author-box-footer">
                    <div class="author-date-info">
                        <i class="fas fa-calendar-check"></i>
                        Dipublikasikan pada {{ $post->created_at->translatedFormat('d F Y, H:i') }} WIB
                    </div>
                    @if($post->updated_at->ne($post->created_at))
                        <div class="author-date-info">
                            <i class="fas fa-sync-alt"></i>
                            Diperbarui {{ $post->updated_at->diffForHumans() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>

        {{-- SIDEBAR --}}
        <aside class="blog-sidebar">

            {{-- Recent Posts Widget --}}
            <div class="sidebar-widget">
                <div class="sidebar-widget-header">
                    <i class="fas fa-newspaper"></i> Kabar Terbaru
                </div>
                <div class="sidebar-widget-body">
                    @forelse($recent_posts as $recent)
                    <a href="{{ route('blog.show', $recent->slug) }}" class="recent-post-item">
                        @if($recent->featured_image)
                            <img src="{{ asset(ltrim($recent->featured_image, '/')) }}" alt="{{ $recent->title }}" class="recent-post-thumb">
                        @else
                            <div class="recent-post-thumb-placeholder">
                                <i class="fas fa-newspaper"></i>
                            </div>
                        @endif
                        <div class="recent-post-info">
                            <h4>{{ Str::limit($recent->title, 55) }}</h4>
                            <span><i class="fas fa-calendar-alt" style="color:var(--primary); margin-right:4px; font-size:0.7rem;"></i>{{ $recent->created_at->format('d M Y') }}</span>
                        </div>
                    </a>
                    @empty
                        <p style="color:#94a3b8; font-size:0.9rem; text-align:center; padding: 1rem 0;">Belum ada artikel lain.</p>
                    @endforelse
                </div>
            </div>

            {{-- CTA Widget --}}
            <div class="sidebar-cta">
                <h4>Butuh Solusi IT?</h4>
                <p>Konsultasikan kebutuhan jaringan, aplikasi kustom, atau infrastruktur IT Anda bersama tim ahli kami.</p>
                <a href="{{ route('home') }}#kontak">
                    <i class="fab fa-whatsapp"></i> Hubungi Sekarang
                </a>
            </div>

        </aside>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.show-swiper', {
            loop: true,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
</script>
@endpush
