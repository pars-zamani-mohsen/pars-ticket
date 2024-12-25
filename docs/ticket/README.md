# مستندات ماژول تیکت

## مشخصات کلی
- **نام ماژول:** Ticket Module
- **نسخه:** 1.0.0
- **تاریخ آخرین بروزرسانی:** 25 دسامبر 2024
- **نویسنده:** محسن زمانی
- **هدف اصلی:** مدیریت تیکت‌های کاربران و پاسخگویی توسط اپراتور

## پیش‌نیازها و وابستگی‌ها

### پکیج‌های اصلی
```json
{
    "coderflex/laravel-ticket": "^2.0",
    "spatie/laravel-medialibrary": "^11.11",
    "spatie/laravel-activitylog": "^4.9",
    "spatie/laravel-permission": "^6.10",
    "spatie/laravel-query-builder": "^6.2",
    "stevebauman/purify": "^6.2",
    "predis/predis": "^2.0",
    "hekmatinasser/verta": "^8.4"
}
```

### ارتباطات با سایر ماژول‌ها
- **Categories:** ارتباط چند به چند (Many-to-Many)
- **Labels:** ارتباط چند به چند (Many-to-Many)
- **Messages:** ارتباط یک به چند (One-to-Many)
- **Users:** ارتباط یک به چند (One-to-Many)

## سیستم مجوزها و دسترسی‌ها

### مجوزهای پایه
1. **نمایش تیکت‌ها**
    - `show tickets`: مشاهده تیکت‌های خود
    - `show tickets all`: مشاهده تمام تیکت‌ها
    - `show tickets all-in-category`: مشاهده تیکت‌ها بر اساس دسته‌بندی

2. **مدیریت تیکت‌ها**
    - `create tickets`: ایجاد تیکت
    - `create tickets for-user`: ایجاد تیکت برای کاربر دیگر
    - `update tickets`: ویرایش تیکت
    - `delete tickets`: حذف تیکت

3. **مدیریت محتوا**
    - `update tickets category`: تغییر دسته‌بندی تیکت
    - `delete tickets files`: حذف فایل‌های پیوست

## امنیت و کنترل دسترسی

### Policy‌ها
```php
class TicketPolicy
{
    public function view(User $user, Ticket $ticket)
    {
        return $user->hasPermissionTo('show tickets') && 
               ($ticket->user_id === $user->id || 
                $user->hasPermissionTo('show tickets all'));
    }

    public function update(User $user, Ticket $ticket)
    {
        return $user->hasPermissionTo('update tickets');
    }
    
    // سایر متدهای Policy
}
```

### پاکسازی داده‌ها
```php
use Stevebauman\Purify\Facades\Purify;

$cleanContent = Purify::clean($request->content);
```

## مدیریت فایل‌ها

### تنظیمات MediaLibrary
```php
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments')
             ->acceptsMimeTypes(['image/jpeg', 'image/png', 'application/pdf'])
             ->maxFilesize(5 * 1024 * 1024); // 5MB
    }
}
```

## کش‌کردن اطلاعات

### مدیریت کش Redis
```php
// کش کردن دسته‌بندی‌ها
Redis::set('categories', Cache::remember('categories', 3600, function () {
    return Category::all();
}));

// کش کردن برچسب‌ها
Redis::set('labels', Cache::remember('labels', 3600, function () {
    return Label::all();
}));
```

## نمونه استفاده

### ایجاد تیکت جدید
```php
$ticket = Ticket::create([
    'title' => $request->title,
    'content' => Purify::clean($request->content),
    'user_id' => auth()->id(),
    'status' => 'open'
]);

// افزودن دسته‌بندی
$ticket->categories()->attach($request->categories);

// افزودن فایل
if ($request->hasFile('attachment')) {
    $ticket->addMedia($request->file('attachment'))
           ->toMediaCollection('attachments');
}
```

### پاسخ به تیکت
```php
$message = $ticket->messages()->create([
    'content' => Purify::clean($request->content),
    'user_id' => auth()->id()
]);
```

## مدیریت خطاها
- **403:** عدم دسترسی به عملیات
- **404:** تیکت یافت نشد
- **413:** حجم فایل بیش از حد مجاز
- **422:** خطای اعتبارسنجی داده‌ها

## نکات مهم و محدودیت‌ها
1. حداکثر حجم فایل پیوست: 5MB
2. فرمت‌های مجاز: JPEG، PNG، PDF
3. کش دسته‌بندی‌ها و برچسب‌ها هر 1 ساعت بروزرسانی می‌شود
4. متن‌ها قبل از ذخیره پاکسازی می‌شوند

## توسعه‌های آینده پیشنهادی
1. افزودن سیستم اولویت‌بندی تیکت‌ها
2. پیاده‌سازی نوتیفیکیشن در زمان پاسخ
3. افزودن قابلیت ارجاع تیکت به کارشناس خاص
4. سیستم ارزیابی کیفیت پاسخگویی
5. گزارش‌گیری پیشرفته از عملکرد

## راهنمای توسعه‌دهندگان
1. همیشه از `Purify::clean()` برای پاکسازی محتوا استفاده کنید
2. قبل از هر عملیات، مجوزهای کاربر را بررسی کنید
3. برای عملیات‌های سنگین از jobs استفاده کنید
4. تغییرات مهم را در activity log ثبت کنید
