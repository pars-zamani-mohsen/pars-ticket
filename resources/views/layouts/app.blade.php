<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ \App\Helpers\PageTitleHelper::title($title ?? null) }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="{{ asset('css/css.css?family=figtree:400,500,600&display=swap') }}" rel="stylesheet" />
        <link href="{{ asset('css/Vazirmatn-font-face.css') }}" rel="stylesheet" type="text/css" />
        @stack('styles')
        <script src="{{ asset('es/tailwindcss.3.4.16.es') }}"></script>
        <script defer src="{{ asset('js/cdn.min.js.js') }}"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" dir="rtl">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <div class="container mx-auto px-4 mt-4">
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

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @stack('scripts')
    </body>
</html>
