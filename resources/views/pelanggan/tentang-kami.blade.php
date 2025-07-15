@extends('layouts.guest')

@section('title', 'Tentang Kami - Dame Ulos')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Tentang Kami</h4>
                    <div class="breadcrumb__links">
                        <a href="{{ route('pelanggan.home') }}">Home</a>
                        <span>Tentang Kami</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- About Hero Section Begin -->
<section class="about-hero spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-hero__text">
                    <div class="section-title">
                        <span>Tentang Dame Ulos</span>
                        <h2>Melestarikan Warisan Budaya <br>Batak Melalui Ulos</h2>
                    </div>
                    <p>Dame Ulos merupakan brand lokal asal Silindung (Tarutung) yang fokus dalam melestarikan “Warisan Budaya Takbenda” yaitu “Ulos dan Mandar Tarutung”. Masing-masing ulos dan mandar dibuat dengan konsep “Revitalisasi” menggunakan pewarna alami dan melestarikan tradisi tenun tradisional (gedog) dengan mengikuti motif aslinya sehingga nilai filosofis yang terkandung dalam kain tetap terjaga.</p>
                    <p>Kini Dame Ulos berkolaborasi dengan 150 perajin/penenun terbaik di Silindung dan sekitarnya. Karya mereka diapresiasi dan dihargai dengan nilai yang pantas untuk membantu para perajin menjalani kehidupan yang lebih baik dan mengelola sumber dayanya secara berkelanjutan serta meneruskan tradisi Batak.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-hero__img">
                    <img src="{{ asset('images/logo-dameulos.png') }}" alt="Dame Ulos" style="width: 100%; height: 400px; object-fit: contain; border-radius: 10px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 40px;">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Hero Section End -->

<!-- Founder Story Section Begin -->
<section class="about-story spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Sang Pendiri</span>
                    <h2>Renny Manurung</h2>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="founder-image">
                    <div style="width: 100%; height: 500px; border-radius: 15px; overflow: hidden; position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                        <img src="{{ asset('images/FOUNDER.jpg') }}" alt="Renny Manurung - Pendiri Dame Ulos" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); padding: 30px 20px 20px; color: white;">
                            <h4 style="margin: 0; font-size: 1.4rem; font-weight: 600;" class="text-white">Renny Manurung</h4>
                            <p style="margin: 5px 0 0 0; font-size: 1rem; opacity: 0.9;" class="text-white">Pendiri Dame Ulos</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="founder-story">
                    <p style="font-size: 16px; line-height: 1.8; color: #555; text-align: justify; margin-bottom: 20px;">
                        Terkenal sebagai pendiri Dame Ulos, Renny Manurung mendirikan usaha tersebut didorong oleh keprihatinannya atas menurunnya minat dan rendahnya nilai jual ulos di Tarutung. Hal ini mendorongnya untuk kembali ke kampung halamannya dan berkonsentrasi menggali dan meningkatkan potensi warisan budaya tersebut.
                    </p>
                    <p style="font-size: 16px; line-height: 1.8; color: #555; text-align: justify; margin-bottom: 20px;">
                        Kreativitas Renny Manurung dalam mendesain ulos dan mandar bermula dari pengalaman menenun seumur hidupnya. Dengan bantuan Sandra Niessen, seorang antropolog Belanda yang penelitiannya dituangkan dalam bukunya "Legacy in Cloth," Dame Ulos memulai gerakan "revitalisasi" untuk menghidupkan kembali desain ulos leluhur yang telah berhenti produksi selama beberapa dekade.
                    </p>
                    <p style="font-size: 16px; line-height: 1.8; color: #555; text-align: justify; margin-bottom: 20px;">
                        Komitmen dan konsistensi mereka dalam memanfaatkan bahan baku lokal, pewarna alami, dan teknik tradisional membuka jalan bagi Dame Ulos untuk memasuki pasar internasional, termasuk Eropa. Selain melestarikan warisan budaya, Dame Ulos juga mewujudkan nilai-nilai kemanusiaan yang penting, termasuk kepedulian terhadap lingkungan dan keberlanjutan.
                    </p>
                    <p style="font-size: 16px; line-height: 1.8; color: #555; text-align: justify;">
                        Upaya ini menghasilkan berbagai penghargaan bagi Dame Ulos, termasuk pengakuan dari AGAATI Foundation sebagai "Winner kategori Handwoven" dari 250 perajin sedunia dari 50 negara yang berkantor pusat di New York, Amerika Serikat, pada tahun 2022.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Founder Story Section End -->


