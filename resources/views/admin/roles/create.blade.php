<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($role) ? __('role.update_role') : __('role.create_role') }}
        </h2>
    </x-slot>

    <x-slot name="title">
        {{ isset($role) ? __('role.update_role') : __('role.create_role') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ isset($role) ? route('admin.roles.update', $role) : route('admin.roles.store') }}">
                        @csrf
                        @if(isset($role))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                نام نقش
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                                   id="name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name', $role->name ?? '') }}"
                                   required>
                            @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-700 text-sm font-bold">{{ __('permission.permissions') }}</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($permissions as $module => $modulePermissions)
                                    <div class="bg-white p-4 rounded-lg shadow permission-card" id="module-{{ $module }}">
                                        <div class="flex justify-between items-center mb-3 border-b pb-2">
                                            <h3 class="font-bold text-lg text-gray-800">
                                                {{ ucfirst($module) }}
                                            </h3>
                                            <button type="button"
                                                    class="text-sm text-blue-600 hover:text-blue-800"
                                                    onclick="toggleModulePermissions('{{ $module }}')">
                                                {{ __('general.select_all') }}
                                            </button>
                                        </div>
                                        <div class="space-y-2" id="{{ $module }}-permissions">
                                            @foreach($modulePermissions as $permission)
                                                <div class="permission-item" x-data="{ showTooltip: false }">
                                                    <label class="flex items-center group hover:bg-gray-50 p-1 rounded transition-colors">
                                                        <input type="checkbox"
                                                               name="permissions[]"
                                                               value="{{ $permission->name }}"
                                                               class="form-checkbox h-5 w-5 text-blue-600 rounded"
                                                               @if(isset($role) && $role->hasPermissionTo($permission->name)) checked @endif>
                                                        <div class="mr-2 flex-1 relative"
                                                             @mouseenter="showTooltip = true"
                                                             @mouseleave="showTooltip = false">
                                                            <div class="text-sm font-medium text-gray-700">
                                                                {{ $permission->name }}
                                                            </div>
                                                            @if($permission->description)
                                                                <div class="text-xs text-gray-500">
                                                                    {{ $permission->description }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    {{ isset($role) ? __('general.edit') : __('general.create') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleModulePermissions(module) {
                const container = document.getElementById(`${module}-permissions`);
                const checkboxes = container.querySelectorAll('input[type="checkbox"]');
                const someUnchecked = Array.from(checkboxes).some(cb => !cb.checked);

                checkboxes.forEach(checkbox => {
                    checkbox.checked = someUnchecked;
                });
            }
        </script>
    @endpush
</x-app-layout>
