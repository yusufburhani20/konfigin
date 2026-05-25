@extends('layout')

@section('title', $page->title)

@section('content')
<!-- Page Header -->
<div class="page-header" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 6rem 2rem; text-align: center; margin-top: 60px;">
    <div class="container">
        <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem; color: white;">{{ $page->title }}</h1>
    </div>
</div>

<!-- Page Content -->
<section class="page-content" style="padding: 4rem 2rem; background: var(--section-bg);">
    <div class="container">
        <div style="background: white; border-radius: var(--radius); padding: 3rem; box-shadow: var(--shadow); max-width: 900px; margin: 0 auto; color: #374151; line-height: 1.8; font-size: 1.1rem;">
            {!! $page->content !!}
        </div>
    </div>
</section>
@endsection
