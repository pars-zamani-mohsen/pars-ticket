<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('مدیریت کاربران') }}
        </h2>
    </x-slot>

    {{-- Include jQuery First --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Persian Date Requirements --}}
    <script src="{{ asset('js/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/persian-datepicker.min.css') }}">

    <div x-data="usersIndex" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form @submit.prevent="applyFilters" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- جستجو -->
                            <div class="md:col-span-1">
                                <label for="search" class="block text-sm font-medium text-gray-700">جستجو</label>
                                <input type="text"
                                       id="search"
                                       x-model="filters.search"
                                       class="mt-1 block w-full rounded-md border-gray-300"
                                       placeholder="جستجو در نام، ایمیل یا موبایل...">
                            </div>

                            <!-- تاریخ از -->
                            <div>
                                <label for="from_date" class="block text-sm font-medium text-gray-700">از تاریخ</label>
                                <input type="text"
                                       id="from_date"
                                       x-model="filters.from_date"
                                       class="pdate mt-1 block w-full rounded-md border-gray-300"
                                       readonly>
                            </div>

                            <!-- تاریخ تا -->
                            <div>
                                <label for="to_date" class="block text-sm font-medium text-gray-700">تا تاریخ</label>
                                <input type="text"
                                       id="to_date"
                                       x-model="filters.to_date"
                                       class="pdate mt-1 block w-full rounded-md border-gray-300"
                                       readonly>
                            </div>
                        </div>

                        <!-- دکمه‌های اکشن -->
                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2 space-x-reverse">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                    اعمال فیلتر
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                                    پاک کردن
                                </a>
                            </div>

                            @can('create users')
                                <a href="{{ route('admin.users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                    کاربر جدید
                                </a>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- جدول -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->get('sort') === 'name' ? '-name' : 'name']) }}"
                                   class="flex items-center justify-start hover:text-gray-900">
                                    <span>نام</span>
                                    @if(request()->get('sort') === 'name')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    @elseif(request()->get('sort') === '-name')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->get('sort') === 'email' ? '-email' : 'email']) }}"
                                   class="flex items-center justify-start hover:text-gray-900">
                                    <span>ایمیل</span>
                                    @if(request()->get('sort') === 'email')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    @elseif(request()->get('sort') === '-email')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->get('sort') === 'mobile' ? '-mobile' : 'mobile']) }}"
                                   class="flex items-center justify-start hover:text-gray-900">
                                    <span>موبایل</span>
                                    @if(request()->get('sort') === 'mobile')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    @elseif(request()->get('sort') === '-mobile')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                نقش ها
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->get('sort') === 'created_at' ? '-created_at' : 'created_at']) }}"
                                   class="flex items-center justify-start hover:text-gray-900">
                                    <span>تاریخ ثبت‌نام</span>
                                    @if(request()->get('sort') === 'created_at')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    @elseif(request()->get('sort') === '-created_at')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                عملیات
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->mobile }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $role->name }}
                                            </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ verta($user->created_at)->format('Y/m/d H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @can('create tickets for-user')
                                        <a href="{{ route('tickets.create', ['user_id' => $user->id]) }}" class="text-indigo-600 hover:text-indigo-900 ml-3">ایجاد تیکت</a>
                                    @endcan
                                    @can('update tickets')
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 ml-3">ویرایش</a>
                                    @endcan
                                    @can('delete users')
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('آیا از حذف این کاربر اطمینان دارید؟')">
                                                حذف
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    هیچ کاربری یافت نشد!
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- پاگینیشن -->
                    <div class="mt-4">
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('usersIndex', () => ({
                    filters: {
                        search: @json(request('filter.search', '')),
                    from_date: @json(request('filter.from_date', '')),
                    to_date: @json(request('filter.to_date', ''))
            },

            init() {
                // اطمینان از لود شدن کامل صفحه
                this.$nextTick(() => {
                    // تنظیمات تقویم شمسی
                    $('.pdate').persianDatepicker({
                        format: 'YYYY/MM/DD',
                        autoClose: true,
                        initialValue: false,
                        observer: true,
                        onSelect: (unix) => {
                            // به‌روزرسانی مقدار در Alpine
                            const inputId = $(this).attr('id');
                            this.filters[inputId] = unix;
                        }
                    });
                });
            },

            applyFilters() {
                let params = new URLSearchParams(window.location.search);

                // اعمال فیلترها
                Object.entries(this.filters).forEach(([key, value]) => {
                    if (value) {
                        params.set(`filter[${key}]`, value);
                    } else {
                        params.delete(`filter[${key}]`);
                    }
                });

                // حفظ پارامتر مرتب‌سازی
                if (params.has('sort')) {
                    params.set('sort', params.get('sort'));
                }

                // ریدایرکت با پارامترهای جدید
                window.location.search = params.toString();
            },
        }));
    });
        </script>
    @endpush

    @push('styles')
        <style>
            /* RTL Fixes */
            body {
                direction: rtl;
            }

            .space-x-reverse > :not([hidden]) ~ :not([hidden]) {
                --tw-space-x-reverse: 1;
            }

            /* Persian DatePicker Fixes */
            .datepicker-plot-area {
                font-family: inherit;
            }
        </style>
    @endpush
</x-app-layout>
