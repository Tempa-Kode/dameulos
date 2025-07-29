@extends('layouts.app')

@section('halaman', 'Kegiatan/Berita')
@section('judul', $kegiatan->judul)

@push('styles')
<style>
    .card-body img {
        max-width: 100%;
        height: auto;
        display: block;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        @if($kegiatan->gambar)
            <img src="{{ asset($kegiatan->gambar) }}" class="img-fluid mb-3" alt="Gambar">
        @endif
        <div>{!! $kegiatan->content !!}</div>
    </div>
</div>
@endsection
