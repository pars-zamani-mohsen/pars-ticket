<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                تیکت‌ها
            </h2>
            <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition">
                ایجاد تیکت جدید
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- فیلترها -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- جستجو -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">جستجو</label>
                                <input type="text"
                                       name="filter[search]"
                                       value="{{ request('filter.search') }}"
                                       placeholder="جستجو در عنوان و توضیحات..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <!-- وضعیت -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">وضعیت</label>
                                <select name="filter[status]"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">همه</option>
                                    <option value="open" {{ request('filter.status') === 'open' ? 'selected' : '' }}>باز</option>
                                    <option value="closed" {{ request('filter.status') === 'closed' ? 'selected' : '' }}>بسته</option>
                                </select>
                            </div>

                            <!-- اولویت -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">اولویت</label>
                                <select name="filter[priority]"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">همه</option>
                                    <option value="high" {{ request('filter.priority') === 'high' ? 'selected' : '' }}>فوری</option>
                                    <option value="normal" {{ request('filter.priority') === 'normal' ? 'selected' : '' }}>متوسط</option>
                                    <option value="low" {{ request('filter.priority') === 'low' ? 'selected' : '' }}>عادی</option>
                                </select>
                            </div>

                            <!-- دسته‌بندی -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">دسته‌بندی</label>
                                <select name="filter[category]"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">همه</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('filter.category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex space-x-2 space-x-reverse">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                اعمال فیلتر
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- جدول -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->input('sort') === 'title' ? '-title' : 'title']) }}"
                                   class="flex items-center hover:text-gray-900">
                                    عنوان
                                    @if(request()->input('sort') === 'title')
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    @elseif(request()->input('sort') === '-title')
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">دسته‌بندی</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->input('sort') === 'priority' ? '-priority' : 'priority']) }}"
                                   class="flex items-center hover:text-gray-900">
                                    اولویت
                                    @if(request()->input('sort') === 'priority')
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    @elseif(request()->input('sort') === '-priority')
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->input('sort') === 'created_at' ? '-created_at' : 'created_at']) }}"
                                   class="flex items-center hover:text-gray-900">
                                    تاریخ
                                    @if(request()->input('sort') === 'created_at')
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    @elseif(request()->input('sort') === '-created_at')
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $ticket->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $ticket->user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($ticket->categories as $category)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    {{ $category->name }}
                                                </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $ticket->priority === 'high' ? 'bg-red-100 text-red-800' :
                                               ($ticket->priority === 'normal' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                            {{ $ticket->priority === 'high' ? 'فوری' : ($ticket->priority === 'normal' ? 'متوسط' : 'عادی') }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->is_resolved ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $ticket->is_resolved ? 'حل شده' : 'باز' }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" title="{{ verta($ticket->created_at)->format('Y/m/d H:i:s') }}">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3 space-x-reverse">
                                        <a href="{{ route('tickets.show', $ticket) }}"
                                           class="text-indigo-600 hover:text-indigo-900">مشاهده</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    هیچ تیکتی یافت نشد.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- پیجینیشن -->
            <div class="mt-6">
                {{ $tickets->withQueryString()->links() }}
            </div>
        </div>
    </div>

</x-app-layout>
