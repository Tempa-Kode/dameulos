@extends('layouts.guest')

@section('title', $kegiatan->judul)

@section('content')
    <!-- Blog Details Hero Begin -->
    <section class="blog-hero spad" style="margin-top: 110px;">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-9 text-center">
                    <div class="blog__hero__text">
                        <h2>{{ $kegiatan->judul }}</h2>
                        <ul>
                            <li>By Dame Ulos</li>
                            <li>{{ \Carbon\Carbon::parse($kegiatan->created_at)->locale('id')->translatedFormat('d F Y') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-12">
                    <div class="blog__details__pic">
                        <img src="{{ asset($kegiatan->gambar) }}" alt="">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="blog__details__content">
                        {!! $kegiatan->content ?? 'Tidak ada konten yang tersedia.' !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->
@endsection
