{{-- @extends('Admin.layouts.master')

@section('title','Create Post')

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const statusSelect = form.querySelector('select[name="status"]');
        
        // Get all form fields that should be conditionally required
        const conditionallyRequiredFields = Array.from(form.elements).filter(el => 
            el.name && 
            el.name !== 'status' && 
            el.name !== '_token' &&
            el.type !== 'hidden'
        );
        
        // Function to toggle required attribute based on status
        function toggleRequiredFields() {
            const isPublished = statusSelect.value === 'published';
            
            conditionallyRequiredFields.forEach(field => {
                field.required = isPublished;
                
                // Toggle error message visibility
                const errorElement = field.closest('.mb-3')?.querySelector('.text-danger');
                if (errorElement) {
                    errorElement.style.display = isPublished ? 'block' : 'none';
                }
                
                // Toggle visual required indicator if any
                const label = field.closest('.mb-3')?.querySelector('label');
                if (label) {
                    if (isPublished) {
                        label.classList.add('required');
                    } else {
                        label.classList.remove('required');
                    }
                }
            });
        }
        
        // Initial setup
        toggleRequiredFields();
        
        // Add change event listener to status select
        statusSelect.addEventListener('change', toggleRequiredFields);
        
        // Handle form submission
        form.addEventListener('submit', function(e) {
            // Only validate if status is published
            if (statusSelect.value === 'published') {
                // Make all fields required before validation
                conditionallyRequiredFields.forEach(field => field.required = true);
                
                // Reset custom validity
                conditionallyRequiredFields.forEach(field => field.setCustomValidity(''));
                
                // Trigger validation
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            } else {
                // For drafts, ensure no fields are required
                conditionallyRequiredFields.forEach(field => field.required = false);
            }
            
            form.classList.add('was-validated');
        }, false);
    });
</script>
@endpush

@section('content')
<div class="container-fluid py-4">
  <div class="card">
    <div class="p-3">
      <form id="blogPost" action="{{ route('admin.blog.posts.store') }}" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="row g-3">
          <div class="col-md-8">
            <div class="mb-3">
              <label class="form-label">Title</label>
              <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
              <div class="invalid-feedback">Title can not be blank!</div>
              @error('title')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <!-- <div class="mb-3">
              <label class="form-label">Slug (optional)</label>
              <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
            </div> -->

            <div class="mb-3" style="height : 80%">
              <label class="form-label">Content</label>
              <textarea id="summernote" name="content" class="form-control" rows="10" required>{{ old('content') }}</textarea>
              <div class="invalid-feedback">Content can not be blank!</div>
               @error('content')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3 d-flex gap-2 ">
              <div class="w-100">

                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                  <option value="draft" {{ old('status')==='draft'?'selected':'' }}>Draft</option>
                  <option value="published" {{ old('status')==='published'?'selected':'' }}>Published</option>
                </select>
                @error('status')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class=" d-flex align-items-end">
                <button class="btn btn-primary mb-0">Save</button>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Slug</label>
              <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
               @error('slug')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <!-- <div class="mb-3">
              <label class="form-label">Published At</label>
              <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at') }}">
            </div> -->
            <div class="mb-3">
              <label class="form-label">Featured Image</label>
              <input type="file" name="featured_image" class="form-control" accept="image/*">
               @error('featured_image')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Featured Image Alt</label>
              <input type="text" name="image_alt" class="form-control" value="{{ old('image_alt') }}">
              @error('image_alt')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Excerpt</label>
              <textarea name="excerpt" rows="3" class="form-control">{{ old('excerpt') }}</textarea>
               @error('excerpt')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <!-- <div class="mb-3">
              <label class="form-label">OG Image</label>
              <input type="file" name="og_image" class="form-control" accept="image/*">
            </div> -->
            <!-- <div class="mb-3">
              <label class="form-label">Categories</label>
              <select name="categories[]" class="form-multiselect" multiple data-placeholder="Select categories...">
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" {{ in_array($cat->id, old('categories', [])) ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
              </select>
            </div> -->
            <div class="mb-3">
              <label class="form-label">Categories</label>
              <select name="categories[]" class="select5 form-control" multiple="multiple" data-placeholder="Select categories...">
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ in_array($cat->id, old('categories', [])) ? 'selected' : '' }}>
                  {{ $cat->name }}
                </option>
                @endforeach
              </select>
               @error('categories')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Tags</label>
              <select name="tags[]" class="select23 form-control" multiple="multiple" data-placeholder="Select tags...">
                @foreach($tags as $tag)
                <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>{{ $tag->name }}</option>
                @endforeach
              </select>
               @error('tags')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- <div class="mb-3">
              <label class="form-label">Tags</label>
              <select name="tags[]" class="form-multiselect" multiple data-placeholder="Select tags...">
                @foreach($tags as $tag)
                <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>{{ $tag->name }}</option>
                @endforeach
              </select>
            </div> -->



            <div class="mb-3">
              <label class="form-label">Meta Title</label>
              <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
               @error('meta_title')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Meta Description</label>
              <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description') }}</textarea>
             @error('meta_description')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Keywords</label>
              <select class="form-control select-keywords" id="keywords" name="keywords[]" multiple>
                <!-- @if(isset($post) && $post->keywords->count() > 0) -->
                @foreach(keywords as $keyword)
                 <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>{{ $tag->name }}</option>
                <option value="{{ $keyword->id }}" {{ in_array($keyword->id, old('keywords', [])) ? 'selected' : '' }}>{{ $keyword->name }}</option>
                @endforeach
                <!-- @endif -->
              </select>
               @error('keywords')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Schema</label>
              <textarea name="schema" class="form-control" rows="5">{{ old('schema') }}</textarea>
              @error('schema')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

          
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
  .select2-container--default .select2-selection--multiple {
    padding: 0.5rem 0.75rem;
    border: solid #c9c8c8 1px;
    border-radius: 8px;
  }

  .select2-container .select2-search--inline .select2-search__field {
    height: 24px;
  }

  /* Main layout styles */
  html,
  body {
    height: 100%;
    margin: 0;
  }

  .card {
    min-height: calc(100vh - 2rem);
    height: 100%;
  }

  /* Content section */
  #summernote {
    min-height: 100%;
    height: 100%;
  }

  .note-editor {
    min-height: 100% !important;
    height: 100% !important;
    display: flex;
    flex-direction: column;
  }

  .note-editing-area {
    flex: 1;
    position: relative;
    min-height: 300px;
  }

  .note-editable {
    min-height: 100% !important;
    height: 100% !important;
  }
