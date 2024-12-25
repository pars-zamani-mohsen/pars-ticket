<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('داشبورد') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- آمار کلی -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                @can('show permissions')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-gray-500 text-sm">کل کاربران</div>
                            <div class="text-3xl font-bold text-gray-800">{{ $usersCount }}</div>
                        </div>
                    </div>
                @endcan

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">کل تیکت ها</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $ticketsCount }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm"> تیکت های باز</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $openTicketsCount }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <!-- اطلاعات کاربر -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">اطلاعات کاربری</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-xl font-bold text-gray-600">
                                        <img src="{{ asset('images/user.png') }}" alt="{{ auth()->user()->name }}">
                                    </span>
                                </div>
                                <div class="mr-4">
                                    <div class="font-semibold text-gray-800">{{ auth()->user()->name }}</div>
                                    <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                                </div>
                            </div>

                            @if(auth()->user()->roles->isNotEmpty())
                                <div class="border-t pt-4">
                                    <div class="text-sm text-gray-600 mb-2">نقش‌های شما:</div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(auth()->user()->roles as $role)
                                            <span class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">
                                            {{ $role->name }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if(auth()->user()->getAllPermissions()->isNotEmpty())
                                <div class="border-t pt-4">
                                    <div class="text-sm text-gray-600 mb-2">دسترسی‌های شما:</div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(auth()->user()->getAllPermissions() as $permission)
                                            <span class="px-3 py-1 text-sm bg-green-100 text-green-800 rounded-full">
                                            {{ $permission->name }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <!-- دسترسی سریع -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">دسترسی سریع</h3>
                        <div class="grid grid-cols-2 gap-4">
                            @can('show users')
                                <a href="{{ route('admin.users.index') }}"
                                   class="p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="text-lg font-semibold text-gray-800">مدیریت کاربران</div>
                                    <div class="text-sm text-gray-500">مشاهده و مدیریت کاربران سیستم</div>
                                </a>
                            @endcan

                            @can('show roles')
                                <a href="{{ route('admin.roles.index') }}"
                                   class="p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="text-lg font-semibold text-gray-800">مدیریت نقش‌ها</div>
                                    <div class="text-sm text-gray-500">تعریف و مدیریت نقش‌های کاربری</div>
                                </a>
                            @endcan

                            @can('show permissions')
                                <a href="{{ route('admin.permissions.index') }}"
                                   class="p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="text-lg font-semibold text-gray-800">مدیریت دسترسی‌ها</div>
                                    <div class="text-sm text-gray-500">تعریف و مدیریت سطوح دسترسی</div>
                                </a>
                            @endcan

                                <a href="{{ route('tickets.index') }}"
                                   class="p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="text-lg font-semibold text-gray-800">تیکت ها</div>
                                    <div class="text-sm text-gray-500">مدیریت تیکت ها</div>
                                </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- آخرین فعالیت‌ها -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">آخرین فعالیت‌ها</h3>
                    <div class="space-y-4">
                        @foreach($activities as $activity)
                            <div class="flex items-center justify-between border-b pb-4">
                                <div>
                                    <div class="text-sm font-semibold text-gray-800">{{ $activity->description }}</div>
                                    <div class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
