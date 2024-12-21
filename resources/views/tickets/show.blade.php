<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" dir="rtl">
        <!-- هدر تیکت -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">{{ $ticket->title }}</h1>

                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($ticket->categories as $category)
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                {{ $category->name }}
                            </span>
                        @endforeach

                        @foreach($ticket->labels as $label)
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $label->name }}
                            </span>
                        @endforeach
                    </div>

                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <span class="ml-2">ایجاد شده توسط:</span>
                        <span class="font-medium text-gray-900">{{ $ticket->user->name }}</span>
                        <span class="mx-2">•</span>
                        <span title="{{ verta($ticket->created_at)->format('Y/m/d H:i:s') }}">{{ $ticket->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="px-3 py-1 rounded-full text-sm {{ $ticket->priority === 'high' ? 'bg-red-100 text-red-800' : ($ticket->priority === 'normal' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                        {{ $ticket->priority === 'high' ? 'فوری' : ($ticket->priority === 'normal' ? 'متوسط' : 'عادی') }}
                    </span>
                    @if(!$ticket->is_resolved)
                        <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_resolved" value="1">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition">
                                <svg class="ml-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                </svg>
                                حل شده
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="prose max-w-none text-gray-700">
                {{ $ticket->message }}
            </div>
        </div>

        <!-- پیام‌ها -->
        <div class="space-y-6">
            @foreach($ticket->messages as $message)
                <div class="relative {{ $message->user_id === $ticket->user_id ? 'ml-12' : 'mr-12' }}">
                    <div class="bg-white rounded-lg shadow-sm p-6 {{ $message->user_id === $ticket->user_id ? 'border-r-4 border-blue-500' : 'border-r-4 border-green-500' }}">
                        <div class="flex justify-between items-start {{ $message->user_id === $ticket->user_id ? 'flex-row' : 'flex-row' }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full {{ $message->user_id === $ticket->user_id ? 'bg-blue-100' : 'bg-green-100' }} flex items-center justify-center">
                                <span class="{{ $message->user_id === $ticket->user_id ? 'text-blue-800' : 'text-green-800' }} font-medium">
                                    <img src="{{ asset('images/user.png') }}" alt="{{ $message->user->name }}" class="rounded-full">
                                </span>
                                    </div>
                                </div>
                                <div class="mr-4 flex-grow">
                                    <div class="flex items-center">
                                <span class="text-sm font-medium {{ $message->user_id === $ticket->user_id ? 'text-blue-600' : 'text-green-600' }}">
                                    {{ $message->user->name }}
                                </span>
                                        @if($message->user->hasRole('operator'))
                                            <span class="mr-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        اپراتور
                                    </span>
                                        @endif
                                    </div>
                                    <div class="mt-1 text-sm text-gray-700">
                                        {{ $message->message }}
                                    </div>

                                    <!-- نمایش فایل‌های پیوست هر پیام -->
                                    {{-- TODO: remove file by operator with permission --}}
                                    @if($message->getMedia('message-attachments')->count() > 0)
                                        <div class="mt-4">
                                            <div class="text-sm font-medium text-gray-900 mb-2">فایل‌های پیوست:</div>
                                            <div class="grid grid-cols-2 gap-4">
                                                @foreach($message->getMedia('message-attachments') as $media)
                                                    <a href="{{ url($media->getUrl()) }}"
                                                       target="_blank"
                                                       class="flex items-center p-3 {{ $message->user_id === $ticket->user_id ? 'bg-blue-50 hover:bg-blue-100' : 'bg-green-50 hover:bg-green-100' }} rounded-md transition">
                                                        <svg class="h-5 w-5 {{ $message->user_id === $ticket->user_id ? 'text-blue-400' : 'text-green-400' }} ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                        </svg>
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">{{ $media->file_name }}</div>
                                                            <div class="text-xs text-gray-500">{{ round($media->size / 1024) }} KB</div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-xs text-gray-500 whitespace-nowrap mr-4" title="{{ verta($message->created_at)->format('Y/m/d H:i:s') }}">
                                {{ $message->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    <!-- نشانگر خوانده شدن -->
                    @if($message->user_id === $ticket->user_id)
                        <div class="absolute left-2 bottom-2 flex items-center text-xs text-gray-500">
                            @if($message->read_at)
                                <svg class="w-4 h-4 text-blue-500 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                خوانده شده
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- فرم ارسال پیام -->
        @if(!$ticket->is_resolved)
            <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
                <form action="{{ route('ticket.messages.store', $ticket) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">پیام شما</label>
                        <textarea name="message" rows="4"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  placeholder="پیام خود را بنویسید..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">فایل‌های پیوست</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md transition-colors duration-200">
                                <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                        <input type="file"
                                               name="attachments[]"
                                               multiple
                                               class="sr-only"
                                               onchange="updateFileList(this)">
                                        <span>انتخاب فایل</span>
                                    </label>
                                    <p class="pr-2">یا فایل را اینجا رها کنید</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    حداکثر سایز هر فایل: ۱۰ مگابایت
                                </p>
                                <div id="fileList" class="mt-2 text-sm text-gray-500"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition">
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            ارسال پیام
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropZone = document.querySelector('.border-dashed');
                if (!dropZone) return; // اگر المان پیدا نشد

                const fileInput = dropZone.querySelector('input[type="file"]');
                if (!fileInput) return; // اگر input پیدا نشد

                // جلوگیری از رفتار پیش‌فرض
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    document.body.addEventListener(eventName, preventDefaults, false);
                    dropZone.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                // افکت‌های بصری
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => {
                        dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
                    });
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => {
                        dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
                    });
                });

                // مدیریت رها کردن فایل
                dropZone.addEventListener('drop', function(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;

                    // تبدیل FileList به آرایه و اضافه کردن به input
                    const fileArray = Array.from(files);
                    const dataTransfer = new DataTransfer();

                    fileArray.forEach(file => {
                        dataTransfer.items.add(file);
                    });

                    fileInput.files = dataTransfer.files;
                    updateFileList(fileInput);
                });
            });

            // تابع نمایش لیست فایل‌ها
            function updateFileList(input) {
                const fileList = document.getElementById('fileList');
                if (!fileList) return;

                fileList.innerHTML = '';

                Array.from(input.files).forEach(file => {
                    const fileSize = (file.size / 1024).toFixed(1);
                    const div = document.createElement('div');
                    div.textContent = `${file.name} (${fileSize} KB)`;
                    fileList.appendChild(div);
                });
            }
        </script>
    @endpush
</x-app-layout>
