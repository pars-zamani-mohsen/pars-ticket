<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($user) ? 'ویرایش کاربر' : 'ایجاد کاربر جدید' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}"
                          method="POST"
                          class="space-y-6">
                        @csrf
                        @if(isset($user))
                            @method('PUT')
                        @endif

                        <!-- نام -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                نام
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name', $user->name ?? '') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white "
                                   required>
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ایمیل -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                ایمیل
                            </label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email', $user->email ?? '') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white">
                            @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- موبایل -->
                        <div>
                            <label for="mobile" class="block text-sm font-medium text-gray-700">
                                موبایل
                            </label>
                            <input type="text"
                                   name="mobile"
                                   id="mobile"
                                   value="{{ old('mobile', $user->mobile ?? '') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white">
                            @error('mobile')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- رمز عبور -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                رمز عبور {{ isset($user) ? '(در صورت تغییر)' : '' }}
                            </label>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white "
                                {{ isset($user) ? '' : 'required' }}>
                            @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- تکرار رمز عبور -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                تکرار رمز عبور
                            </label>
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white "
                                {{ isset($user) ? '' : 'required' }}>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="roles">
                                نقش‌ها
                            </label>
                            <select name="roles[]"
                                    id="roles"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    multiple>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}"
                                            @if(isset($user) && $user->hasRole($role->name)) selected @endif>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- دکمه‌ها -->
                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                ثبت
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
