@php
    use Illuminate\Support\Facades\Auth;
    $keranjang = 0; // Default value
    if (Auth::check() && Auth::user()->role == 'pelanggan') {
        $keranjang = App\Models\Keranjang::where('user_id', Auth::user()->id)->count();
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Dame ulos">
    <meta name="keywords" content="dameulos, ulos, batak, fashion">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
    rel="stylesheet">
    <script src="https://kit.fontawesome.com/c3621d3bda.js" crossorigin="anonymous"></script>

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('home/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/style.css') }}" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 180px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1000;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            margin-top: 5px;
        }
        .dropdown.show .dropdown-menu {
            display: block;
        }
        .dropdown-item {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #ca1515;
            text-decoration: none;
        }
        .dropdown-item i {
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }
        .dropdown-divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 8px 0;
        }
        .header__nav__option a {
            margin-right: 15px;
            color: #333;
            font-size: 16px;
            text-decoration: none;
        }
        .header__nav__option a:hover {
            color: #ca1515;
        }
        .dropdown-toggle:after {
            display: none;
        }
        .dropdown-toggle {
            border: none;
            background: none;
            cursor: pointer;
        }
        .dropdown-toggle:focus {
            outline: none;
        }

        /* Mobile Menu Styles */
        .mobile-menu-item {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .mobile-menu-item:hover {
            background-color: #f8f9fa;
            color: #ca1515;
            text-decoration: none;
        }
        .mobile-menu-item i {
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__links">
                <!-- Link tambahan bisa ditambahkan di sini -->
            </div>
        </div>
        <div class="offcanvas__nav__option">
            <a href="#" class="search-switch"><img src="{{ asset('home/img/icon/search.png') }}" alt=""></a>
            <a href="#"><img src="{{ asset('home/img/icon/heart.png') }}" alt=""></a>
            <a href="{{ route('pelanggan.keranjang.index') }}"><img src="{{ asset('home/img/icon/cart.png') }}" alt=""> <span>{{ $keranjang }}</span></a>
            <div class="price">$0.00</div>
        </div>

        <!-- Mobile Menu User Options -->
        @if(Auth::check())
            <div class="mobile-user-menu" style="border-top: 1px solid #eee; margin-top: 15px; padding-top: 15px;">
                <div style="padding: 0 15px 10px; font-weight: bold; color: #333;">
                    <i class="fa fa-user"></i> {{ Auth::user()->name }}
                </div>
                @if(Auth::user()->role == 'pelanggan')
                    <a href="{{ route('pelanggan.transaksi') }}" class="mobile-menu-item">
                        <i class="fa fa-file-text-o"></i> Transaksi Saya
                    </a>
                @endif
                <a href="{{ route('profile.edit') }}" class="mobile-menu-item">
                    <i class="fa fa-user-circle-o"></i> Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="mobile-menu-item">
                        <i class="fa fa-sign-out"></i> Logout
                    </button>
                </form>
            </div>
        @else
            <div class="mobile-user-menu" style="border-top: 1px solid #eee; margin-top: 15px; padding-top: 15px;">
                <a href="{{ route('login') }}" class="mobile-menu-item">
                    <i class="fa fa-sign-in"></i> Login
                </a>
                <a href="{{ route('register') }}" class="mobile-menu-item">
                    <i class="fa fa-user-plus"></i> Daftar
                </a>
            </div>
        @endif

        <div id="mobile-menu-wrap"></div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="header__logo">
                        <a href="/"><img src="{{ asset('images/logo-dameulos.png') }}" alt="logo dameulos" class="w-25"></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="{{ Route::currentRouteName() == 'pelanggan.home' ? 'active' : '' }}"><a href="/">Home</a></li>
                            <li class="{{ Route::currentRouteName() == 'pelanggan.katalog' ? 'active' : '' }}"><a href="{{ route('pelanggan.katalog') }}">Katalog</a></li>
                            <li><a href="./about.html">Tentang Kami</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <a href="{{ route('pelanggan.keranjang.index') }}"><img src="{{ asset('home/img/icon/cart.png') }}" alt=""><span>{{ $keranjang }}</span></a>
                        @if(Auth::check())
                            <div class="dropdown" style="display: inline-block;">
                                <a href="#" class="dropdown-toggle" id="userDropdown" style="text-decoration: none;">
                                    <i class="fa fa-user"></i> {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu" id="userDropdownMenu">
                                    @if(Auth::user()->role == 'pelanggan')
                                        <a class="dropdown-item" href="{{ route('pelanggan.transaksi') }}">
                                            <i class="fa fa-file-text-o"></i> Transaksi Saya
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fa fa-user-circle-o"></i> Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fa fa-sign-out"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" style="margin-left: 10px;">Login</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->

    @yield('content')

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="/"><img src="{{ asset('images/logo-dameulos.png') }}" class="w-50" alt="logo dameulos"></a>
                        </div>
                        <p>The customer is at the heart of our unique business model, which includes design.</p>
                        <a href="#"><img src="{{ asset('home/img/payment.png') }}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="#">Clothing Store</a></li>
                            <li><a href="#">Trending Shoes</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Sale</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Payment Methods</a></li>
                            <li><a href="#">Delivary</a></li>
                            <li><a href="#">Return & Exchanges</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>NewLetter</h6>
                        <div class="footer__newslatter">
                            <p>Be the first to know about new arrivals, look books, sales & promos!</p>
                            <form action="#">
                                <input type="text" placeholder="Your email">
                                <button type="submit"><span class="icon_mail_alt"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="footer__copyright__text">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <p>Copyright ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            All rights reserved | Galeri Dame Ulos
                        </p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="{{ asset('home/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('home/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('home/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('home/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('home/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('home/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('home/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('home/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('home/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.js-example-basic-single').select2();

            // Dropdown click functionality
            $('#userDropdown').click(function(e) {
                e.preventDefault();
                $(this).parent('.dropdown').toggleClass('show');
            });

            // Close dropdown when clicking outside
            $(document).click(function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown').removeClass('show');
                }
            });

            // Prevent dropdown from closing when clicking inside
            $('.dropdown-menu').click(function(e) {
                e.stopPropagation();
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
