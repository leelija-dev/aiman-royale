{{-- @extends('Admin.layouts.master')
@section('source', 'CMS')
@section('page-title', 'Pages')
@section('content')


<div id="create-page" class="mt-4 mx-3">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">

                <!-- < ?php if (isset($_GET['msg'])) { ?>
                            <div class="alert < ?= $_GET['action'] == 'SU' ? 'alert-info' : 'alert-danger'; ?> alert-dismissible fade show" role="alert">
                                <span class="alert-text text-light"><strong>< ?= $_GET['msg']; ?></strong></span>
                            </div>
                        < ?php } ?> -->

            </div>
            <div class="cards-body px-0 pt-0 pb-2">

                <form action="{{ route('admin.page.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row px-4">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service" class="text-uppercase text-secondary">Service Page</label>
                                <select name="service" id="service" class="form-control" required>
                                    <option value="" disabled selected>Select Service</option>
                                    @foreach ($services as $service)
                                    @php
                                    // Check if service name exists in any page's meta_title
                                    $isUsed = $pages->contains(function ($page) use ($service) {
                                    return $page->service_id === $service['id'];
                                    });
                                    @endphp
                                    <option value="{{ $service['id'] }}" {{ $isUsed ? 'disabled' : '' }} {{old('service') == $service['id'] ? 'selected' : '' }}>
                                        {{ $service['name'] }} {{ $isUsed ? '(Already Used)' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="service" class="text-uppercase text-secondary">Meta Title</label>
                                <input type="text" name="meta_title" id="meta_title" placeholder="Regular" value="{{old('meta_title')}}" class="form-control" />
                            </div>
                            @error('meta_title')
                            <div>
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror
                            <div class="form-group">
                                <label for="seo-url" class="text-uppercase text-secondary">Meta Keyword: </label>
                                <input type="text" name="meta_keyword" id="meta_keyword" class="form-control" value="{{old('meta_keyword')}}" />
                            </div>
                            @error('meta_keyword')
                            <div>
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror
                            <div class="form-group">
                                <label for="seo-url" class="text-uppercase text-secondary  ">Meta Tags </label>
                                <input type="text" name="meta_tags" id="meta_tags" class="form-control" value="{{old('meta_tags')}}" />
                            </div>
                            @error('meta_tags')
                            <div>
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror



                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="meta_description" class="text-uppercase text-secondary">Meta Description:
                                </label>
                                <textarea class="form-control" name="meta_description" id="meta_description" rows="4">{{old('meta_description')}}</textarea>
                            </div>
                            @error('meta_description')
                            <div>
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror

                            <div class="form-group">
                                <label for="seo-url" class="text-uppercase text-secondary">Schema</label>
                                <textarea class="form-control" name="schema" id="schema" rows="5">{{old('schema')}}</textarea>
                            </div>
                            @error('schema')
                            <div>
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror

                            <div class="form-group">
                                <label for="category" class="text-uppercase text-secondary  ">Status </label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="" disabled selected>Select</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                            @error('status')
                            <div>
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror

                            <!-- <div class="form-group">
                                                    <label for="meta-description">Meta Description: </label>
                                                    <textarea class="form-control" name="meta-description" id="meta-description" rows="2"></textarea>
                                                </div> -->
                        </div>
                    </div>
                    <div id="sections-container">
                        <!-- <div class="additional-section" data-section-index="0"> -->
                            <!-- <div class="row mx-3 mb-4">
                                <div class="col-12">
                                    <h5 class="mb-3 mt-3 text-center">Additional Section</h5>



                                    <div class="form-group">
                                        <label for="message" class="text-uppercase text-secondary  ">Title</label>
                                        <textarea type="text" name="reply" id="title" placeholder="Title"
                                            class="form-control" rows="12" required></textarea>


                                        @error('reply')
                                        <div>
                                            <span class="invalid-feedback d-block" role="alert">
                                                {{ $message }}
                                            </span>
                                        </div>
                                        @enderror
                                    </div>

                                    <div id="card-container" class="row row-cols-1 row-cols-md-2 g-4">

                                        @php $initialCards = json_decode($component->cards_data ?? '[]', true); @endphp
                                        <div class="col card-item" data-index="0">
                                            <div class="card h-100 p-3 position-relative">
                                                <div class="form-group mb-3">
                                                    <label class="text-uppercase text-secondary">Card Header</label>
                                                    <input type="text" name="cards[0][header]" class="form-control" placeholder="Header Title" value="{{ $initialCards[0]['header'] ?? '' }}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="text-uppercase text-secondary">Description</label>
                                                    <textarea name="cards[0][description]" class="form-control" rows="3" placeholder="Description...">{{ $initialCards[0]['description'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button type="button" id="add-card-btn" class="btn btn-primary">Add Card</button>
                                    </div>
                                </div>
                            </div> -->
                        <!-- </div> -->
                    </div>

                    <div class="mt-4 text-center">
                        <button type="button" id="add-section-btn" class="btn btn-success">Add Section</button>
                    </div>

                    <!-- <div class="col-12 px-4 mt-2">
                                            <textarea class="form-control" id="summernote" name="service-description"></textarea>
                                        </div> -->
                    <div class="d-flex justify-content-end me-4 mt-2">
                        <a href="{{ route('admin.pages') }}" role="button"
                            class="btn btn-secondary btm-sm me-4">Cancel</a>
                        <button type="submit" class="btn btn-primary btm-sm">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<!-- <script>
    let cardIndex = 1; // Start from 1 because first card is static

    document.getElementById('add-card-btn').addEventListener('click', function() {
        const container = document.getElementById('card-container');

        const cardHTML = `
            <div class="col card-item" data-index="${cardIndex}">
                <div class="card h-100 p-3 position-relative">
                    <div class="form-group mb-3">
                        <label class="text-uppercase text-secondary">Card Header</label>
                        <input type="text" name="cards[${cardIndex}][header]" class="form-control" placeholder="Header Title" />
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-uppercase text-secondary">Description</label>
                        <textarea name="cards[${cardIndex}][description]" class="form-control" rows="3" placeholder="Description..."></textarea>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-danger btn-sm remove-card-btn">Remove</button>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', cardHTML);
        cardIndex++;
    });

    // Remove Card Functionality
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-card-btn')) {
            event.target.closest('.card-item').remove();
        }
    });
</script> -->

<script>
    let sectionIndex = 0;
    let ckeditors = {};  // Store CKEditor instances

    document.getElementById('add-section-btn').addEventListener('click', function() {
        const container = document.getElementById('sections-container');
        const titleEditorId = `section-title-${sectionIndex}`;

        const sectionHTML = `
            <div class="additional-section mb-5 border p-3 position-relative" data-section-index="${sectionIndex}">
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-3 remove-section-btn">Remove Section</button>
                <div class="row mx-3 mb-4">
                    <div class="col-12">
                        <h5 class="mb-3 mt-3 text-center">Additional Section</h5>
                        <div class="form-group">
                            <label class="text-uppercase text-secondary">Title</label>
                            <textarea name="sections[${sectionIndex}][title]" id="${titleEditorId}" class="form-control" rows="3"></textarea>
                        </div>

                        <div id="card-container-${sectionIndex}" class="row row-cols-1 row-cols-md-2 g-4">
                            <!-- First default card -->
                            <div class="col card-item" data-index="0">
                                <div class="card h-100 p-3 position-relative">
                                    <div class="form-group mb-3">
                                        <label class="text-uppercase text-secondary">Card Header</label>
                                        <input type="text" name="sections[${sectionIndex}][cards][0][header]" class="form-control" placeholder="Header Title">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="text-uppercase text-secondary">Description</label>
                                        <textarea name="sections[${sectionIndex}][cards][0][description]" class="form-control" rows="3" placeholder="Description..."></textarea>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button" class="btn btn-danger btn-sm remove-card-btn">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-primary add-card-btn" data-section-index="${sectionIndex}">Add Card</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', sectionHTML);

        // Initialize CKEditor for the newly added Title textarea
        ClassicEditor
            .create(document.getElementById(titleEditorId))
            .then(editor => {
                ckeditors[titleEditorId] = editor;
            })
            .catch(error => {
                console.error(error);
            });

        sectionIndex++;
    });

    // Add Card inside specific section
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('add-card-btn')) {
            const sectionIdx = event.target.getAttribute('data-section-index');
            const cardContainer = document.getElementById(`card-container-${sectionIdx}`);
            const currentCardCount = cardContainer.querySelectorAll('.card-item').length;

            const cardHTML = `
                <div class="col card-item" data-index="${currentCardCount}">
                    <div class="card h-100 p-3 position-relative">
                        <div class="form-group mb-3">
                            <label class="text-uppercase text-secondary">Card Header</label>
                            <input type="text" name="sections[${sectionIdx}][cards][${currentCardCount}][header]" class="form-control" placeholder="Header Title">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-uppercase text-secondary">Description</label>
                            <textarea name="sections[${sectionIdx}][cards][${currentCardCount}][description]" class="form-control" rows="3" placeholder="Description..."></textarea>
                        </div>
                        <div class="d-flex justify-content-end mt-2">
                            <button type="button" class="btn btn-danger btn-sm remove-card-btn">Remove</button>
                        </div>
                    </div>
                </div>
            `;
            cardContainer.insertAdjacentHTML('beforeend', cardHTML);
        }

        // Remove Card
        if (event.target.classList.contains('remove-card-btn')) {
            event.target.closest('.card-item').remove();
        }

        // Remove Section (destroy CKEditor instance)
        if (event.target.classList.contains('remove-section-btn')) {
            const sectionDiv = event.target.closest('.additional-section');
            const sectionTextarea = sectionDiv.querySelector('textarea');
            const editorId = sectionTextarea.getAttribute('id');

            // Destroy CKEditor instance before removing DOM
            if (ckeditors[editorId]) {
                ckeditors[editorId].destroy()
                    .then(() => {
                        delete ckeditors[editorId];
                        sectionDiv.remove();
                    })
                    .catch(error => {
                        console.error('Error destroying editor:', error);
                    });
            } else {
                sectionDiv.remove();
            }
        }
    });
</script>






<!-- Load CKEditor 5 from CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> -->

<script>
    ClassicEditor
        .create(document.querySelector('#title'), {

        })
        .then(editor => {
            editor.ui.view.editable.element.style.height = '60px';
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection --}}