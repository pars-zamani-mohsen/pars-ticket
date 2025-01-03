<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ticket.ticket_number_', ['ticket_id' => $ticket->id]) }}
        </h2>
    </x-slot>
    <x-slot name="title">
        {{ __('ticket.ticket_number_', ['ticket_id' => $ticket->id]) }}
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" dir="rtl">
        <!-- هدر تیکت -->
        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 sm:gap-6">
                <div class="space-y-3">
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900">{{ $ticket->title }}</h1>

                    <div class="flex flex-wrap gap-2">
                        @foreach($ticket->categories as $category)
                            <span class="inline-flex items-center px-2 sm:px-3 py-0.5 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        {{ $category->name }}
                    </span>
                        @endforeach

                        @foreach($ticket->labels as $label)
                            <span class="inline-flex items-center px-2 sm:px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ $label->name }}
                    </span>
                        @endforeach
                    </div>

                    <div class="flex items-center text-sm text-gray-500">
                        <span class="ml-2">{{ __('ticket.ticket_created_by') }}:</span>
                        <span class="font-medium text-gray-900">{{ $ticket->user->name }}</span>
                        <span class="mx-2">•</span>
                        <span title="{{ \Morilog\Jalali\Jalalian::fromCarbon($ticket->created_at)->format('Y/m/d H:i') }}">
                    {{ \Morilog\Jalali\Jalalian::fromCarbon($ticket->created_at)->ago() }}
                </span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4">
            <span class="inline-flex px-3 py-1 rounded-full text-sm {{ $ticket->priority === 'high' ? 'bg-red-100 text-red-800' : ($ticket->priority === 'normal' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                {{ $ticket->priority === 'high' ? __('ticket.high') : ($ticket->priority === 'normal' ? __('ticket.normal') : __('ticket.low')) }}
            </span>

                    @if(!$ticket->is_resolved)
                        <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_resolved" value="1">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition">
                                <svg class="ml-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                </svg>
                                {{ __('ticket.close_ticket') }}
                            </button>
                        </form>
                    @endif

                    @can('update tickets category')
                        <div class="w-full sm:w-auto bg-white rounded-lg shadow-sm border-r-4 p-3">
                            <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="space-y-2">
                                @csrf
                                @method('PUT')

                                <div class="space-y-2">
                                    <label for="categories" class="block text-sm font-semibold text-gray-700">
                                        {{ __('ticket.change_ticket_category') }}
                                    </label>

                                    <div class="relative">
                                        <select
                                            name="categories[]"
                                            id="categories"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm transition duration-150 ease-in-out focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-30">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                        @if(in_array($category->id, $ticket->categories->pluck('id')->toArray())) selected @endif>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="flex justify-end pt-3">
                                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition">
                                        <svg class="ml-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                        </svg>
                                        {{ __('general.confirm') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="prose max-w-none text-gray-700">
                {!! $ticket->message !!}
            </div>
        </div>

        <!-- پیام‌ها -->
        <div x-data="{
            showDeleteModal: false,
            fileToDelete: null,
            deleteFile() {
                fetch(`/tickets/file/${this.fileToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        throw new Error(data.message);
                    }
                    return data;
                })
                .then(data => {
                    this.showDeleteModal = false;
                    window.location.reload();
                })
                .catch(error => {
                    alert(error.message);
                });
            }
        }" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" dir="rtl">

            <div class="space-y-4 sm:space-y-6">
                @foreach($ticket->messages as $message)
                    <div class="relative {{ $message->user_id === $ticket->user_id ? 'ml-3 sm:ml-12' : 'mr-3 sm:mr-12' }}">
                        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 {{ $message->user_id === $ticket->user_id ? 'border-r-4 border-blue-500' : 'border-r-4 border-green-500' }}">
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                                <div class="flex items-start w-full">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full {{ $message->user_id === $ticket->user_id ? 'bg-blue-100' : 'bg-green-100' }} flex items-center justify-center">
                                            <img src="{{ asset('images/user.png') }}" alt="{{ $message->user->name }}" class="rounded-full">
                                        </div>
                                    </div>
                                    <div class="mr-3 sm:mr-4 flex-grow">
                                        <div class="flex flex-wrap items-center gap-2">
                                <span class="text-sm font-medium {{ $message->user_id === $ticket->user_id ? 'text-blue-600' : 'text-green-600' }}">
                                    {{ $message->user->name }}
                                </span>
                                            @if($message->user->hasRole('operator'))
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ __('general.operator') }}
                                    </span>
                                            @endif
                                            <span class="text-xs text-gray-500" title="{{ \Morilog\Jalali\Jalalian::fromCarbon($message->created_at)->format('Y/m/d H:i') }}">
                                    {{ \Morilog\Jalali\Jalalian::fromCarbon($message->created_at)->ago() }}
                                </span>
                                        </div>
                                        <div class="mt-1 text-sm text-gray-700">
                                            {!! $message->message !!}
                                        </div>

                                        <!-- نمایش فایل‌های پیوست هر پیام -->
                                        @if($message->getMedia('message-attachments')->count() > 0)
                                            <div class="mt-4">
                                                <div class="text-sm font-medium text-gray-900 mb-2">{{ __('general.attachment') }}:</div>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    @foreach($message->getMedia('message-attachments') as $media)
                                                        <div class="relative flex items-center p-2 sm:p-3 {{ $message->user_id === $ticket->user_id ? 'bg-blue-50 hover:bg-blue-100' : 'bg-green-50 hover:bg-green-100' }} rounded-md transition">
                                                            <a href="{{ url($media->getUrl()) }}"
                                                               target="_blank"
                                                               class="flex items-center flex-grow min-w-0">
                                                                <svg class="flex-shrink-0 h-5 w-5 {{ $message->user_id === $ticket->user_id ? 'text-blue-400' : 'text-green-400' }} ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                                </svg>
                                                                <div class="min-w-0 flex-1">
                                                                    <div class="text-sm font-medium text-gray-900 truncate">{{ $media->name }}</div>
                                                                    <div class="text-xs text-gray-500">{{ round($media->size / 1024) }} KB</div>
                                                                </div>
                                                            </a>

                                                            @can('delete tickets files')
                                                                <button type="button"
                                                                        @click="showDeleteModal = true; fileToDelete = {{ $media->id }}"
                                                                        class="flex-shrink-0 p-1 hover:bg-red-100 rounded-full transition-colors duration-200 ml-2">
                                                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                    </svg>
                                                                </button>
                                                            @endcan
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Modal تایید حذف -->
            <div x-show="showDeleteModal"
                 class="fixed inset-0 overflow-y-auto z-50"
                 x-cloak
                 style="display: none;">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <div class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:mr-4 sm:text-right">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        {{ __('ticket.confirm_delete_file') }}
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            {{ __('ticket.delete_ticket_message') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button"
                                    @click="deleteFile()"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                {{ __('general.delete') }}
                            </button>
                            <button type="button"
                                    @click="showDeleteModal = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                {{ __('general.cancel') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- فرم ارسال پیام -->
        @if(!$ticket->is_resolved)
            <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
                <form id="messageForm" action="{{ route('ticket.messages.store', $ticket) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <x-forms.rich-text
                        name="message"
                        label="{{ __('ticket.message') }}"
                        value=""
                        required
                    />

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('general.attachment') }}</label>
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
                                        <span>{{ __('general.select_file') }}</span>
                                    </label>
                                    <p class="pr-2">{{ __('general.release_file_here') }}</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    {{ __('general.maximum_file_size_100_MB') }}
                                </p>
                                <div id="fileList" class="mt-2 text-sm text-gray-500"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" id="submitBtn"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition">
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            {{ __('ticket.send_message') }}
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="{{ asset('js/fileUploaderConfig.js') }}"></script>
        <script>
            document.getElementById('messageForm').addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.style.display = 'none';
            });

        </script>
    @endpush
</x-app-layout>
