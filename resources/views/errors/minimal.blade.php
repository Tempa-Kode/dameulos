<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js"></script>
        <style>
            .error-container {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background-color: #f8f9fa;
            }

            .error-content {
                text-align: center;
            }

            .error-content h1 {
                font-size: 6rem;
                font-weight: bold;
                margin-bottom: 1rem;
            }

            .error-content p {
                font-size: 1.5rem;
                margin-bottom: 2rem;
            }

            .lottie-animation {
                max-width: 400px;
                margin-bottom: 2rem;
            }
        </style>
    </head>
    {{-- <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
                    <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">
                        @yield('code')
                    </div>

                    <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                        @yield('message')
                    </div>
                </div>
            </div>
        </div>
    </body> --}}
    <body>
        <div class="error-container">
            <div class="lottie-animation"></div>
            <div class="error-content">
                <h1>@yield('code')</h1>
                <p>@yield('message')</p>
                <a href="{{ url()->previous() ?: url('/') }}" class="btn btn-secondary">&#11176; Kembali</a>
            </div>
        </div>
        <script type="text/javascript">
            const animation = lottie.loadAnimation({
                container: document.querySelector('.lottie-animation'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: 'https://lottie.host/d987597c-7676-4424-8817-7fca6dc1a33e/BVrFXsaeui.json'
            });
        </script>
    </body>
</html>