<!-- Mission Vision Section Begin -->
<section class="mission-vision spad" style="background: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Visi Dan Misi Kami</span>
                    <h2>Melestarikan Warisan melalui Revitalisasi Ulos & Pemberdayaan Perempuan</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- D - Dedication -->
            <div class="col-lg-3 col-md-6">
                <div class="dame-item">
                    <div class="dame-letter">D</div>
                    <h4>Dedication</h4>
                    <p>Menghidupkan kembali motif Ulos kuno yang berada di ambang kepunahan dengan tetap melestarikan tradisi tenun gedog.</p>
                </div>
            </div>
            <!-- A - Assure -->
            <div class="col-lg-3 col-md-6">
                <div class="dame-item">
                    <div class="dame-letter">A</div>
                    <h4>Assure</h4>
                    <p>Meningkatkan penghidupan perempuan yang bergerak di bidang tenun.</p>
                </div>
            </div>
            <!-- M - Maintaining -->
            <div class="col-lg-3 col-md-6">
                <div class="dame-item">
                    <div class="dame-letter">M</div>
                    <h4>Maintaining</h4>
                    <p>Mengembalikan cara pewarnaan tradisional & alami pada ulos.</p>
                </div>
            </div>
            <!-- E - Environment -->
            <div class="col-lg-3 col-md-6">
                <div class="dame-item">
                    <div class="dame-letter">E</div>
                    <h4>Environment</h4>
                    <p>Melestarikan ekosistem ekologi.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Mission Vision Section End -->

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Hubungi Kami</span>
                    <h2>Kontak Dame Ulos</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="contact__info__item">
                    <div class="contact__info__item__icon">
                        <i class="fa fa-map-marker" style="font-size: 2rem; color: #ca1515; margin-bottom: 15px;"></i>
                    </div>
                    <h4>Alamat</h4>
                    <p>Sai nihuta, Banjarnahor, Hutatoruan V, <b>Kec. Tarutung, Kabupaten Tapanuli Utara</b>, Sumatera Utara 22411</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="contact__info__item">
                    <div class="contact__info__item__icon">
                        <i class="fa fa-phone" style="font-size: 2rem; color: #ca1515; margin-bottom: 15px;"></i>
                    </div>
                    <h4>Telepon</h4>
                    <p>+62 xxx xxx xxxx<br>+62 xxx xxx xxxx</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="contact__info__item">
                    <div class="contact__info__item__icon">
                        <i class="fa fa-envelope" style="font-size: 2rem; color: #ca1515; margin-bottom: 15px;"></i>
                    </div>
                    <h4>Email</h4>
                    <p>info@dameulos.com<br>admin@dameulos.com</p>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="contact__map">
                    <h4 class="mb-3">Lokasi Kami</h4>
                    <div class="map-container" style="height: 400px; border-radius: 10px; overflow: hidden; position: relative;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4028.9098388830025!2d98.9762901!3d2.0054016!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e6ffebb2f78df%3A0xd9b82ef76bdfcc5b!2sGALERI%20DAME%20ULOS!5e1!3m2!1sen!2sid!4v1752604602263!5m2!1sen!2sid" style="border:0; width: 100%; height: 100%; position: absolute; top: 0; left: 0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

