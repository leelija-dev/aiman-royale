{{-- @extends('Admin.layouts.master')
@section('source','CMS')
@section('page-title','Add Page')
@section('content')


<div id="create-page" class="mt-4 mx-3">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">


            </div>
            <div class="cards-body px-0 pt-0 pb-2">

                <form action="{{ route('admin.page.update', $page->page_id ?? 0) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row px-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service">Service Page</label>
                                <select name="service" id="service" class="form-control">
                                    <option value="">-- Select Service --</option>
                                    @foreach ($services as $service)
                                    @php
                                    // true if SOME other page (not the one we’re editing) already uses this service_id
                                    $isUsedBySomeoneElse = $allpage->contains(function ($p) use ($service, $page) {
                                    return $p->service_id === $service['id'] // same service
                                    && $p->page_id !== $page->page_id; // but a different page
                                    });

                                    // true if this is the service attached to the page we’re editing
                                    $isSelected = (old('service', $page->service_id) == $service['id']);
                                    @endphp

                                    <option value="{{ $service['id'] }}"
                                        {{ $isSelected ? 'selected' : '' }}
                                        {{ $isUsedBySomeoneElse ? 'disabled' : '' }}>
                                        {{ $service['name'] }}
                                        @if ($isUsedBySomeoneElse)
                                        (Already Used)
                                        @endif
                                    </option>
                                    @endforeach
                                 
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="service">Meta Title</label>
                                <input type="text" name="meta_title" id="meta_title" placeholder="Regular" value="{{$page->meta_title}}"
                                    class="form-control" />
                            </div>
                           
                            <div class="form-group">
                                <label for="seo-url" class="text-uppercase text-secondary  ">Schema</label>
                                <input type="text" name="schema" id="schema" value="{{$page->schema}}" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="meta_description" class="text-uppercase text-secondary  ">Meta Description </label>
                                <textarea class="form-control" name="meta_description" id="meta_description"
                                    rows="2">{{$page->meta_description}}</textarea>
                            </div>



                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seo-url" class="text-uppercase text-secondary  ">Meta Keyword </label>
                                <input type="text" name="meta_keyword" id="meta_keyword" value="{{$page->meta_keyword}}" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="seo-url" class="text-uppercase text-secondary  ">Meta Tags </label>
                                <input type="text" name="meta_tags" id="meta_tags" value="{{$page->meta_tags}}" class="form-control" />
                            </div>

                         
                            {{-- <div>
                                <input type="file" class="dropify" name="service-icon"
                                    data-default-file="" data-max-file-size="2M"
                                    data-allowed-file-extensions="jpg jpeg png" data-height="200" />
                            </div> --}}
                           



                            <div class="form-group">
                                <label for="category" class="text-uppercase text-secondary  ">Status </label>
                                <select class="form-control" id="slug" name="status" required>
                                    <option value="1" {{ $page->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="2" {{ $page->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                        </div>
                    </div>
                   

                 <div id="sections-container">
    @foreach($components as $index => $comp)
        @php
            $cards = json_decode($comp->cards_data ?? '[]', true);
        @endphp
        <div class="additional-section mb-5 border p-3 position-relative" data-section-index="{{ $index }}">
            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-3 remove-section-btn" data-component-id="{{ $comp->id }}">Remove Section</button>
            <div class="row mx-3 mb-4">
                <div class="col-12">
                    <h5 class="mb-3 mt-3 text-center">Additional Section</h5>
                    <div class="form-group">
                        <label class="text-uppercase text-secondary">Title</label>
                        <textarea name="sections[{{ $index }}][title]" id="section-title-{{ $index }}" class="form-control" rows="3">{{ $comp->title }}</textarea>
                    </div>

                    <div id="card-container-{{ $index }}" class="row row-cols-1 row-cols-md-2 g-4">
                        @foreach($cards as $cardIndex => $card)
                            <div class="col card-item" data-index="{{ $cardIndex }}">
                                <div class="card h-100 p-3 position-relative">
                                    <div class="form-group mb-3">
                                        <label class="text-uppercase text-secondary">Card Header</label>
                                        <input type="text" name="sections[{{ $index }}][cards][{{ $cardIndex }}][header]" class="form-control" placeholder="Header Title" value="{{ $card['header'] }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="text-uppercase text-secondary">Description</label>
                                        <textarea name="sections[{{ $index }}][cards][{{ $cardIndex }}][description]" class="form-control" rows="3" placeholder="Description...">{{ $card['description'] }}</textarea>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button" class="btn btn-danger btn-sm remove-card-btn">Remove</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-primary add-card-btn" data-section-index="{{ $index }}">Add Card</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="mt-4 text-center">
    <button type="button" id="add-section-btn" class="btn btn-success">Add Section</button>
</div>


                    <!-- <div class="col-12 px-4 mt-2">
                                    <textarea class="form-control" id="summernote"
                                        name="service-description"></textarea>
                                </div> -->
                    <div class="d-flex justify-content-end me-4 mt-2">
                        <a href="{{route('admin.pages')}}" role="button" class="btn btn-secondary btm-sm me-4">Cancel</a>
                        <button type="submit" class="btn btn-primary btm-sm ">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>


<script>
    let sectionIndex = {{ count($components) }};  // Start from existing sections count
    let ckeditors = {}; // To track CKEditor instances

    // Initialize CKEditor for already existing sections on page load
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($components as $index => $comp)
            ClassicEditor
                .create(document.querySelector('#section-title-{{ $index }}'))
                .then(editor => {
                    ckeditors['section-title-{{ $index }}'] = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        @endforeach
    });

    // Add Section Button Click
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

        // Initialize CKEditor for the new section title
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

    // Event Delegation for dynamically added elements
    document.addEventListener('click', function(event) {

        // Add Card Button Click
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

        // Remove Card Button Click
        if (event.target.classList.contains('remove-card-btn')) {
            const cardItem = event.target.closest('.card-item');
            cardItem.remove();
        }

        // Remove Section Button Click (Destroy CKEditor too)
        if (event.target.classList.contains('remove-section-btn')) {
            const sectionDiv = event.target.closest('.additional-section');
            const textarea = sectionDiv.querySelector('textarea');
            const editorId = textarea.getAttribute('id');
            const componentId = event.target.getAttribute('data-component-id');
          if (componentId) {
            const deleteComponentUrl = "{{ route('admin.page.delete-component', ['id' => '__ID__']) }}".replace('__ID__', componentId);

            if (confirm('Are you sure you want to delete this section?')) {
                fetch(deleteComponentUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Success: Destroy CKEditor and remove DOM
                        if (ckeditors[editorId]) {
                            ckeditors[editorId].destroy()
                                .then(() => {
                                    delete ckeditors[editorId];
                                    sectionDiv.remove();
                                    alert('Section deleted successfully!');
                                })
                                .catch(error => {
                                    console.error('Error destroying editor:', error);
                                    sectionDiv.remove();
                                });
                        } else {
                            sectionDiv.remove();
                        }
                    } else {
                        alert('Failed to delete section from database.');
                    }
                })
                .catch(error => {
                    console.error('AJAX Delete failed:', error);
                    alert('An error occurred while deleting.');
                });
            }
        } else {
            // Newly Added Section (not saved yet)
            if (ckeditors[editorId]) {
                ckeditors[editorId].destroy()
                    .then(() => {
                        delete ckeditors[editorId];
                        sectionDiv.remove();
                    })
                    .catch(error => {
                        console.error('Error destroying editor:', error);
                        sectionDiv.remove();
                    });
            } else {
                sectionDiv.remove();
            }
        }
            // if (ckeditors[editorId]) {
            //     ckeditors[editorId].destroy()
            //         .then(() => {
            //             delete ckeditors[editorId];
            //             sectionDiv.remove();
            //         })
            //         .catch(error => {
            //             console.error('Error destroying editor:', error);
            //             sectionDiv.remove(); // Fallback removal
            //         });
            // } else {
            //     sectionDiv.remove();
            // }
        }
    });
</script>

@endsection --}}