<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
    @endif

    <div
        x-data="richText('{{ $name }}', '{{ $value }}')"
        wire:ignore
    >
        <div
            id="editor-{{ $name }}"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error($name) border-red-300 @enderror"
            style="height: 200px;"
        ></div>
        <input
            type="hidden"
            name="{{ $name }}"
            id="{{ $name }}"
            x-ref="input"
            @if($required) required @endif
        >
    </div>

    @error($name)
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror

    @once
        @push('styles')
            <link href="{{ asset('css/quill.snow.css') }}" rel="stylesheet">
            <style>
                .ql-editor {
                    min-height: 200px;
                    direction: rtl;
                    text-align: right;
                }
                .ql-snow .ql-picker-label {
                    padding-right: 18px;
                }
            </style>
        @endpush

        @push('scripts')
            <script src="{{ asset('js/quill.js.js') }}"></script>
            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('richText', (name, initialValue) => ({
                        quill: null,
                        init() {
                            this.quill = new Quill(`#editor-${name}`, {
                                theme: 'snow',
                                modules: {
                                    toolbar: [
                                        ['bold', 'italic', 'underline', 'strike'],
                                        ['blockquote'],
                                        [{ 'header': 1 }, { 'header': 2 }],
                                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                        [{ 'script': 'sub'}, { 'script': 'super' }],
                                        [{ 'direction': 'rtl' }],
                                        ['clean']
                                    ]
                                },
                                placeholder: '{{ $placeholder ?? "پیام خود را بنویسید..." }}'
                            });

                            if (initialValue) {
                                this.quill.root.innerHTML = initialValue;
                            }

                            this.quill.on('text-change', () => {
                                this.$refs.input.value = this.quill.root.innerHTML;
                            });

                            // تنظیم مقدار اولیه در input مخفی
                            this.$refs.input.value = this.quill.root.innerHTML;
                        }
                    }));
                });
            </script>
        @endpush
    @endonce
</div>
