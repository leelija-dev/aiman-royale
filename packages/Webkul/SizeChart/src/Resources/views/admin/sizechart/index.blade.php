<x-admin::layouts>
    <x-slot:title>
        @lang('sizechart::app.sizechart.template.title')
    </x-slot>

    <div class="flex items-center justify-between">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('sizechart::app.sizechart.template.title')
        </p>

        <div class="flex items-center gap-x-2.5">
            <!-- Export Modal -->
            <x-admin::datagrid.export :src="route('sizechart.admin.index')" />

            <a
                href="{{ route('sizechart.admin.index.create', ['type' => '0']) }}"
                class="primary-button"
            >
                @lang('sizechart::app.sizechart.template.add-configurable')
            </a>

            <a
                href="{{ route('sizechart.admin.index.create', ['type' => '1']) }}"
                class="primary-button"
            >
                @lang('sizechart::app.sizechart.template.add-simple')
            </a>
        </div>
    </div>

    {!! view_render_event('bagisto.admin.sizechart.template.list.before') !!}

    <x-admin::datagrid :src="route('sizechart.admin.index')">
        <x-slot:header>
            <x-admin::datagrid.toolbar>
                <x-slot:bulk-actions>
                    <x-admin::datagrid.toolbar.mass-action
                        :title="__('admin::app.datagrid.delete')"
                        :action="route('sizechart.admin.index.massdelete')"
                        method="POST"
                    >
                        <input type="hidden" name="_method" value="DELETE">
                        @csrf
                    </x-admin::datagrid.toolbar.mass-action>
                </x-slot:bulk-actions>
            </x-admin::datagrid.toolbar>
        </x-slot>
    </x-admin::datagrid>
    
    {!! view_render_event('bagisto.admin.sizechart.template.list.after') !!}

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle delete button clicks
                document.querySelectorAll('[data-confirm]').forEach(element => {
                    element.addEventListener('click', function(event) {
                        if (!confirm(this.dataset.confirm)) {
                            event.preventDefault();
                            event.stopPropagation();
                            return false;
                        }
                    });
                });
            });
        </script>
    @endpush
</x-admin::layouts>