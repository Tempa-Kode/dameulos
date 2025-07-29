@extends('layouts.app')

@section('halaman', 'Kegiatan/Berita')

@section('judul', 'Edit Data Kegiatan/Berita')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Kegiatan/Berita</h4>
            </div>
            <div class="card-body">
                {{-- Tampilkan pesan alert --}}
                @include('components.alert')

                {{-- Form edit --}}
                <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Judul --}}
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                            value="{{ old('judul', $kegiatan->judul) }}" required>

                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konten --}}
                    <div class="form-group mt-3">
                        <label for="content">Konten</label>
                        <textarea name="content" id="classic-editor" rows="10"
                            class="form-control @error('content') is-invalid @enderror">{{ old('content', $kegiatan->content) }}</textarea>

                        @error('content')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
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
                    uploadUrl: "{{ route('upload.image') }}?_token={{ csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
