@extends('layouts.app')

@section('halaman', 'Kegiatan/Berita')
@section('judul', 'Tambah Data Kegiatan/Berita')

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h4>Input Data Kegiatan/Berita</h4>
        </div>
        <div class="card-body">
            @include('components.alert')

            <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" name="judul" id="judul" class="form-control" required value="{{ old('judul') }}">
                    @error('judul')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar (opsional)</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" value="{{ old('gambar') }}">
                    @error('gambar')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Konten</label>
                    <textarea name="content" id="classic-editor" class="form-control" rows="10">{{ old('content') }}</textarea>
                    @error('content')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#classic-editor'), {
            ckfinder: {
                uploadUrl: "{{ route('upload.image') }}"
            }
        })
        .then(editor => {
            console.log('CKEditor ready');
        })
        .catch(error => {
            console.error('CKEditor error:', error);
        });
</script>
@endpush

