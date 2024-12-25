<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('user.user_management') }}
        </h2>
    </x-slot>
    <x-slot name="title">
        {{ __('user.user_management') }}
    </x-slot>
    {{-- Include jQuery First --}}
    <script src="{{ asset('js/jquery-3.6.0.min.js.js') }}"></script>

    {{-- Persian Date Requirements --}}
    <script src="{{ asset('js/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/persian-datepicker.min.css') }}">

    <div x-data="usersIndex" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form @submit.prevent="applyFilters" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- جستجو -->
                            <div class="md:col-span-1">
                                <label for="search" class="block text-sm font-medium text-gray-700">{{ __('ticket.search') }}</label>
                                <input type="text"
                                       id="search"
                                       x-model="filters.search"
                                       class="mt-1 block w-full rounded-md border-gray-300"
                                       placeholder="{{ __('user.search_in_email_mobile') }}...">
                            </div>

                            <!-- تاریخ از -->
                            <div>
                                <label for="from_date" class="block text-sm font-medium text-gray-700">{{ __('general.from_date') }}</label>
                                <input type="text"
                                       id="from_date"
                                       x-model="filters.from_date"
                                       class="pdate mt-1 block w-full rounded-md border-gray-300"
                                       readonly>
                            </div>

                            <!-- تاریخ تا -->
                            <div>
                                <label for="to_date" class="block text-sm font-medium text-gray-700">{{ __('general.to_date') }}</label>
                                <input type="text"
                                       id="to_date"
                                       x-model="filters.to_date"
                                       class="pdate mt-1 block w-full rounded-md border-gray-300"
                                       readonly>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="deleted" value="1"
                                           x-model="filters.deleted"
                                           @checked(old('deleted', request()->has('filter.deleted')))
                                           class="form-checkbox h-5 w-5 text-blue-600">
                                    <span class="mr-2">{{ __('user.deleted_user') }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- دکمه‌های اکشن -->
                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2 space-x-reverse">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                    {{ __('general.submit_filter') }}
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                                    {{ __('general.clear') }}
                                </a>
                            </div>

                            @can('create users')
                                <a href="{{ route('admin.users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                    {{ __('user.new_user') }}
                                </a>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg overflow-x-scroll">
                <div class="p-6">
                    <!-- جدول -->
                    @if(request()->has('filter.deleted'))
                        <span class="text-red-600 px-4 py-2 rounded-md hover:bg-red-600 hover:text-white">{{ __('user.deleted_user') }}</span>
                    @endif
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->get('sort') === 'name' ? '-name' : 'name']) }}"
                                   class="flex items-center justify-start hover:text-gray-900">
                                    <span>{{ __('user.name') }}</span>
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
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->get('sort') === 'email' ? '-email' : 'email']) }}"
                                   class="flex items-center justify-start hover:text-gray-900">
                                    <span>{{ __('user.email') }}</span>
                                    @if(request()->get('sort') === 'email')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    @elseif(request()->get('sort') === '-email')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->get('sort') === 'mobile' ? '-mobile' : 'mobile']) }}"
                                   class="flex items-center justify-start hover:text-gray-900">
                                    <span>{{ __('user.mobile') }}</span>
                                    @if(request()->get('sort') === 'mobile')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    @elseif(request()->get('sort') === '-mobile')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('role.roles') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('user.categories') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->get('sort') === 'created_at' ? '-created_at' : 'created_at']) }}"
                                   class="flex items-center justify-start hover:text-gray-900">
                                    <span>{{ __('user.register_date') }}</span>
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
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('general.operation') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr title="{{ $user->id }}" >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->mobile }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $role->name }}
                                            </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @foreach($user->categories as $category)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $category->name }}
                                            </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ verta($user->created_at)->format('Y/m/d H:i') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if(! request()->has('filter.deleted'))
                                        <div class="flex items-center justify-end space-x-3 space-x-reverse">
                                            @can('create tickets for-user')
                                                <a href="{{ route('tickets.create', ['user_id' => $user->id]) }}"
                                                   class="text-indigo-600 hover:text-indigo-900"
                                                   title="{{ __('ticket.create_ticket') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                                                    </svg>
                                                </a>
                                            @endcan

                                            @can('update tickets')
                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                   class="text-blue-600 hover:text-blue-900"
                                                   title="{{ __('general.edit') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                            @endcan

                                            @can('delete users')
                                                <form action="{{ route('admin.users.destroy', $user) }}"
                                                      method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirm('{{ __('general.delete_item_message') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-900"
                                                            title="{{ __('general.delete') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    {{ __('user.no_users_found') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('usersIndex', () => ({
                    filters: {
                        search: @json(request('filter.search', '')),
                    from_date: @json(request('filter.from_date', '')),
                    to_date: @json(request('filter.to_date', ''))
            },

            init() {
                // اطمینان از لود شدن کامل صفحه
                this.$nextTick(() => {
                    // تنظیمات تقویم شمسی
                    $('.pdate').persianDatepicker({
                        format: 'YYYY/MM/DD',
                        autoClose: true,
                        initialValue: false,
                        observer: true,
                        onSelect: (unix) => {
                            // به‌روزرسانی مقدار در Alpine
                            const inputId = $(this).attr('id');
                            this.filters[inputId] = unix;
                        }
                    });
                });
            },

            applyFilters() {
                let params = new URLSearchParams(window.location.search);

                // اعمال فیلترها
                Object.entries(this.filters).forEach(([key, value]) => {
                    if (value) {
                        params.set(`filter[${key}]`, value);
                    } else {
                        params.delete(`filter[${key}]`);
                    }
                });

                // حفظ پارامتر مرتب‌سازی
                if (params.has('sort')) {
                    params.set('sort', params.get('sort'));
                }

                // ریدایرکت با پارامترهای جدید
                window.location.search = params.toString();
            },
        }));
    });
        </script>
    @endpush

    @push('styles')
        <style>
            body {
                direction: rtl;
            }

            .space-x-reverse > :not([hidden]) ~ :not([hidden]) {
                --tw-space-x-reverse: 1;
            }
        </style>
    @endpush
</x-app-layout>
