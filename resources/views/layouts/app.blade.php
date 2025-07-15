<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0, minimal-ui"">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

         <!-- [Favicon] icon -->
         <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon"> <!-- [Google Font] Family -->
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
        <!-- data tables css -->
        <link rel="stylesheet" href="{{ asset('css/plugins/dataTables.bootstrap5.min.css') }}">
        @stack('styles')
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
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h2 class="mb-0">@yield('judul')</h2>
                                    </div>
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
        </div>

        <!-- [Page Specific JS] start -->
        <script src="{{ asset('js/plugins/apexcharts.min.js') }}"></script>
        <script src="{{ asset('js/pages/dashboard-default.js') }}"></script>
        <!-- [Page Specific JS] end -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/plugins/dataTables.bootstrap5.min.js') }}"></script>
        <!-- Required Js -->
        <script src="{{ asset('js/plugins/popper.min.js') }}"></script>
        <script src="{{ asset('js/plugins/simplebar.min.js') }}"></script>
        <script src="{{ asset('js/plugins/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/fonts/custom-font.js') }}"></script>
        <script src="{{ asset('js/pcoded.js') }}"></script>
        <script src="{{ asset('js/plugins/feather.min.js') }}"></script>
        <script>
            var table = $('#dom-jqry').DataTable();
        </script>
        <script> layout_change('light'); </script>
        <script>change_box_container('false');</script>
        <script>layout_rtl_change('false');</script>
        <script>preset_change("preset-1");</script>
        <script>font_change("Public-Sans");</script>
        @stack('scripts')
    </body>
</html>
