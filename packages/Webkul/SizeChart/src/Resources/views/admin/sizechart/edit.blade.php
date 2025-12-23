<x-admin::layouts>
    <x-slot:title>
        {{ __('sizechart::app.sizechart.template.edit-temp-title') }}
    </x-slot>

    <div class="content sizechart-edit">
        <form method="POST"
              action="{{ route('sizechart.admin.index.update', $sizeChart->id) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <input type="hidden" name="template_type" value="{{ $sizeChart->template_type }}">

            <div class="box-shadow rounded bg-white p-4">
                {{-- Template Name --}}
                <div class="control-group">
                    <label class="required">
                        {{ __('sizechart::app.sizechart.template.template-name') }}
                    </label>

                    <input type="text"
                           name="template_name"
                           value="{{ old('template_name', $sizeChart->template_name) }}"
                           class="control"
                           required>
                </div>

                {{-- Template Code --}}
                <div class="control-group">
                    <label class="required">
                        {{ __('sizechart::app.sizechart.template.template-code') }}
                    </label>

                    <input type="text"
                           value="{{ $sizeChart->template_code }}"
                           class="control"
                           disabled>
                </div>

                {{-- Decide SIMPLE / CONFIGURABLE from DB --}}
                @php
                    $isSimple = $sizeChart->template_type === 'simple';
                @endphp

                @if($isSimple)
                    @include('sizechart::admin.sizechart.type.simple', [
                        'edit'    => true,
                        'headers' => $headers,
                        'matrix'  => $matrix
                    ])
                @else
                    @include('sizechart::admin.sizechart.type.configurable', [
                        'edit'    => true,
                        'headers' => $headers,
                        'matrix'  => $matrix
                    ])
                @endif

                {{-- Image --}}
                <div class="mt-5">
                    <x-admin::media.images
                        name="images"
                        :allow-multiple="false"
                        :uploaded-images="$sizeChart->image_path
                            ? [['url' => Storage::url($sizeChart->image_path)]]
                            : []" />
                </div>

                <button type="submit" class="primary-button mt-4">
                    {{ __('sizechart::app.sizechart.template.save-btn-title') }}
                </button>
            </div>
        </form>
    </div>
</x-admin::layouts>
