# مستندات ماژول مدیریت کاربران

## مشخصات کلی
- **نام ماژول:** User Management Module
- **نسخه:** 1.0.0
- **زبان برنامه‌نویسی:** PHP 8.x
- **فریم‌ورک:** Laravel
- **هدف اصلی:** مدیریت کاربران، نقش‌ها، سطوح دسترسی و ثبت فعالیت‌ها

## پیش‌نیازها و وابستگی‌ها
- **پکیج‌های اصلی:**
  - `spatie/laravel-query-builder`: مدیریت فیلترها و مرتب‌سازی
  - `spatie/laravel-permission`: مدیریت نقش‌ها و مجوزها
  - `spatie/laravel-activitylog`: ثبت تغییرات
  - `hekmatinasser/verta`: مدیریت تاریخ شمسی

## ساختار پایگاه داده

### جدول pts_users
```sql
CREATE TABLE `pts_users` ( 
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NULL,
  `mobile` VARCHAR(255) NULL,
  `email_verified_at` TIMESTAMP NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `deleted_at` TIMESTAMP NULL,
   PRIMARY KEY (`id`),
  CONSTRAINT `pts_users_email_unique` UNIQUE (`email`),
  CONSTRAINT `pts_users_mobile_unique` UNIQUE (`mobile`)
)
```

### جدول pts_activities
ثبت فعالیت‌های کاربران مانند ورود و خروج
```sql
CREATE TABLE `pts_activities` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `type` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `properties` JSON NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  FOREIGN KEY (`user_id`) REFERENCES `pts_users` (`id`)
)
```

## ویژگی‌های اصلی

### 1. مدیریت کاربران
- ثبت نام با انعطاف‌پذیری:
  - ثبت نام با ایمیل (اختیاری)
  - ثبت نام با موبایل (اختیاری)
  - حداقل یکی از ایمیل یا موبایل الزامی است
- تأیید ایمیل (email verification)
- قابلیت "مرا به خاطر بسپار" (Remember Me)
- حذف نرم (Soft Delete)

### 2. سیستم ثبت تغییرات (Activity Log)
با استفاده از Spatie Activity Log، تغییرات در فیلدهای زیر ثبت می‌شود:
```php
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logFillable()        // ثبت تغییرات فیلدهای fillable
        ->logOnlyDirty()       // فقط فیلدهای تغییر یافته
        ->dontSubmitEmptyLogs(); // عدم ثبت لاگ خالی
}
```

### 3. ثبت فعالیت‌های کاربر
فعالیت‌های زیر در جدول `pts_activities` ثبت می‌شود:
- ورود به سیستم
- خروج از سیستم
- تغییر رمز عبور
- بروزرسانی پروفایل

## API‌ها و توابع اصلی

### GetList::handle()
لیست‌گیری از کاربران با قابلیت فیلتر و مرتب‌سازی

**فیلترهای موجود:**
```php
?filter[search]=keyword        // جستجو در نام، ایمیل و موبایل
?filter[from_date]=1402-01-01 // فیلتر از تاریخ (شمسی)
?filter[to_date]=1402-12-29   // فیلتر تا تاریخ (شمسی)
?filter[deleted]=1            // نمایش موارد حذف شده
```

**مرتب‌سازی:**
```php
?sort=name        // مرتب‌سازی بر اساس نام (صعودی)
?sort=-name       // مرتب‌سازی بر اساس نام (نزولی)
?sort=email       // مرتب‌سازی بر اساس ایمیل
?sort=created_at  // مرتب‌سازی بر اساس تاریخ ایجاد
```

### RoleAndPermissionLevelAccess
کلاس مدیریت سطوح دسترسی و نقش‌ها

#### CheckRoleInUpdate()
بررسی مجوز ویرایش کاربر
```php
public function CheckRoleInUpdate(User $currentUser, User $targetUser): bool
```
**قوانین دسترسی:**
- Super-admin: دسترسی به همه چیز
- Admin: عدم دسترسی به super-admin
- User: فقط دسترسی به سطح خود

**دسترسی های ایجاد شده برای کاربران:**
- show users: نمایش لیست کاربران
- create users: ایجاد کاربر  
- update users: ویرایش کاربر
- delete users: حذف کاربر
- update users roles: ویرایش نقش کاربران 

#### getRolesByAccessLevel()
دریافت لیست نقش‌های مجاز برای کاربر
```php
public function getRolesByAccessLevel(User $currentUser)
```

## نمونه استفاده

### دریافت لیست کاربران با فیلتر
```php
// جستجوی کاربران با نام "علی" که در تاریخ خاصی ثبت نام کرده‌اند
GET /api/users?filter[search]=علی&filter[from_date]=1402-01-01&sort=-created_at
```

### بررسی مجوز ویرایش
```php
$roleAccess = new RoleAndPermissionLevelAccess();
if ($roleAccess->CheckRoleInUpdate($currentUser, $targetUser)) {
    // اجازه ویرایش دارد
}
```


### ثبت فعالیت کاربر
```php
// نمونه ثبت فعالیت ورود
Activity::create([
    'user_id' => $user->id,
    'type' => 'login',
    'description' => 'User logged in',
    'properties' => [
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent()
    ]
]);
```

## نمونه‌های استفاده

### ثبت نام کاربر
```php
// ثبت نام با ایمیل
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => Hash::make('password')
]);

// ثبت نام با موبایل
$user = User::create([
    'name' => 'Jane Doe',
    'mobile' => '09123456789',
    'password' => Hash::make('password')
]);
```

### بررسی فعالیت‌های کاربر
```php
// دریافت آخرین فعالیت‌های کاربر
$activities = Activity::where('user_id', $userId)
    ->latest()
    ->take(10)
    ->get();

// دریافت تاریخچه تغییرات
$changes = $user->activities()
    ->where('type', 'updated')
    ->get();
```

## مدیریت خطاها
- **403 Forbidden:** عدم دسترسی به عملیات
- **404 Not Found:** کاربر یافت نشد
- **422 Unprocessable Entity:** خطا در اعتبارسنجی داده‌ها
- **409 Conflict:** تکراری بودن ایمیل یا موبایل

## قوانین اعتبارسنجی
```php
$rules = [
    'name' => 'required|string|max:255',
    'email' => 'nullable|email|unique:pts_users,email',
    'mobile' => 'nullable|regex:/^09\d{9}$/|unique:pts_users,mobile',
    'password' => 'required|min:8',
];
```

## نکات امنیتی
1. رمزهای عبور با استفاده از Hash ذخیره می‌شوند
2. توکن Remember Me با هر بار ورود مجدد تغییر می‌کند
3. ثبت IP و User Agent در لاگ‌های فعالیت
4. محافظت در برابر حملات Brute Force
5. استفاده از CSRF Token در فرم‌ها

## گزارش‌گیری
امکان گزارش‌گیری از:
1. تعداد کاربران فعال
2. آمار ورود و خروج
3. تغییرات انجام شده
4. فعالیت‌های مشکوک

## توسعه‌های آینده
1. افزودن احراز هویت دو مرحله‌ای
2. یکپارچه‌سازی با سرویس‌های پیامک
3. بهبود سیستم گزارش‌گیری
4. افزودن سیستم هشدار برای فعالیت‌های مشکوک

## راهنمای توسعه‌دهندگان
1. همیشه از `Activity::create()` برای ثبت فعالیت‌های مهم استفاده کنید
2. تغییرات حساس را در `properties` لاگ ثبت کنید
3. از Soft Delete برای حذف کاربران استفاده کنید
4. قبل از بروزرسانی اطلاعات حساس، سطح دسترسی را بررسی کنید
