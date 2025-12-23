<x-admin::layouts>
    <x-slot:title>
        {{ __('sizechart::app.sizechart.template.add-temp-title') }}
        </x-slot>

        @push('styles')
        <style id="sizechart-create-styles">
            .table td .label {
                margin-right: 10px;
            }

            .table td .label:last-child {
                margin-right: 0;
            }

            .table td .label .icon {
                vertical-align: middle;
                cursor: pointer;
            }

            .sizechart-create .custom_input {
                height: 28px !important;
                text-align: center !important;
                font-weight: bold !important;
            }

            .sizechart-create .custom_input_t {
                height: 28px !important;
                text-align: center !important;
            }

            .sizechart-create .customOption {
                display: flex !important;
            }

            .sizechart-create .customSpan {
                margin: 2px !important;
            }

            .sizechart-create .customOptionDiv {
                padding-top: 20px !important;
                padding-bottom: 20px !important;
                overflow: auto !important;
            }

            /* Scoped rules for form groups and inputs in the create page */
            .sizechart-create .control-group {
                margin-bottom: 16px !important;
            }

            .sizechart-create .control-group label.required::after {
                content: ' *' !important;
                color: #dc2626 !important; /* red-600 */
                font-weight: 700 !important;
            }

            .sizechart-create .control-group .control {
                height: 38px !important;
                padding: 6px 10px !important;
                border: 1px solid #e5e7eb !important; /* gray-200 */
                border-radius: 4px !important;
            }

            .sizechart-create .control-group.has-error .control {
                border-color: #dc2626 !important; /* red-600 */
            }

            .sizechart-create .control-group .control-error {
                display: block !important;
                margin-top: 6px !important;
                color: #dc2626 !important; /* red-600 */
                font-size: 12px !important;
            }
        </style>

        @endpush


        <div class="content sizechart-create">
            <form id="sizechart-create-form" method="POST" action="{{ route('sizechart.admin.index.store') }}" enctype="multipart/form-data">
                <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                    <p class="text-xl font-bold text-gray-800 dark:text-white">
                        {{ __('sizechart::app.sizechart.template.add-temp-title') }}
                    </p>

                    <div class="flex items-center gap-x-2.5">
                        <a
                            href="{{ route('sizechart.admin.index') }}"
                            class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                        >
                            {{ __('admin::app.catalog.categories.create.back-btn') }}
                        </a>

                        <button
                            type="submit"
                            class="primary-button"
                        >
                            {{ __('sizechart::app.sizechart.template.save-btn-title') }}
                        </button>
                    </div>
                </div>

                <div class="page-content mt-3.5">
                    @csrf()

                    @if (session('success'))
                        <div class="alert alert-success" style="margin-bottom: 16px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-error" style="margin-bottom: 16px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-error" style="margin-bottom: 16px;">
                            <strong>{{ __('admin::app.common.error') }}</strong>
                            <ul style="margin-top: 8px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {!! view_render_event('bagisto.admin.sizechart.template.create_simple_template.before') !!}

                    <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                        <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                            {{ __('sizechart::app.sizechart.template.add-simple-temp') }}
                        </p>

                            @if($type)
                                <input type="hidden" name="template_type" value="simple" />
                                
                                <!-- Column Names Input -->
                                <div class="control-group">
                                    <label for="column_names" class="required">
                                        {{ __('sizechart::app.sizechart.template.column-names') }}
                                    </label>
                                    <input type="text"
                                           id="column_names"
                                           name="column_names"
                                           class="control"
                                           placeholder="{{ __('sizechart::app.sizechart.template.column-names-placeholder') }}"
                                           value="{{ old('column_names', '') }}"
                                           required>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ __('sizechart::app.sizechart.template.column-names-help') }}
                                    </p>
                                </div>
                            @else
                                <input type="hidden" name="template_type" value="configurable" />
                            @endif

                            <div class="control-group" :class="[(errors && errors.has && errors.has('template_name')) ? 'has-error' : '']">
                                <label for="template_name" class="mb-2.5 block text-xs font-medium leading-6 text-gray-800 dark:text-white required">{{ __('sizechart::app.sizechart.template.template-name') }}</label>
                                <input
                                    type="text"
                                    v-validate="{ required: true }"
                                    id="template_name"
                                    name="template_name"
                                    value="{{ request()->input('template_name') ?: old('template_name') }}"
                                    data-vv-as="&quot;{{ __('sizechart::app.sizechart.template.template-name') }}&quot;"
                                    :class="[ (errors && errors.has && errors.has('template_name')) ? 'border border-red-600 hover:border-red-600' : '' ]"
                                    class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                                />
                                <span class="control-error text-xs text-red-600" v-if="errors && errors.has && errors.has('template_name')">@{{ errors.first('template_name') }}</span>
                            </div>

                            <div class="control-group" :class="[(errors && errors.has && errors.has('template_code')) ? 'has-error' : '']">
                                <label for="template_code" class="mb-2.5 block text-xs font-medium leading-6 text-gray-800 dark:text-white required">{{ __('sizechart::app.sizechart.template.template-code') }}</label>
                                <input
                                    type="text"
                                    v-validate="{ required: true }"
                                    id="template_code"
                                    name="template_code"
                                    value="{{ request()->input('template_code') ?: old('template_code') }}"
                                    data-vv-as="&quot;{{ __('sizechart::app.sizechart.template.template-code') }}&quot;"
                                    :class="[ (errors && errors.has && errors.has('template_code')) ? 'border border-red-600 hover:border-red-600' : '' ]"
                                    class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                                />
                                <span class="control-error text-xs text-red-600" v-if="errors && errors.has && errors.has('template_code')">@{{ errors.first('template_code') }}</span>
                            </div>

                            @if($type)
                            @include ('sizechart::admin.sizechart.type.simple')
                            @else
                            @include ('sizechart::admin.sizechart.type.configurable')
                            @endif

                            <div class="mt-5">
                                <p class="mb-2 font-medium text-gray-800 dark:text-white">
                                    {{ __('sizechart::app.sizechart.template.template-image') }}
                                </p>
                                <p class="mb-3 text-xs text-gray-500">
                                    {{ __('admin::app.catalog.categories.create.banner-size') }}
                                </p>
                                <div class="control-group image {!! $errors->has('images') || $errors->has('images.*') ? 'has-error' : '' !!}">
                                    <x-admin::media.images name="images" />

                                    @error('images')
                                        <span class="control-error text-xs text-red-600">{{ $message }}</span>
                                    @enderror

                                    @if ($errors->has('images.*'))
                                        <span class="control-error text-xs text-red-600">
                                            @foreach ($errors->get('images.*') as $key => $message)
                                                @php echo str_replace($key, 'Image', $message[0]); @endphp
                                            @endforeach
                                        </span>
                                    @endif
                                </div>
                            </div>

                    </div>

                    {!! view_render_event('bagisto.admin.sizechart.template.create_simple_template.after') !!}
                </div>
            </form>
        </div>

        @push('scripts')
        <script>
            // Pass server routes/messages to the SizeChart plugin as globals
            window.__sizechartAttributeUrl = "{{ route('sizechart.admin.config.attribute') }}";
            window.__sizechartNoOptionMsg = "{{ __('sizechart::app.sizechart.template.custom-option-not-available') }}";
            window.__sizechartSomethingWrong = "{{ __('error.something_went_wrong') }}";

            // Ensure size chart styles stay last in the head to avoid being overridden after Vue mount
            window.addEventListener('load', function() {
                try {
                    var styleEl = document.getElementById('sizechart-create-styles');
                    if (styleEl && document.head) {
                        // Clone and append to the end of head so our rules have the last word
                        var clone = styleEl.cloneNode(true);
                        document.head.appendChild(clone);
                    }
                } catch (e) {
                    // no-op
                }

                // Prevent submit if size chart matrix (formname[][]) is missing
                try {
                    var form = document.getElementById('sizechart-create-form');
                    if (form) {
                        form.addEventListener('submit', function (e) {
                            var hasMatrixInputs = form.querySelector('input[name^="formname["]');
                            if (! hasMatrixInputs) {
                                e.preventDefault();

                                // Try using Bagisto flash, fallback to alert
                                window.flashMessages = [{
                                    type: 'alert-error',
                                    message: '{{ __('sizechart::app.sizechart.template.empty-custom-option') }}'
                                }];

                                if (window.app && app._instance && app._instance.proxy && typeof app._instance.proxy.addFlashMessages === 'function') {
                                    app._instance.proxy.addFlashMessages();
                                } else if (document && typeof window.alert === 'function') {
                                    alert('{{ __('sizechart::app.sizechart.template.empty-custom-option') }}');
                                }
                            }
                        });
                    }
                } catch (e) {
                    // no-op
                }
            });
        </script>

        <script type="module">
            // Register the SizeChart custom options component for Simple template (type=1)
            app.component('add-custom-options', {
                template: '#add-custom-options-template',

                data() {
                    return {
                        label: '',
                        customOptionValues: '',
                        showCustomOptions: false,
                        inputOptions: '',
                        counter: 0,
                        addRows: [],
                    }
                },

                methods: {
                    addCustomOption() {
                        if (this.customOptionValues && this.customOptionValues.trim() !== '') {
                            this.showCustomOptions = true;
                            this.inputOptions = this.customOptionValues
                                .split(',')
                                .map((s) => s.trim())
                                .filter(Boolean);
                        } else {
                            window.flashMessages = [{
                                type: 'alert-error',
                                message: "{{ __('sizechart::app.sizechart.template.empty-custom-option') }}",
                            }];

                            if (app && app._instance && app._instance.proxy && typeof app._instance.proxy.addFlashMessages === 'function') {
                                app._instance.proxy.addFlashMessages();
                            }
                        }
                    },

                    backtoinput() {
                        this.showCustomOptions = false;
                        this.counter = 0;
                        this.addRows = [];
                    },

                    addCustomRow() {
                        this.counter += 1;
                        this.addRows.push({ row: this.counter });
                    },

                    removeCustomRow(key) {
                        this.addRows.splice(key, 1);
                    },
                },
            });
        </script>
        @endpush
</x-admin::layouts>