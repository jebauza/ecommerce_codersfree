<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Error favicon.ico --}}
        <link rel="shortcut icon" href="#">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/appSass.css') }}">

        {{-- Glider --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.css">
        <style>
            .glider {
                scrollbar-width: none; // firefox
            }

            .glider::-webkit-scrollbar {
                display: none; // webkit
            }
        </style>

        {{-- FlexSlider --}}
        <link rel="stylesheet" href="{{ asset('vendor/FlexSlider/flexslider.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        {{-- Glider --}}
        <script src="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.js" defer></script>

        {{-- Jquery --}}
        <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

        {{-- FlexSlider --}}
        <script src="{{ asset('vendor/FlexSlider/jquery.flexslider-min.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        <script>
            function dropdown() {
                return {
                    open: false,
                    openChangeTime: new Date(),
                    show() {
                        if (!this.open) {
                            this.open = true;
                            document.getElementsByTagName('html')[0].style.overflow = 'hidden';
                        } else {
                            this.open = false;
                            document.getElementsByTagName('html')[0].style.overflow = 'auto';
                        }

                        this.openChangeTime = Date.now();
                    },
                    close() {
                        if (Math.abs(Date.now() - this.openChangeTime) > 10) {
                            this.open = false;
                            document.getElementsByTagName('html')[0].style.overflow = 'auto';
                            this.openChangeTime = Date.now();
                        }
                    }
                }
            }
        </script>

        @stack('script')
    </body>
</html>
