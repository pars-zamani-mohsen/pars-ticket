<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('ticket.tickets') }}
            </h2>
        </div>
    </x-slot>
    <x-slot name="title">
        {{ __('ticket.tickets') }}
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
                                <label class="block text-sm font-medium text-gray-700">{{ __('ticket.search') }}</label>
                                <input type="text"
                                       name="filter[search]"
                                       value="{{ request('filter.search') }}"
                                       placeholder="{{ __('ticket.search_in_title_description') }}..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <!-- وضعیت -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('ticket.status') }}</label>
                                <select name="filter[status]"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">{{ __('ticket.all') }}</option>
                                    <option value="open" {{ request('filter.status') === 'open' ? 'selected' : '' }}>{{ __('ticket.open') }}</option>
                                    <option value="closed" {{ request('filter.status') === 'closed' ? 'selected' : '' }}>{{ __('ticket.close') }}</option>
                                </select>
                            </div>

                            <!-- اولویت -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('ticket.priority') }}</label>
                                <select name="filter[priority]"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">{{ __('ticket.all') }}</option>
                                    <option value="high" {{ request('filter.priority') === 'high' ? 'selected' : '' }}>{{ __('ticket.high') }}</option>
                                    <option value="normal" {{ request('filter.priority') === 'normal' ? 'selected' : '' }}>{{ __('ticket.normal') }}</option>
                                    <option value="low" {{ request('filter.priority') === 'low' ? 'selected' : '' }}>{{ __('ticket.low') }}</option>
                                </select>
                            </div>

                            <!-- دسته‌بندی -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('ticket.category') }}</label>
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

                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2 space-x-reverse">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                    {{ __('general.submit_filter') }}
                                </button>
                                <a href="{{ route('tickets.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                                    {{ __('general.clear') }}
                                </a>
                            </div>

                            <a href="{{ route('tickets.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                {{ __('ticket.new_ticket') }}
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            <!-- جدول -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg overflow-x-scroll">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->input('sort') === 'title' ? '-title' : 'title']) }}"
                                   class="flex items-center hover:text-gray-900">
                                    {{ __('ticket.title') }}
                                    @if(request()->input('sort') === 'title')
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    @elseif(request()->input('sort') === '-title')
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ticket.category') }}</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->input('sort') === 'priority' ? '-priority' : 'priority']) }}"
                                   class="flex items-center hover:text-gray-900">
                                    {{ __('ticket.priority') }}
                                    @if(request()->input('sort') === 'priority')
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    @elseif(request()->input('sort') === '-priority')
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ticket.status') }}</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->input('sort') === 'created_at' ? '-created_at' : 'created_at']) }}"
                                   class="flex items-center hover:text-gray-900">
                                    {{ __('general.date') }}
                                    @if(request()->input('sort') === 'created_at')
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    @elseif(request()->input('sort') === '-created_at')
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('general.operation') }}</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-gray-50" title="{{ $ticket->id }}">
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
                                            {{ $ticket->priority === 'high' ? __('ticket.high') : ($ticket->priority === 'normal' ? __('ticket.normal') : __('ticket.low')) }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->is_resolved ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $ticket->is_resolved ? __('ticket.close') : __('ticket.open') }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" title="{{ \Morilog\Jalali\Jalalian::fromCarbon($ticket->created_at)->format('Y/m/d H:i') }}">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3 space-x-reverse">
                                        <a href="{{ route('tickets.show', $ticket) }}" title="{{ __('general.show') }}"
                                           class="text-indigo-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke-width="1.5"
                                                 stroke="currentColor"
                                                 class="w-5 h-5">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    {{ __('ticket.no_ticket_found') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $tickets->withQueryString()->links() }}
            </div>
        </div>
    </div>

</x-app-layout>
