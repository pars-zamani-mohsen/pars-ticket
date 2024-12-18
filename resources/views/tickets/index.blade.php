<x-app-layout>
    <div class="py-6" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-right text-sm font-medium text-gray-500">شماره</th>
                            <th scope="col" class="px-6 py-4 text-right text-sm font-medium text-gray-500">عنوان</th>
                            <th scope="col" class="px-6 py-4 text-right text-sm font-medium text-gray-500">دسته‌بندی‌ها</th>
                            <th scope="col" class="px-6 py-4 text-right text-sm font-medium text-gray-500">برچسب‌ها</th>
                            <th scope="col" class="px-6 py-4 text-right text-sm font-medium text-gray-500">اولویت</th>
                            <th scope="col" class="px-6 py-4 text-right text-sm font-medium text-gray-500">وضعیت</th>
                            <th scope="col" class="px-6 py-4 text-right text-sm font-medium text-gray-500">تاریخ</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $ticket->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('tickets.show', $ticket) }}"
                                       class="text-blue-600 hover:text-blue-900">{{ $ticket->title }}</a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($ticket->categories as $category)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    {{ $category->name }}
                                                </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($ticket->labels as $label)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $label->name }}
                                                </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $ticket->priority === 'high' ? 'bg-red-100 text-red-800' :
                                               ($ticket->priority === 'normal' ? 'bg-yellow-100 text-yellow-800' :
                                               'bg-green-100 text-green-800') }}">
                                            {{ $ticket->priority === 'high' ? 'زیاد' :
                                               ($ticket->priority === 'normal' ? 'متوسط' : 'کم') }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $ticket->status === 'closed' ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $ticket->status === 'closed' ? 'بسته شده' : 'باز' }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
