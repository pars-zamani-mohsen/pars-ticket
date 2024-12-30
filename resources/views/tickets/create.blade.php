<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ticket.create_new_ticket') }}
        </h2>
    </x-slot>
    <x-slot name="title">
        {{ __('ticket.create_new_ticket') }}
    </x-slot>

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
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('ticket.create_new_ticket') }}</h2>

                    <form id="ticketForm" action="{{ route('tickets.store') }}" method="POST" class="space-y-6">
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
                        <x-forms.rich-text
                            name="message"
                            label="{{ __('ticket.message') }}"
                            :value="$ticket->message ?? null"
                            required
                        />

                    @if(auth()->user()->can('create tickets for-user'))
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('general.user') }}</label>
                                <select name="user_id"
                                        id="user_id"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('user_id') border-red-300 @enderror">
                                    <option value="">{{ __('general.select') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @selected(old('user_id', Request::get('user_id')) == $user->id)>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif


                        <!-- اولویت -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">{{ __('ticket.priority') }}</label>
                            <select name="priority"
                                    id="priority"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('priority') border-red-300 @enderror">
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>{{ __('ticket.low_value') }}</option>
                                <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>{{ __('ticket.normal') }}</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>{{ __('ticket.high_value') }}</option>
                            </select>
                            @error('priority')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- دسته‌بندی‌ها -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('ticket.categories') }}</label>
                            <div class="space-y-3">
                                <select name="categories[]"
                                        id="categories"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('priority') border-red-300 @enderror">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('categories')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- برچسب‌ها -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('ticket.labels') }}</label>
                            <div class="flex flex-wrap gap-4">
                                @foreach($labels as $label)
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               id="labels{{ $label->id }}"
                                               name="labels[]"
                                               value="{{ $label->id }}"
                                               {{ in_array($label->id, old('labels', [])) ? 'checked' : '' }}
                                               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <label for="labels{{ $label->id }}" class="mr-2 text-sm text-gray-700">{{ $label->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('labels')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit" id="submitBtn"
                                    class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                {{ __('ticket.create_ticket') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('ticketForm').addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.style.display = 'none';
            });
        </script>
    @endpush
</x-app-layout>