</style>
@endpush

@push('scripts')
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- Select2 JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<!-- <script src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script> -->
<script src="{{ asset('/js/select-2.min.js') }}"></script>

<script>
  // Function to initialize Summernote
  function initializeSummernote() {
    if (typeof $ === 'function' && $.fn.summernote) {
      // Sync title with meta title
      $('input[name="title"]').on('input', function() {
        $('input[name="meta_title"]').val($(this).val());
      });

      // Sync excerpt with meta description
      $('textarea[name="excerpt"]').on('input', function() {
        $('textarea[name="meta_description"]').val($(this).val());
      });

      $('#summernote').summernote({
        placeholder: 'Write post content...',
        height: 400,
        dialogsInBody: true,
        callbacks: {
          onImageUpload: function(files) {
            uploadImage(files[0], $(this));
          }
        },
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'clear', 'strikethrough', 'superscript', 'subscript']],
          ['fontname', ['fontname']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video', 'hr']],
          ['view', ['fullscreen', 'codeview', 'help']],
          ['misc', ['undo', 'redo']]
        ]
      });
    } else {
      setTimeout(initializeSummernote, 100);
    }
  }

  // Function to handle image upload
  function uploadImage(file, editor) {
    const data = new FormData();
    data.append('image', file);
    data.append('_token', '{{ csrf_token() }}');

    $.ajax({
      url: '{{ route("summernote.upload") }}',
      method: 'POST',
      data: data,
      processData: false,
      contentType: false,
      success: function(response) {
        if (response.url) {
          const image = $('<img>').attr('src', response.url);
          $(editor).summernote('insertNode', image[0]);
        } else {
          console.error('No URL returned from server');
        }
      },
      error: function(xhr, status, error) {
        console.error('Error uploading image:', error);
        alert('Error uploading image: ' + (xhr.responseJSON?.error || 'Unknown error'));
      }
    });
  }

  // Function to convert string to slug
  function stringToSlug(str) {
    return str.toString().toLowerCase()
      .replace(/\s+/g, '-') // Replace spaces with -
      .replace(/[^\w\-]+/g, '') // Remove all non-word chars
      .replace(/\-\-+/g, '-') // Replace multiple - with single -
      .replace(/^-+/, '') // Trim - from start of text
      .replace(/-+$/, ''); // Trim - from end of text
  }

  // Auto-generate slug from title
  document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.querySelector('input[name="title"]');
    const slugInput = document.querySelector('input[name="slug"]');

    // Only auto-generate slug if slug field is empty or matches previous title
    let previousTitle = titleInput.value;

    titleInput.addEventListener('input', function() {
      const slugValue = stringToSlug(this.value);
      // Only update if slug is empty or if it matches the previous title (meaning it was auto-generated)
      if (!slugInput.value || slugInput.value === stringToSlug(previousTitle)) {
        slugInput.value = slugValue;
      }
      previousTitle = this.value;
    });

    // Load Summernote after setting up slug generation
    if (typeof $ === 'undefined') {
      const script = document.createElement('script');
      script.onload = loadSummernote;
      document.head.appendChild(script);
    } else {
      loadSummernote();
    }
  });

  function loadSummernote() {
    if (typeof $.fn.summernote === 'undefined') {
      const script = document.createElement('script');
      script.src = 'https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js';
      script.onload = initializeSummernote;
      document.head.appendChild(script);
    } else {
      initializeSummernote();
    }
  }
