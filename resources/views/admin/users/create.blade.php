<x-app-layout>
    <!-- اضافه کردن CDN های مورد نیاز -->
    @push('styles')
        <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/select2.custom.css') }}" rel="stylesheet" />
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($user) ? __('user.edit_user') : __('user.create_new_user') }}
        </h2>
    </x-slot>
    <x-slot name="title">
        {{ isset($user) ? __('user.edit_user') : __('user.create_new_user') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}"
                          method="POST">
                        @csrf
                        @if(isset($user))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- نام -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    {{ __('user.name') }}
                                </label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       value="{{ old('name', $user->name ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white"
                                       required>
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- ایمیل -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    {{ __('user.email') }}
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
                                    {{ __('user.mobile') }}
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
                                    {{ __('user.password') }} {{ isset($user) ? __('user.if_change') : '' }}
                                </label>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white"
                                    {{ isset($user) ? '' : 'required' }}>
                                @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- تکرار رمز عبور -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                    {{ __('user.confirm_password') }}
                                </label>
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white"
                                    {{ isset($user) ? '' : 'required' }}>
                            </div>

                            <!-- نقش‌ها -->
                            @can('update users roles')
                                <div class="">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="roles">
                                        {{ __('role.roles') }}
                                    </label>
                                    <select name="roles[]"
                                            id="roles"
                                            class="select2 mt-1 block w-full"
                                            multiple>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}"
                                                    @if(isset($user) && $user->hasRole($role->name)) selected @endif>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endcan

                            <div class="">
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="categories">
                                    {{ __('user.categories') }}
                                </label>
                                <select name="categories[]"
                                        id="categories"
                                        class="select2 mt-1 block w-full"
                                        multiple>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                @if(isset($user) && in_array($category->id, $user->categories->pluck('id')->toArray())) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- دکمه‌ها -->
                        <div class="mt-6">
                            <button type="submit"
                                    class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                {{ __('general.submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/jquery-3.6.0.min.js.js') }}"></script>
        <script src="{{ asset('js/select2.min.js.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    dir: "rtl",
                    language: "fa",
                    placeholder: "انتخاب کنید",
                    allowClear: true,
                    closeOnSelect: false,
                });
            });
        </script>
    @endpush
</x-app-layout>
