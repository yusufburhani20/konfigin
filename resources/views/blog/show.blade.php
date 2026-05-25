@extends('layout')

@section('title', $post->title)

@push('styles')
<style>
    .post-detail-header {
        padding: 8rem 1rem 5rem;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        margin-top: 60px;
        position: relative;
    }
    .post-breadcrumb {
        margin-bottom: 2rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #94a3b8;
    }
    .post-breadcrumb a {
        color: var(--primary);
        text-decoration: none;
    }
    .post-category-tag {
        display: inline-block;
        background: var(--primary);
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 800;
        margin-bottom: 2rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        box-shadow: 0 4px 12px rgba(30,64,175,0.2);
    }
    .post-main-title {
        font-size: 3.5rem;
        font-weight: 900;
        line-height: 1.1;
        color: #0f172a;
        margin-bottom: 2.5rem;
        letter-spacing: -1px;
    }
    .post-author-bar {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }
    .author-img-lg {
        width: 56px;
        height: 56px;
        background: #1e293b;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.25rem;
    }
    
    /* Article Content Styles */
    .article-body-wrapper {
        font-size: 1.2rem;
        line-height: 1.85;
        color: #334155;
    }
    .article-body-wrapper h1, .article-body-wrapper h2, .article-body-wrapper h3 {
        color: #0f172a;
        margin-top: 3rem;
        margin-bottom: 1.5rem;
        font-weight: 800;
    }
    .article-body-wrapper p {
        margin-bottom: 1.75rem;
    }
    .article-body-wrapper img {
        max-width: 100%;
        height: auto !important;
        border-radius: 20px;
        margin: 3rem 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }
    .article-body-wrapper blockquote {
        margin: 3rem 0;
        padding: 2.5rem;
        background: #f8fafc;
        border-left: 5px solid var(--primary);
        border-radius: 0 20px 20px 0;
        font-style: italic;
        font-size: 1.4rem;
        color: #1e293b;
    }

    /* Single Page Swiper */
    .show-swiper {
        width: 100%;
        border-radius: 24px;
        overflow: hidden;
        margin-bottom: 4rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .show-swiper-img {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
    }

    .sidebar-widget-modern {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        margin-bottom: 2.5rem;
    }
    .recent-post-link {
        display: flex;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
        text-decoration: none;
        align-items: center;
        transition: transform 0.2s;
    }
    .recent-post-link:hover {
        transform: translateX(5px);
    }
    .recent-post-link img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 12px;
        flex-shrink: 0;
    }
    .recent-post-info h4 {
        margin: 0;
        font-size: 1rem;
        line-height: 1.4;
        color: #1e293b;
        font-weight: 700;
    }
    
    @media (max-width: 768px) {
        .post-main-title { font-size: 2.5rem; }
    }
</style>
@endpush

@section('content')
<!-- ===== HERO SECTION (Synced) ===== -->
<section id="hero" aria-label="Post Detail Hero" style="min-height: 45vh; padding: 120px 2rem 3rem;">
    <!-- Animated mesh gradient background -->
    <div class="hero-gradient-bg" aria-hidden="true"></div>
    
    <!-- Subtle clean soft glowing spots -->
    <div class="hero-glow-spots" aria-hidden="true">
        <div class="glow-spot" style="top: 10%; left: 15%; background: rgba(0, 114, 255, 0.12);"></div>
        <div class="glow-spot" style="bottom: 10%; right: 10%; background: rgba(0, 198, 255, 0.12);"></div>
    </div>
    
    <div class="hero-content" style="max-width: 800px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
        <nav class="post-breadcrumb" style="margin-bottom: 1.5rem;">
            <a href="{{ route('home') }}">Beranda</a> / 
            <a href="{{ route('blog.index') }}">Berita</a>
        </nav>
        
        @if($post->category)
            <div class="hero-badge-modern" style="margin: 0 auto 1.5rem;">
                <span class="badge-dot"></span>
                <span class="badge-text"><i class="fas fa-tag" style="margin-right:6px"></i> {{ $post->category->name }}</span>
            </div>
        @endif
        
        <h1 class="hero-title-modern" style="text-align: center; font-size: clamp(1.8rem, 4vw, 3rem); line-height: 1.2;">
            {{ $post->title }}
        </h1>
        
        <div class="post-author-bar" style="justify-content: center; border-top: none; padding-top: 1rem;">
            <div class="author-img-lg" style="width: 42px; height: 42px; font-size: 1rem; background: var(--primary); color: white;">{{ substr($post->author->nama ?? 'A', 0, 1) }}</div>
            <div style="text-align: left;">
                <div style="font-weight: 800; color: #0f172a; font-size: 1rem;">{{ $post->author->nama ?? 'Redaksi' }}</div>
                <div style="color: #64748b; font-size: 0.8rem;">{{ $post->created_at->format('d M Y') }}</div>
            </div>
        </div>
    </div>
