@extends('layout')

@section('title', $title)

@push('styles')
<style>
    :root {
        --post-card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --post-card-hover-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    #hero {
        position: relative;
        min-height: 40vh !important;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 120px 0 60px !important;
        background: transparent !important;
    }
    .hero-gradient-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #EEF5FF 0%, #F5F9FF 35%, #EBF4FF 60%, #F8FAFF 100%);
        z-index: 0;
    }
    .hero-glow-spots {
        position: absolute;
        inset: 0;
        pointer-events: none;
        overflow: hidden;
        z-index: 1;
    }
    .glow-spot {
        position: absolute;
        border-radius: 50%;
        filter: blur(70px);
        pointer-events: none;
    }
    .hero-title-modern {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        color: #1E2D4E;
        line-height: 1.25;
        margin-bottom: 1rem;
        letter-spacing: -0.5px;
    }
    .hero-subtitle-modern {
        font-family: 'Sora', sans-serif;
        font-size: 1rem;
        color: #5878A8;
        line-height: 1.6;
        max-width: 640px;
        margin: 0 auto;
    }
    .hero-badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(37, 99, 235, 0.1);
        border: 1px solid rgba(37, 99, 235, 0.25);
        padding: 7px 18px;
        border-radius: 100px;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(10px);
    }
    .badge-dot {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 10px #10b981;
        display: inline-block;
        animation: pulseDot 2s infinite;
    }
    @keyframes pulseDot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.4); opacity: 0.5; }
    }
    .badge-text {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--brand-royal);
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }
    .blog-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        padding: 6rem 1rem 4rem;
        text-align: center;
        margin-top: 60px;
        position: relative;
        overflow: hidden;
    }
    .blog-hero::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
        opacity: 0.1;
    }
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2.5rem;
    }
    .post-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--post-card-shadow);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid #f1f5f9;
    }
    .post-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--post-card-hover-shadow);
    }
    .post-media-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 16/10;
        overflow: hidden;
    }
    .post-thumb-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Swiper custom styles */
    .post-swiper {
        width: 100%;
        height: 100%;
    }
    .swiper-button-next, .swiper-button-prev {
        width: 30px !important;
        height: 30px !important;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        color: var(--primary) !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .swiper-button-next:after, .swiper-button-prev:after {
        font-size: 12px !important;
        font-weight: 900;
    }
    .swiper-pagination-bullet-active {
        background: var(--primary) !important;
    }

    .post-content-body {
        padding: 1.75rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .post-label-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .post-cat-pill {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 800;
        color: var(--primary);
        background: rgba(30, 64, 175, 0.1);
        padding: 0.35rem 0.8rem;
        border-radius: 6px;
    }
    .post-date-label {
        font-size: 0.8rem;
        color: #94a3b8;
        font-weight: 500;
    }
    .post-entry-title {
        font-size: 1.35rem;
        font-weight: 800;
        line-height: 1.3;
        color: #1e293b;
        margin-bottom: 1rem;
        transition: color 0.2s;
    }
    .post-card:hover .post-entry-title {
        color: var(--primary);
    }
    .post-entry-excerpt {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.7;
        margin-bottom: 1.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .post-entry-footer {
        margin-top: auto;
        padding-top: 1.25rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .post-author-sm {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155;
    }
    .author-circle-sm {
        width: 32px;
        height: 32px;
        background: var(--border);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }
    .btn-read-more {
        color: var(--primary);
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .sidebar-card {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: var(--post-card-shadow);
        position: sticky;
        top: 100px;
    }
</style>
@endpush

@section('content')
<!-- ===== HERO SECTION (Synced) ===== -->
<section id="hero" aria-label="Blog Hero Section" style="min-height: 45vh; padding: 120px 2rem 4rem;">
    <!-- Animated mesh gradient background -->
    <div class="hero-gradient-bg" aria-hidden="true"></div>
    
    <!-- Subtle clean soft glowing spots -->
    <div class="hero-glow-spots" aria-hidden="true">
        <div class="glow-spot" style="top: 10%; left: 15%; background: rgba(0, 114, 255, 0.12);"></div>
        <div class="glow-spot" style="bottom: 10%; right: 10%; background: rgba(0, 198, 255, 0.12);"></div>
    </div>
    
    <div class="hero-content" style="max-width: 800px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
        <div class="hero-badge-modern" style="margin: 0 auto 1.5rem;">
            <span class="badge-dot"></span>
            <span class="badge-text"><i class="fas fa-newspaper" style="margin-right:6px"></i> Warta &amp; Informasi Terkini</span>
        </div>
        <h1 class="hero-title-modern" style="text-align: center; font-size: clamp(2rem, 4vw, 3rem); line-height: 1.2;">
            {{ isset($current_cat) ? '📂 Kategori: ' . $current_cat->name : '📑 Blog &amp; Berita' }}
        </h1>
        <p class="hero-subtitle-modern" style="margin: 0 auto; text-align: center;">
            {{ isset($current_cat) ? 'Kumpulan kabar terbaru seputar IT Solutions dalam kategori ' . $current_cat->name : 'Ikuti informasi terhangat seputar IT Solutions, Jaringan, dan Custom Web Development dari tim ahli Konfigin IT Solutions.' }}
        </p>
    </div>
</section>

<div class="section-divider"></div>

<div class="container" style="padding: 5rem 1rem;">
    <div style="display: grid; grid-template-columns: 2.8fr 1.2fr; gap: 3.5rem;">
        
        <!-- Main Blog List -->
        <div>
            @if($posts->isEmpty())
                <div style="text-align: center; padding: 6rem 2rem; background: white; border-radius: 20px; border: 2px dashed #e2e8f0;">
                    <div style="font-size: 4rem; margin-bottom: 1.5rem;">🗞️</div>
                    <h3 style="font-size: 1.5rem; color: #1e293b;">Belum Ada Kabar Tersedia</h3>
                    <p style="color: #64748b;">Editor kami sedang merangkum berita menarik untuk Anda. Coba lagi nanti!</p>
                </div>
            @else
                <div class="blog-grid">
                    @foreach($posts as $post)
                    <article class="post-card">
                        <div class="post-media-wrapper">
                            @if($post->images->count() > 1)
                                <!-- Multi-image Slider -->
                                <div class="swiper post-swiper">
                                    <div class="swiper-wrapper">
                                        @foreach($post->images as $img)
                                        <div class="swiper-slide">
                                            <img src="{{ asset($img->image_path) }}" alt="{{ $post->title }}" class="post-thumb-img">
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-pagination"></div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            @elseif($post->featured_image)
                                <!-- Single Image -->
                                <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="post-thumb-img">
                            @else
                                <!-- No image placeholder -->
                                <div style="width:100%; height:100%; background: #f8fafc; display:flex; align-items:center; justify-content:center; color: #cbd5e1;">
                                    <i class="fas fa-newspaper fa-4x"></i>
                                </div>
                            @endif
                        </div>

                        <div class="post-content-body">
                            <div class="post-label-row">
                                <span class="post-cat-pill">{{ $post->category->name ?? 'Update' }}</span>
                                <span class="post-date-label">{{ $post->created_at->translatedFormat('d M, Y') }}</span>
                            </div>
                            
                            <h2 class="post-entry-title">
                                <a href="{{ route('blog.show', $post->slug) }}" style="text-decoration:none; color:inherit;">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            
                            <p class="post-entry-excerpt">{{ $post->excerpt }}</p>

                            <div class="post-entry-footer">
                                <div class="post-author-sm">
                                    <div class="author-circle-sm">{{ substr($post->author->nama ?? 'A', 0, 1) }}</div>
                                    <span>{{ $post->author->nama ?? 'Admin' }}</span>
                                </div>
                                <a href="{{ route('blog.show', $post->slug) }}" class="btn-read-more">
                                    Selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                <div style="margin-top: 4rem; display: flex; justify-content: center;">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <aside>
            <div class="sidebar-card">
                <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-th-large" style="color: var(--primary);"></i> Jelajah Kategori
                </h3>
                
                <ul style="list-style:none; padding:0; margin:0; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li>
                        <a href="{{ route('blog.index') }}" 
                           style="display: flex; justify-content: space-between; padding: 0.85rem 1rem; border-radius: 10px; text-decoration: none; transition: all 0.3s;
                                  {{ !isset($current_cat) ? 'background: var(--primary); color: white; box-shadow: 0 4px 12px rgba(30,64,175,0.3);' : 'background: #f8fafc; color: #475569;' }}">
                            <span style="font-weight: 700;">Semua Berita</span>
                            <i class="fas fa-chevron-right" style="opacity: 0.5;"></i>
                        </a>
                    </li>
                    @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('blog.category', $cat->slug) }}" 
                           style="display: flex; justify-content: space-between; align-items:center; padding: 0.85rem 1rem; border-radius: 10px; text-decoration: none; transition: all 0.3s;
                                  {{ isset($current_cat) && $current_cat->id == $cat->id ? 'background: var(--primary); color: white; box-shadow: 0 4px 12px rgba(30,64,175,0.3);' : 'background: #f8fafc; color: #475569;' }}">
                            <span style="font-weight: 700;">{{ $cat->name }}</span>
                            <span style="font-size: 0.8rem; background: rgba(0,0,0,0.05); padding: 2px 8px; border-radius: 99px;">{{ $cat->posts_count }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>

                <div style="margin-top: 3rem; padding: 1.5rem; background: linear-gradient(135deg, var(--primary), #1d4ed8); border-radius: 12px; color: white;">
                    <h4 style="margin: 0 0 0.5rem; font-weight: 800;">Langganan Berita</h4>
                    <p style="font-size: 0.85rem; opacity: 0.9; line-height: 1.5; margin-bottom: 1rem;">Ikuti terus perkembangan kami langsung dari website.</p>
                    <a href="#kontak" style="display: block; text-align:center; background: white; color: var(--primary); text-decoration:none; padding: 0.6rem; border-radius: 8px; font-weight: 800; font-size: 0.85rem;">Hubungi Kami</a>
                </div>
            </div>
        </aside>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swipers = new Swiper('.post-swiper', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
        });
    });
</script>
@endpush
