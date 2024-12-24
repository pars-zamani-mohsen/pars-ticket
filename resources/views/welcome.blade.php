<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سامانه پشتیبانی پارس</title>
    <script src="{{ asset('es/tailwindcss.3.4.16.es') }}"></script>
</head>
<body class="bg-gray-100 font-sans">
<!-- Header -->
<header class="bg-gradient-to-r from-blue-500 to-blue-700 text-white py-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center px-4">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/logo.png') }}" alt="لوگو" class="w-12 h-12">
            <h1 class="text-2xl font-bold">سامانه پشتیبانی پارس</h1>
        </div>
        <div>
            <a href="/login" class="text-sm bg-white text-blue-600 py-2 px-4 rounded shadow hover:bg-gray-200">ورود</a>
            <a href="/register" class="ml-2 text-sm bg-white text-blue-600 py-2 px-4 rounded shadow hover:bg-gray-200">ثبت‌نام</a>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section class="bg-white py-16">
    <div class="container mx-auto flex flex-col md:flex-row items-center px-4">
        <div class="md:w-1/2 text-center md:text-right">
            <h2 class="text-4xl font-bold text-gray-800">به سامانه پشتیبانی پارس خوش آمدید</h2>
            <p class="text-gray-600 mt-4">سیستمی برای مدیریت و پیگیری درخواست‌ها و تعامل بهتر با تیم پشتیبانی.</p>
            <div class="mt-6">
                <a href="/tickets/create" class="text-white bg-blue-600 py-3 px-6 rounded shadow hover:bg-blue-700">ایجاد تیکت جدید</a>
                <a href="/tickets" class="ml-4 text-blue-600 border border-blue-600 py-3 px-6 rounded shadow hover:bg-blue-50">مشاهده تیکت‌های شما</a>
            </div>
        </div>
        <div class="md:w-1/2 mt-8 md:mt-0">
            <img src="{{ asset('images/pic1.png') }}" alt="تصویر سامانه" class="w-full rounded-lg shadow-md">
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto text-center px-4">
        <h3 class="text-3xl font-bold text-gray-800">امکانات سامانه</h3>
        <p class="text-gray-600 mt-2">با استفاده از سامانه پشتیبانی پارس، درخواست‌های خود را به راحتی مدیریت کنید.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-white p-6 rounded shadow-md">
                <h4 class="text-xl font-bold text-blue-600">ایجاد تیکت</h4>
                <p class="text-gray-600 mt-2">درخواست‌های خود را ثبت کنید و در اسرع وقت پاسخ دریافت کنید.</p>
            </div>
            <div class="bg-white p-6 rounded shadow-md">
                <h4 class="text-xl font-bold text-blue-600">پیگیری تیکت‌ها</h4>
                <p class="text-gray-600 mt-2">وضعیت درخواست‌های خود را به صورت آنلاین مشاهده کنید.</p>
            </div>
            <div class="bg-white p-6 rounded shadow-md">
                <h4 class="text-xl font-bold text-blue-600">پشتیبانی سریع</h4>
                <p class="text-gray-600 mt-2">از تیم حرفه‌ای ما کمک بگیرید و مشکلات خود را برطرف کنید.</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-6 mt-12">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-4 px-4">
        <div class="text-center md:text-right">
            <h5 class="font-bold">تماس با ما</h5>
            <p class="mt-2">تلفن: <a href="tel:+98123456789" class="text-blue-400 hover:underline">+98 123 456 789</a></p>
            <p>ایمیل: <a href="mailto:support@pars.com" class="text-blue-400 hover:underline">support@pars.com</a></p>
        </div>
        <div class="text-center md:text-left">
            <h5 class="font-bold">درباره سامانه</h5>
            <p class="mt-2 text-sm">سامانه پشتیبانی پارس جهت ارائه خدمات بهتر به مشتریان طراحی شده است.</p>
        </div>
    </div>
    <div class="text-center text-sm mt-4">&copy; 1403 سامانه پشتیبانی پارس. کلیه حقوق محفوظ است.</div>
</footer>
</body>
</html>
