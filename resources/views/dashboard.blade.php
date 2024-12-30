<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('داشبورد') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- آمار کلی -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                @can('show permissions')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-gray-500 text-sm">{{ __('user.all_users') }}</div>
                            <div class="text-3xl font-bold text-gray-800">{{ $usersCount }}</div>
                        </div>
                    </div>
                @endcan

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">{{ __('ticket.all_tickets') }}</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $ticketsCount }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm"> {{ __('ticket.opened_tickets') }}</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $openTicketsCount }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <!-- اطلاعات کاربر -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('general.user_information') }}</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-xl font-bold text-gray-600">
                                        <img src="{{ asset('images/user.png') }}" alt="{{ auth()->user()->name }}">
                                    </span>
                                </div>
                                <div class="mr-4">
                                    <div class="font-semibold text-gray-800">{{ auth()->user()->name }}</div>
                                    <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                                </div>
                            </div>

                            @if(auth()->user()->roles->isNotEmpty())
                                <div class="border-t pt-4">
                                    <div class="text-sm text-gray-600 mb-2">{{ __('user.your_roles') }}:</div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(auth()->user()->roles as $role)
                                            <span class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">
                                            {{ $role->name }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if(auth()->user()->getAllPermissions()->isNotEmpty())
                                <div class="border-t pt-4">
                                    <div class="text-sm text-gray-600 mb-2">{{ __('permission.your_permissions') }}:</div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(auth()->user()->getAllPermissions() as $permission)
                                            <span class="px-3 py-1 text-sm bg-green-100 text-green-800 rounded-full">
                                            {{ $permission->name }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <!-- دسترسی سریع -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('general.fast_access') }}</h3>
                        <div class="grid grid-cols-2 gap-4">
                            @can('show users')
                                <a href="{{ route('admin.users.index') }}"
                                   class="p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="text-lg font-semibold text-gray-800">{{ __('user.user_management') }}</div>
                                    <div class="text-sm text-gray-500">{{ __('user.view_and_management_system_users') }}</div>
                                </a>
                            @endcan

                            @can('show roles')
                                <a href="{{ route('admin.roles.index') }}"
                                   class="p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="text-lg font-semibold text-gray-800">{{ __('role.role_management') }}</div>
                                    <div class="text-sm text-gray-500">{{ __('role.create_and_mangage_roles') }}</div>
                                </a>
                            @endcan

                            @can('show permissions')
                                <a href="{{ route('admin.permissions.index') }}"
                                   class="p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="text-lg font-semibold text-gray-800">{{ __('permission.permission_management') }}</div>
                                    <div class="text-sm text-gray-500">{{ __('permission.create_and_manage_permissions') }}</div>
                                </a>
                            @endcan

                                <a href="{{ route('tickets.index') }}"
                                   class="p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="text-lg font-semibold text-gray-800">{{ __('ticket.tickets') }}</div>
                                    <div class="text-sm text-gray-500">{{ __('ticket.ticket_manager') }}</div>
                                </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- آخرین فعالیت‌ها -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('general.last_activities') }}</h3>
                    <div class="space-y-4">
                        @foreach($activities as $activity)
                            <div class="flex items-center justify-between border-b pb-4">
                                <div>
                                    <div class="text-sm font-semibold text-gray-800">
                                        <span>{{ $activity->description }}</span>
                                        @if(! empty($activity->properties))
                                            <span class="px-4 py-3 mb-4 text-sm text-blue-700 border border-blue-200 rounded-lg">
                                                {{ implode(', ', $activity->properties) }}
                                            </span>
                                        @endif

                                    </div>
                                    <div class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
