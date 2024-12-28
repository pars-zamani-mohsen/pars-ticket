<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('گزارش فعالیت‌ها') }}
            </h2>
        </div>
    </x-slot>
    <x-slot name="title">
        {{ __('گزارش فعالیت‌ها') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- نوع رویداد -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">نوع رویداد</label>
                                <select name="filter[event]"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">همه رویدادها</option>
                                    <option value="created" {{ request('filter.event') === 'created' ? 'selected' : '' }}>ایجاد</option>
                                    <option value="updated" {{ request('filter.event') === 'updated' ? 'selected' : '' }}>ویرایش</option>
                                    <option value="deleted" {{ request('filter.event') === 'deleted' ? 'selected' : '' }}>حذف</option>
                                </select>
                            </div>

                            <!-- توضیحات -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">توضیحات</label>
                                <input type="text"
                                       name="filter[description]"
                                       value="{{ request('filter.description') }}"
                                       placeholder="جستجو در توضیحات..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <!-- تاریخ از -->
                            <x-date-picker
                                name="filter[from_date]"
                                label="{{ __('general.from_date') }}"
                                value="{{ request('filter.from_date') }}"
                            />

                            <!-- تاریخ تا -->
                            <x-date-picker
                                name="filter[to_date]"
                                label="{{ __('general.to_date') }}"
                                value="{{ request('filter.to_date') }}"
                            />

                            <!-- کاربر -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">کاربر</label>
                                <input type="text"
                                       name="filter[causer_name]"
                                       value="{{ request('filter.causer_name') }}"
                                       placeholder="نام کاربر..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2 space-x-reverse">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                    اعمال فیلتر
                                </button>
                                <a href="{{ route('admin.activity-logs.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                                    پاک کردن
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg overflow-x-scroll">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->get('sort') === 'created_at' ? '-created_at' : 'created_at']) }}"
                                   class="flex items-center justify-start hover:text-gray-900">
                                    <span>تاریخ</span>
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
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request()->get('sort') === 'event' ? '-event' : 'event']) }}"
                                   class="flex items-center justify-start hover:text-gray-900">
                                    <span>رویداد</span>
                                    @if(request()->get('sort') === 'event')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    @elseif(request()->get('sort') === '-event')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">توضیحات</th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">کاربر</th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">موضوع</th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">جزئیات</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($activities as $activity)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{ \Morilog\Jalali\Jalalian::fromCarbon($activity->created_at)->format('Y/m/d H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $activity->event === 'created' ? 'bg-green-100 text-green-800' :
                                           ($activity->event === 'updated' ? 'bg-yellow-100 text-yellow-800' :
                                            'bg-red-100 text-red-800') }}">
                                        {{ __('activity.' . $activity->event) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $activity->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $activity->causer ? $activity->causer->name : 'سیستم' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ __('activity.' . $activity->subject_type) }}
                                    ({{ $activity->subject_id }})
                                </td>
                                <td class="px-6 py-4">
                                    @if($activity->properties->count() > 0)
                                        <button type="button"
                                                class="text-blue-600 hover:text-blue-900"
                                                onclick="alert('{{ json_encode($activity->properties, JSON_UNESCAPED_UNICODE) }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $activities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
