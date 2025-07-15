@extends('layouts.guest')

@section('title', 'Edit Profile - Dame Ulos')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Edit Profile</h4>
                    <div class="breadcrumb__links">
                        <a href="{{ route('pelanggan.home') }}">Home</a>
                        <span>Profile</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Profile Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle"></i>
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Error Messages --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Profile Information -->
                <div class="checkout__form">
                    <form method="POST" action="{{ route('customer.profile.update') }}">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="mb-4">Informasi Profile</h4>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Nama Lengkap<span>*</span></p>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>No. Telepon</p>
                                    <input type="text" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Role</p>
                                    <input type="text" value="{{ ucfirst($user->role) }}" readonly class="bg-light">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <p>Alamat</p>
                                    <textarea name="alamat" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">{{ old('alamat', $user->alamat) }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="site-btn">
                                    <i class="fa fa-save"></i> Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Change Password Section -->
                <div class="checkout__form mt-5">
                    <form method="POST" action="{{ route('customer.profile.password.update') }}">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="mb-4">Ganti Password</h4>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <p>Password Saat Ini<span>*</span></p>
                                    <input type="password" name="current_password" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Password Baru<span>*</span></p>
                                    <input type="password" name="password" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Konfirmasi Password Baru<span>*</span></p>
                                    <input type="password" name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="site-btn" style="background-color: #f39c12;">
                                    <i class="fa fa-lock"></i> Ganti Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Back to Account -->
                <div class="text-center mt-4">
                    <a href="{{ route('pelanggan.transaksi') }}" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-left"></i> Kembali ke Transaksi
                    </a>
                    <a href="{{ route('pelanggan.home') }}" class="btn btn-outline-secondary ms-2">
                        <i class="fa fa-home"></i> Kembali ke Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Profile Section End -->

@push('styles')
<style>
    .alert {
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }
    .checkout__input input[readonly] {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
    .btn-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        float: right;
        cursor: pointer;
    }
    .btn {
        padding: 10px 20px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
        margin: 5px;
    }
    .btn-outline-primary {
        color: #007bff;
        border: 1px solid #007bff;
        background-color: transparent;
    }
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }
    .btn-outline-secondary {
        color: #6c757d;
        border: 1px solid #6c757d;
        background-color: transparent;
    }
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-hide success alerts after 5 seconds
    setTimeout(function() {
        $('.alert-success').fadeOut();
    }, 5000);
</script>
@endpush
@endsection
