@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/jalalidatepicker.min.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('js/jquery-3.6.0.min.js.js') }}"></script>
        <script src="{{ asset('js/jalalidatepicker.min.js.js') }}"></script>
    @endpush
@endonce

<div>
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif

    <input type="text"
           readonly
           name="{{ $name }}"
           id="{{ $id }}"
           value="{{ $value }}"
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm']) }}>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof jalaliDatepicker !== 'undefined') {
                jalaliDatepicker.startWatch({
                    selector: "#{{ $id }}",
                    format: "YYYY/MM/DD",
                    autoClose: true
                });
            }
        });
    </script>
@endpush