@push('styles')
<style>
    .about-hero {
        padding: 80px 0;
    }

    .about-hero__text {
        padding-right: 30px;
    }

    .about-hero__counter {
        display: flex;
        margin-top: 40px;
        gap: 30px;
    }

    .about-hero__counter__item {
        text-align: center;
    }

    .about-hero__counter__item h2 {
        font-size: 2.5rem;
        color: #ca1515;
        margin-bottom: 5px;
    }

    .about-hero__counter__item span {
        font-size: 1.5rem;
        color: #ca1515;
    }

    .about-hero__counter__item p {
        font-size: 14px;
        color: #666;
        margin-top: 10px;
    }

    .about-story__item {
        text-align: center;
        padding: 30px 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .about-story__item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .about-story__item__icon {
        margin-bottom: 20px;
    }

    .about-story__item h4 {
        color: #333;
        margin-bottom: 15px;
    }

    /* Founder Story Styles */
    .founder-image {
        padding: 20px;
    }

    .founder-story {
        padding: 20px 30px;
    }

    .founder-story p {
        margin-bottom: 25px;
    }

    .founder-story p:last-child {
        margin-bottom: 0;
    }

    @media (max-width: 991px) {
        .founder-image {
            margin-bottom: 40px;
        }

        .founder-story {
            padding: 20px 15px;
        }
    }

    .values__item {
        text-align: center;
        padding: 30px 20px;
        background: white;
        border-radius: 10px;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }

    .values__item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .values__item h4 {
        color: #333;
        margin-bottom: 15px;
    }

    .team__item {
        text-align: center;
        margin-bottom: 30px;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .team__item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .team__item__text {
        padding: 20px;
    }

    .team__item__text h4 {
        color: #333;
        margin-bottom: 5px;
    }

    .team__item__text span {
        color: #ca1515;
        font-weight: bold;
        display: block;
        margin-bottom: 15px;
    }

    .mission-vision__item {
        padding: 30px;
        border-radius: 10px;
        backdrop-filter: blur(10px);
        background: rgba(255,255,255,0.1);
        margin-bottom: 30px;
    }

    /* DAME Mission Vision Styles */
    .dame-item {
        text-align: center;
        padding: 40px 20px;
        background: white;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border-top: 4px solid #ca1515;
        height: 350px; /* Fixed height for all cards */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .dame-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        border-top-color: #a91111;
    }

    .dame-letter {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #ca1515 0%, #ff6b6b 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: bold;
        color: white;
        margin: 0 auto 25px;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .dame-item:hover .dame-letter {
        transform: scale(1.1);
        box-shadow: 0 10px 20px rgba(202, 21, 21, 0.3);
    }

    .dame-item h4 {
        color: #333;
        margin-bottom: 20px;
        font-size: 1.3rem;
        font-weight: 600;
        flex-shrink: 0;
    }

    .dame-item p {
        color: #666;
        line-height: 1.7;
        font-size: 15px;
        margin-bottom: 0;
        flex-grow: 1;
        display: flex;
        align-items: center;
        text-align: center;
    }

    @media (max-width: 991px) {
        .dame-item {
            height: 300px; /* Slightly shorter on mobile */
            padding: 30px 15px;
        }

        .dame-letter {
            width: 60px;
            height: 60px;
            font-size: 2rem;
        }
    }

    @media (max-width: 767px) {
        .dame-item {
            height: 280px; /* Even shorter on small mobile */
            padding: 25px 15px;
        }

        .dame-item h4 {
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .dame-item p {
            font-size: 14px;
            line-height: 1.6;
        }
    }

    .cta {
        background: #f8f9fa;
    }

    .cta__content h2 {
        color: #333;
        margin-bottom: 20px;
    }

    .cta__content p {
        color: #666;
        margin-bottom: 30px;
        font-size: 16px;
    }

    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title span {
        color: #ca1515;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .section-title h2 {
        color: #333;
        font-size: 2.5rem;
        margin-top: 10px;
    }

    .primary-btn {
        background: #ca1515;
        color: white;
        padding: 15px 30px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .primary-btn:hover {
        background: #a91111;
        transform: translateY(-2px);
        text-decoration: none;
        color: white;
    }

    /* Contact Section Styles */
    .contact {
        background: #f8f9fa;
    }

    .contact__info__item {
        margin-bottom: 30px;
        text-align: center;
        padding: 30px 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
    }

    .contact__info__item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .contact__info__item h4 {
        color: #333;
        margin-bottom: 15px;
        font-size: 1.2rem;
    }

    .contact__info__item p {
        color: #666;
        margin-bottom: 0;
        line-height: 1.6;
    }

    @media (max-width: 767px) {
        .contact__info__item {
            margin-bottom: 20px;
            padding: 25px 15px;
        }
    }

    .contact__form {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .contact__form h4 {
        color: #333;
        margin-bottom: 30px;
        font-size: 1.5rem;
    }

    .contact__form input,
    .contact__form textarea {
        width: 100%;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .contact__form input:focus,
    .contact__form textarea:focus {
        outline: none;
        border-color: #ca1515;
    }

    .contact__form textarea {
        resize: vertical;
        min-height: 120px;
    }

    .contact__map {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .contact__map h4 {
        color: #333;
        margin-bottom: 20px;
    }

    .map-container {
        border-radius: 10px;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
    // Counter Animation
    function animateCounter() {
        $('.count').each(function() {
            var $this = $(this);
            var countTo = parseInt($this.text());

            $({ countNum: 0 }).animate({
                countNum: countTo
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function() {
                    $this.text(this.countNum);
                }
            });
        });
    }

    // Trigger animation when scrolling to the section
    $(window).scroll(function() {
        var aboutHeroTop = $('.about-hero').offset().top;
        var windowBottom = $(window).scrollTop() + $(window).height();

        if (windowBottom > aboutHeroTop + 100) {
            animateCounter();
            $(window).off('scroll'); // Remove scroll listener after animation
        }
    });
</script>
@endpush
@endsection
