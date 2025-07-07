<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0, minimal-ui"">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

         <!-- [Favicon] icon -->
        <link rel="icon" href="{{ asset('images/favicon.svg') }}" type="image/x-icon"> <!-- [Google Font] Family -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
        <!-- [Tabler Icons] https://tablericons.com -->
        <link rel="stylesheet" href="{{ asset('fonts/tabler-icons.min.css') }}" >
        <!-- [Feather Icons] https://feathericons.com -->
        <link rel="stylesheet" href="{{ asset('fonts/feather.css') }}" >
        <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
        <link rel="stylesheet" href="{{ asset('fonts/fontawesome.css') }}" >
        <!-- [Material Icons] https://fonts.google.com/icons -->
        <link rel="stylesheet" href="{{ asset('fonts/material.css') }}" >
        <!-- [Template CSS Files] -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" id="main-style-link" >
        <link rel="stylesheet" href="{{ asset('css/style-preset.css') }}" >
    </head>
    <body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">

        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
        <!-- [ Pre-loader ] End -->

        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- [ Main Content ] start -->
            <div class="pc-container">
                <div class="pc-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">@yield('halaman')</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0)">@yield('halaman')</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                    <!-- [ Main Content ] start -->
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->

            <footer class="pc-footer">
                <div class="footer-wrapper container-fluid">
                    <div class="row">
                        <div class="col-sm my-1">
                            <p class="m-0">Mantis &#9829; crafted by Team <a
                                    href="https://themeforest.net/user/codedthemes" target="_blank">Codedthemes</a></p>
                        </div>
                        <div class="col-auto my-1">
                            <ul class="list-inline footer-link mb-0">
                                <li class="list-inline-item"><a href="../index.html">Home</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- [Page Specific JS] start -->
        <script src="{{ asset('js/plugins/apexcharts.min.js') }}"></script>
        <script src="{{ asset('js/pages/dashboard-default.js') }}"></script>
        <!-- [Page Specific JS] end -->
        <!-- Required Js -->
        <script src="{{ asset('js/plugins/popper.min.js') }}"></script>
        <script src="{{ asset('js/plugins/simplebar.min.js') }}"></script>
        <script src="{{ asset('js/plugins/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/fonts/custom-font.js') }}"></script>
        <script src="{{ asset('js/pcoded.js') }}"></script>
        <script src="{{ asset('js/plugins/feather.min.js') }}"></script>
        <script> layout_change('light'); </script>
        <script>change_box_container('false');</script>
        <script>layout_rtl_change('false');</script>
        <script>preset_change("preset-1");</script>
        <script>font_change("Public-Sans");</script>
    </body>
</html>
