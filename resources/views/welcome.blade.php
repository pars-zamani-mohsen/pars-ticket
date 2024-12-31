<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('general.pars_support_system') }}</title>
    <script src="{{ asset('es/tailwindcss.3.4.16.es') }}"></script>
</head>
<body class="bg-gray-100 font-sans">
<!-- Header -->
<header class="bg-gradient-to-r from-blue-500 to-blue-700 text-white py-3 sm:py-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center px-4">
        <div class="flex items-center space-x-2 sm:space-x-4">
            <img src="{{ asset('images/logo.png') }}" alt="لوگو" class="w-8 h-8 sm:w-12 sm:h-12">
            <h1 class="text-lg sm:text-2xl font-bold">{{ __('general.pars_support_system') }}</h1>
        </div>
        <div>
            <a href="/login" class="text-xs sm:text-sm bg-white text-blue-600 py-1.5 sm:py-2 px-3 sm:px-4 rounded shadow hover:bg-gray-200 transition">{{ __('general.login') }}</a>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section class="bg-white py-8 sm:py-16">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <div class="w-full md:w-1/2 text-center md:text-right">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800">به سامانه پشتیبانی مشتریان خوش آمدید</h2>
                <p class="text-gray-600 mt-4 text-sm sm:text-base">سیستمی برای مدیریت و پیگیری درخواست‌ها و تعامل بهتر با تیم پشتیبانی.</p>
                <div class="mt-6 flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="/tickets/create" class="text-white bg-blue-600 py-2 sm:py-3 px-4 sm:px-6 rounded shadow hover:bg-blue-700 transition text-sm sm:text-base w-full sm:w-auto text-center">ایجاد تیکت جدید</a>
                    <a href="/tickets" class="text-blue-600 border border-blue-600 py-2 sm:py-3 px-4 sm:px-6 rounded shadow hover:bg-blue-50 transition text-sm sm:text-base w-full sm:w-auto text-center">مشاهده تیکت‌های شما</a>
                </div>
            </div>
            <div class="w-full md:w-1/2">
                <img src="{{ asset('images/pic1.png') }}" alt="تصویر سامانه" class="w-full rounded-lg shadow-md">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="bg-gray-50 py-8 sm:py-12">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h3 class="text-2xl sm:text-3xl font-bold text-gray-800">امکانات سامانه</h3>
            <p class="text-gray-600 mt-2 text-sm sm:text-base">با استفاده از سامانه پشتیبانی مشتریان، درخواست‌های خود را به راحتی مدیریت کنید.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mt-8">
            <div class="bg-white p-4 sm:p-6 rounded shadow-md">
                <h4 class="text-lg sm:text-xl font-bold text-blue-600">ایجاد تیکت</h4>
                <p class="text-gray-600 mt-2 text-sm sm:text-base">درخواست‌های خود را ثبت کنید و در اسرع وقت پاسخ دریافت کنید.</p>
            </div>
            <div class="bg-white p-4 sm:p-6 rounded shadow-md">
                <h4 class="text-lg sm:text-xl font-bold text-blue-600">پیگیری تیکت‌ها</h4>
                <p class="text-gray-600 mt-2 text-sm sm:text-base">وضعیت درخواست‌های خود را به صورت آنلاین مشاهده کنید.</p>
            </div>
            <div class="bg-white p-4 sm:p-6 rounded shadow-md">
                <h4 class="text-lg sm:text-xl font-bold text-blue-600">پشتیبانی سریع</h4>
                <p class="text-gray-600 mt-2 text-sm sm:text-base">از تیم حرفه‌ای ما کمک بگیرید و مشکلات خود را برطرف کنید.</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-4 sm:py-6 mt-8 sm:mt-12">
    <div class="text-center text-xs sm:text-sm">&copy; 1403 سامانه پشتیبانی مشتریان. کلیه حقوق محفوظ است.</div>
</footer>
</body>
</html>