</section>

<div class="section-divider"></div>

<!-- Content Wrapper with White Background for visibility -->
<div style="background: white; color: #1e293b;">
    <div class="container" style="padding: 4rem 1rem;">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('blog.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali ke Berita
            </a>
        </div>
        <div style="display: grid; grid-template-columns: 2.5fr 1fr; gap: 4rem;">
            
            <!-- Article Content -->
            <main>
                @if($post->images->count() > 1)
                    <!-- Gallery Slider -->
                    <div class="swiper show-swiper">
                        <div class="swiper-wrapper">
                            @foreach($post->images as $img)
                            <div class="swiper-slide">
                                <img src="{{ asset($img->image_path) }}" alt="{{ $post->title }}" class="show-swiper-img">
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                @elseif($post->featured_image)
                    <!-- Single Featured Image -->
                    <div style="margin-bottom: 4rem;">
                        <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" style="width: 100%; border-radius: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                    </div>
                @endif

                <div class="article-body-wrapper">
                    {!! $post->content !!}
                </div>

                <!-- Bottom Author Box (Refined) -->
                <div style="margin-top: 5rem; padding: 2.5rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 20px; display: flex; gap: 2rem; align-items: center;">
                    <div class="author-img-lg" style="width: 80px; height: 80px; font-size: 2rem; background: var(--primary); color: white; box-shadow: 0 8px 16px rgba(14,165,233,0.3);">{{ substr($post->author->nama ?? 'A', 0, 1) }}</div>
                    <div>
                        <h3 style="margin: 0 0 0.5rem; color: #0f172a; font-weight: 800; font-size: 1.4rem;">Ditulis oleh {{ $post->author->nama ?? 'Admin' }}</h3>
                        <p style="margin: 0; color: #64748b; line-height: 1.6; font-size: 1rem;">Kontributor aktif yang berfokus pada perkembangan teknologi informasi, jaringan terstruktur, dan rekayasa perangkat lunak di Lingkungan Konfigin IT Solutions.</p>
                    </div>
                </div>
            </main>

            <!-- Sidebar -->
            <aside>
                <div class="sidebar-widget-modern" style="background: white; border: 1px solid #f1f5f9;">
                    <h3 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 2rem; color: #0f172a;">Kabar Terbaru</h3>
                    @foreach($recent_posts as $recent)
                    <a href="{{ route('blog.show', $recent->slug) }}" class="recent-post-link">
                        @if($recent->featured_image)
                            <img src="{{ asset($recent->featured_image) }}" alt="{{ $recent->title }}">
                        @else
                            <div style="width:80px; height:80px; background:#f1f5f9; border-radius:12px;"></div>
                        @endif
                        <div class="recent-post-info">
                            <h4>{{ Str::limit($recent->title, 50) }}</h4>
                            <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">{{ $recent->created_at->format('d M Y') }}</span>
                        </div>
                    </a>
                    @endforeach
                </div>

                <div class="sidebar-widget-modern" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; border: none;">
                    <h3 style="color: white; font-weight: 800; margin-bottom: 1rem;">Ada Pertanyaan?</h3>
                    <p style="opacity: 0.9; font-size: 0.95rem; line-height: 1.6; margin-bottom: 2rem;">Dapatkan informasi lebih lanjut seputar solusi IT, Jaringan, dan Software Kustom dari Konfigin IT Solutions.</p>
                    <a href="{{ route('home') }}#kontak" style="display: block; text-align:center; background: white; color: var(--primary); padding: 0.75rem; border-radius: 12px; font-weight: 800; text-decoration: none;">Hubungi Kami</a>
                </div>
            </aside>

        </div>
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
