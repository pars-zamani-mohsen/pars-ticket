<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('مدیریت دسترسی‌ها') }}
            </h2>

            <a href="{{ route('admin.permissions.create') }}"
               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                ایجاد دسترسی جدید
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-right">نام دسترسی</th>
                            <th class="px-6 py-3 bg-gray-50 text-right">توضیحات</th>
                            <th class="px-6 py-3 bg-gray-50 text-right">نقش‌های مرتبط</th>
                            <th class="px-6 py-3 bg-gray-50 text-right">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($permissions as $permission)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $permission->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $permission->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($permission->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $role->name }}
                                                </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.permissions.edit', $permission) }}"
                                       class="text-indigo-600 hover:text-indigo-900 ml-4">
                                        ویرایش
                                    </a>

                                    <form action="{{ route('admin.permissions.destroy', $permission) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('آیا از حذف این دسترسی اطمینان دارید؟')">
                                            حذف
                                        </button>
                                    </form>
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
