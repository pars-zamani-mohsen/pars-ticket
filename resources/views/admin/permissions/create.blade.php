<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($permission) ? __('permission.update_permission') : __('permission.create_new_permission') }}
        </h2>
    </x-slot>
    <x-slot name="title">
        {{ isset($permission) ? __('permission.update_permission') : __('permission.create_new_permission') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST"
                          action="{{ isset($permission) ? route('admin.permissions.update', $permission) : route('admin.permissions.store') }}">
                        @csrf
                        @if(isset($permission))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                نام دسترسی
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   value="{{ old('name', $permission->name ?? '') }}"
                                   required>
                            @error('name')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                                توضیحات
                            </label>
                            <textarea name="description"
                                      id="description"
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                      rows="3">{{ old('description', $permission->description ?? '') }}</textarea>
                            @error('description')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                {{ isset($permission) ? 'ویرایش' : 'ایجاد' }}
                            </button>

                            <a href="{{ route('admin.permissions.index') }}"
                               class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                انصراف
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
