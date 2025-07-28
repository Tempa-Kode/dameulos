<div id="carouselExampleControls" class="carousel slide carousel-fade" style="margin-top: 95px;" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" style="position: relative;">
            <img class="d-block w-100" src="{{ asset('home/img/hero/1.jpg') }}" alt="First slide">
            <div style="position: absolute; bottom: 0; width: 100%; height: 50%; background: linear-gradient(to top, rgba(0, 0, 0, 1), transparent);"></div>
            <div class="carousel-caption d-none d-md-block">
                <h5 class="text-white">Selamat Datang di Dame Ulos</h5>
                <p class="text-white">Temukan keindahan dan keunikan kain ulos tradisional yang memikat hati. Belanja sekarang dan jadikan bagian dari budaya Batak sebagai milik Anda.</p>
            </div>
        </div>
        @foreach ($promosi as $item)
            <div class="carousel-item" style="position: relative;">
                <img class="d-block w-100" src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}">
                <div style="position: absolute; bottom: 0; width: 100%; height: 50%; background: linear-gradient(to top, rgba(0, 0, 0, 1), transparent);"></div>
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="text-white">{{ $item->judul }}</h5>
                    <p class="text-white">{{ $item->deskripsi }}</p>
                </div>
            </div>
        @endforeach
        <div class="carousel-item" style="position: relative;">
            <img class="d-block w-100" src="{{ asset('home/img/hero/2.jpg') }}" alt="Second slide">
            <div style="position: absolute; bottom: 0; width: 100%; height: 50%; background: linear-gradient(to top, rgba(0, 0, 0, 1), transparent);"></div>
            <div class="carousel-caption d-none d-md-block">
                <h5 class="text-white">Koleksi Ulos Modern</h5>
                <p class="text-white">Perpaduan tradisi dan inovasi. Ulos modern yang cocok untuk gaya hidup masa kini. Pilih favorit Anda sekarang!</p>
            </div>
        </div>
        <div class="carousel-item" style="position: relative;">
            <img class="d-block w-100" src="{{ asset('home/img/hero/3.jpg') }}" alt="Third slide">
            <div style="position: absolute; bottom: 0; width: 100%; height: 50%; background: linear-gradient(to top, rgba(0, 0, 0, 1), transparent);"></div>
            <div class="carousel-caption d-none d-md-block">
                <h5 class="text-white">Keindahan Ulos untuk Semua</h5>
                <p class="text-white">Jelajahi koleksi ulos kami yang memadukan tradisi dan seni. Temukan ulos yang sesuai dengan gaya Anda.</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
