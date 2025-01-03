<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="{{ asset('css/css.css?family=figtree:400,500,600&display=swap') }}" rel="stylesheet" />
        <script src="{{ asset('es/tailwindcss.3.4.16.es') }}"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">

            <div class="container mx-auto px-4 mt-4" dir="rtl">
                @if(session()->has('success'))
                    <x-alert type="success" :message="session('success')" />
                @endif

                @if(session()->has('error'))
                    <x-alert type="error" :message="session('error')" />
                @endif

                @if(session()->has('warning'))
                    <x-alert type="warning" :message="session('warning')" />
                @endif

                @if(session()->has('info'))
                    <x-alert type="info" :message="session('info')" />
                @endif

                <!-- نمایش خطاهای validation -->
                @if($errors->any())
                    <div class="space-y-2">
                        @foreach($errors->all() as $error)
                            <x-alert type="error" :message="$error" />
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