</script>

<script>
  $(document).ready(function() {
    $('.select5').select2({
      placeholder: "Select categories...",
      allowClear: true
    });
  });
</script>

<script>
  $('.select23').select2({
    placeholder: "Type tag names, separate with comma...",
    allowClear: true,
    tags: true,
    tokenSeparators: [','], // Only use comma as separator
    createTag: function(params) {
      var term = params.term.trim();
      if (term === '') {
        return null;
      }
      return {
        id: term.replace(/,/g, ''), // Remove any commas from the ID
        text: term,
        newTag: true
      };
    }
  }).on('select2:select', function(e) {
    var $select = $(this);
    var data = e.params.data;

    if (data.newTag) {
      // Store the current value to restore selection after removal
      var currentValues = $select.val() || [];

      // Remove the temporary tag
      currentValues = currentValues.filter(function(val) {
        return val !== data.id;
      });
      $select.val(currentValues).trigger('change');

      // send AJAX to store new tag
      $.ajax({
        url: "{{ route('admin.blog.tags.stores') }}",
        type: "POST",
        data: {
          name: data.text,
          _token: "{{ csrf_token() }}"
        },
        success: function(response) {
          // Add the new tag from the server
          var newOption = new Option(response.text, response.id, true, true);
          $select.append(newOption).trigger('change');
        },
        error: function(xhr) {
          console.error('Error creating tag:', xhr.responseText);
          // Re-add the original tag if the request fails
          currentValues.push(data.id);
          $select.val(currentValues).trigger('change');
        }
      });
    }
  });
</script>

<script>
  // Keywords select2 initialization
  $('.select-keywords').select2({
    placeholder: "Search keywords",
    allowClear: true,
    tags: true,
    tokenSeparators: [','], // Only use comma as separator
    createTag: function(params) {
      var term = params.term.trim();
      if (term === '') {
        return null;
      }
      return {
        id: term.replace(/,/g, ''), // Remove any commas from the ID
        text: term,
        newKeyword: true
      };
    },
    ajax: {
      url: "{{ route('admin.blog.keywords.search') }}",
      type: 'GET',
      dataType: 'json',
      delay: 250,
      data: function(params) {
        return {
          q: params.term, // search term
          page: params.page || 1
        };
      },
      processResults: function(data) {
        return {
          results: data.results,
          pagination: {
            more: false
          }
        };
      },
      cache: true
    },
    minimumInputLength: 0, // Show results on click
    // Load initial data on open
    initSelection: function(element, callback) {
      var data = [];
      $(element.val()).each(function() {
        data.push({
          id: this,
          text: this
        });
      });
      callback(data);
    },
    // Show all options when the dropdown is opened
    dropdownCssClass: 'keywords-dropdown'
  }).on('select2:select', function(e) {
    var $select = $(this);
    var data = e.params.data;

    if (data.newKeyword) {
      // Store the current value to restore selection after removal
      var currentValues = $select.val() || [];

      // Remove the temporary keyword
      currentValues = currentValues.filter(function(val) {
        return val !== data.id;
      });
      $select.val(currentValues).trigger('change');

      // Send AJAX to store new keyword
      $.ajax({
        url: "{{ route('admin.blog.keywords.store') }}",
        type: "POST",
        data: {
          name: data.text,
          _token: "{{ csrf_token() }}"
        },
        success: function(response) {
          // Add the new keyword from the server
          var newOption = new Option(response.text, response.id, true, true);
          $select.append(newOption).trigger('change');
        },
        error: function(xhr) {
          console.error('Error creating keyword:', xhr.responseText);
          // Re-add the original keyword if the request fails
          currentValues.push(data.id);
          $select.val(currentValues).trigger('change');
        }
      });
    }
  });
</script>

<!-- <script>
  $(document).ready(function() {
    $('.select23').select2({
      placeholder: "Select tags...",
      allowClear: true
    });
  });
</script> -->
{{-- <script>
(function () {
    'use strict'
    const form = document.getElementById('blogPost');
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
})();
</script> --}}

@endpush --}}