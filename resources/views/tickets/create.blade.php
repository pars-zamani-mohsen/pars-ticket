<x-app-layout>
    <div class="py-12" dir="rtl">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- نمایش پیام خطای کلی -->
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- نمایش پیام موفقیت -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">ایجاد تیکت جدید</h2>

                    <form action="{{ route('tickets.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- عنوان -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">عنوان</label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   value="{{ old('title') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('title') border-red-300 @enderror"
                                   required>
                            @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- پیام -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">پیام</label>
                            <textarea name="message"
                                      id="message"
                                      rows="4"
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('message') border-red-300 @enderror"
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- اولویت -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">اولویت</label>
                            <select name="priority"
                                    id="priority"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('priority') border-red-300 @enderror">
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>کم</option>
                                <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>متوسط</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>زیاد</option>
                            </select>
                            @error('priority')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- دسته‌بندی‌ها -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">دسته‌بندی‌ها</label>
                            <div class="space-y-3">
                                @foreach($categories as $category)
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               name="categories[]"
                                               value="{{ $category->id }}"
                                               {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <label class="mr-2 text-sm text-gray-700">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('categories')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- برچسب‌ها -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">برچسب‌ها</label>
                            <div class="flex flex-wrap gap-4">
                                @foreach($labels as $label)
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               name="labels[]"
                                               value="{{ $label->id }}"
                                               {{ in_array($label->id, old('labels', [])) ? 'checked' : '' }}
                                               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <label class="mr-2 text-sm text-gray-700">{{ $label->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('labels')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                ایجاد تیکت
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
