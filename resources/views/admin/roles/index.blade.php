<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('مدیریت نقش‌ها') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- جستجو -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">جستجو</label>
                                <input type="text"
                                       name="filter[name]"
                                       value="{{ request('filter.name') }}"
                                       placeholder="جستجو در نام دسترسی..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <!-- توضیحات -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">توضیحات</label>
                                <input type="text"
                                       name="filter[description]"
                                       value="{{ request('filter.description') }}"
                                       placeholder="جستجو در توضیحات..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2 space-x-reverse">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                    اعمال فیلتر
                                </button>
                                <a href="{{ route('admin.roles.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                                    پاک کردن
                                </a>
                            </div>

                            @can('create roles')
                            <a href="{{ route('admin.roles.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                ایجاد نقش جدید
                            </a>
                            @endcan
                        </div>

                    </form>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
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
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                دسترسی‌ها
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->get('sort') === 'created_at' ? '-created_at' : 'created_at']) }}"
                                   class="flex items-center justify-start hover:text-gray-900">
                                    <span>تاریخ ایجاد</span>
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
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                عملیات
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($roles as $role)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                                    {{ $role->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm leading-5 text-gray-500">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($role->permissions as $permission)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{ verta($role->created_at)->format('Y/m/d H:i') }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium">
                                    @can('edit roles')
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="text-indigo-600 hover:text-indigo-900 ml-4">ویرایش</a>
                                    @endcan

                                    @can('delete roles')
                                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('آیا مطمئن هستید؟')">
                                                حذف
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
