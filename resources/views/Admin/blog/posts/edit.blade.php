{{-- @extends('Admin.layouts.master')
@section('title','Edit Post')

@section('content')
<div class="container-fluid py-4">
  <div class="card">
    <div class="p-3">
      <form action="{{ route('admin.blog.posts.update', $post) }}" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <div class="row g-3">
          <div class="col-md-8">
            <div class="mb-3">

              <label class="form-label">Title</label>
              <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
              @error('title')
              <small class="text-danger">{{ $message }}</small>
              @enderror


            </div>

            <div class="mb-3" style="height : 80%">
              <label class="form-label">Content</label>
              <textarea id="summernote" name="content" class="form-control" rows="10">{{ old('content', $post->content) }}</textarea>
              @error('content')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3 d-flex gap-2">
              <div class="w-100">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                  <option value="draft" {{ old('status', $post->status)==='draft'?'selected':'' }}>Draft</option>
                  <option value="published" {{ old('status', $post->status)==='published'?'selected':'' }}>Published</option>
                </select>
                @error('status')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>


              <div class="d-flex align-items-end">

                <button class="btn btn-primary mb-0">Update</button>

              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Slug</label>
              <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug) }}" required>
              @error('slug')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Featured Image</label>
              @if($post->featured_image)
              <div class="mb-2"><img src="{{ asset('storage/'.$post->featured_image) }}" alt="" class="img-fluid rounded"></div>
              @endif
              <input type="file" name="featured_image" class="form-control" accept="image/*">
              @error('featured_image')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Featured Image Alt</label>
              <input type="text" name="image_alt" class="form-control" value="{{ old('image_alt', $post->image_alt) }}" required>
              @error('image_alt')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Excerpt</label>
              <textarea name="excerpt" rows="3" class="form-control">{{ old('excerpt', $post->excerpt) }}</textarea>
              @error('excerpt')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <!-- <div class="mb-3">
              <label class="form-label">OG Image</label>
              @if($post->og_image)
                <div class="mb-2"><img src="{{ asset('storage/'.$post->og_image) }}" alt="" class="img-fluid rounded"></div>
              @endif
              <input type="file" name="og_image" class="form-control" accept="image/*">
            </div> -->
            <!-- <div class="mb-3">
              <label class="form-label">Categories</label>
              <select name="categories[]" class="select5 form-select" multiple size="6">
                @php $selectedCats = old('categories', $post->categories->pluck('id')->toArray()); @endphp
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCats) ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
              </select>
            </div> -->
            <div class="mb-3">
              <label class="form-label">Categories</label>
              <select name="categories[]" class="select5 form-control" multiple="multiple" data-placeholder="Select categories..." required>
                @php $selectedCategories = old('categories', $post->categories->pluck('id')->toArray()); @endphp
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCategories) ? 'selected' : '' }}>
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
              <select name="tags[]" class="select23 form-control" multiple="multiple" data-placeholder="Select tags..." required>
                @php $selectedTags = old('tags', $post->tags->pluck('id')->toArray()); @endphp
                @foreach($tags as $tag)
                <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>{{ $tag->name }}</option>
                @endforeach
              </select>
              @error('tags')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <!-- <div class="mb-3">
              <label class="form-label">Tags</label>
              <select name="tags[]" class="form-select" multiple size="6">
                @php $selectedTags = old('tags', $post->tags->pluck('id')->toArray()); @endphp
                @foreach($tags as $tag)
                <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>{{ $tag->name }}</option>
                @endforeach
              </select>
            </div> -->
            <div class="mb-3">
              <label class="form-label">Keywords</label>
              <select class="form-control select-keywords" id="keywords" name="keywords[]" multiple required>
                @php $selectedKeywords = old('keywords', $post->keywords->pluck('id')->toArray()); @endphp
                @foreach($post->keywords as $keyword)
                <option value="{{ $keyword->id }}" selected>{{ $keyword->name }}</option>
                @endforeach
              </select>
              @error('keywords')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Meta Title</label>
              <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $post->meta_title) }}" required>
              @error('meta_title')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <!-- <div class="mb-3">
              <label class="form-label">Schema</label>
              <input type="text" name="schema" class="form-control" value="{{ old('schema', $post->schema) }}">
            </div> -->
            <div class="mb-3">
              <label class="form-label">Meta Description</label>
              <textarea name="meta_description" class="form-control" rows="3" required>{{ old('meta_description', $post->meta_description) }}</textarea>
              @error('meta_description')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Schema</label>
              <textarea name="schema" class="form-control" rows="5">{{ old('schema', $post->schema) }}</textarea>
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
<script src="{{ asset('/js/select-2.min.js') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const statusSelect = form.querySelector('select[name="status"]');

    // Get all form fields that should be conditionally required
    const conditionallyRequiredFields = Array.from(form.elements).filter(el => {
      return el.name &&
        el.name !== 'status' &&
        el.name !== '_token' &&
        el.name !== '_method' &&
        el.name !== 'featured_image' &&
        el.type !== 'hidden' &&
        !el.name.includes('_method');
    });

    // Function to toggle required attribute based on status
    function toggleRequiredFields() {
      const isPublished = statusSelect.value === 'published';

      conditionallyRequiredFields.forEach(field => {
        if (field.name !== 'status') {
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
<script>
  // Function to initialize Summernote
  function initializeSummernote() {
    if (typeof $ === 'function' && $.fn.summernote) {
      // Update the content container height
      $('.note-editor').parent().css('height', 'calc(100vh - 200px)');

      $('#summernote').summernote({
        placeholder: 'Write post content...',
        height: '100%',
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

  // Start initialization when document is ready
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof $ === 'undefined') {
      const script = document.createElement('script');
      script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
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

  // Initialize keywords select2 after DOM is fully loaded
  $(document).ready(function() {
    $('.select-keywords').select2({
      placeholder: "Select or type keywords...",
      allowClear: true,
      tags: true,
      tokenSeparators: [',', ' '],
      createTag: function(params) {
        var term = $.trim(params.term);
        if (term === '') {
          return null;
        }
        return {
          id: term, // temp ID (will be replaced by DB ID)
          text: term,
          newKeyword: true // custom flag
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
  }); // End of document.ready
</script>

<script>
  $(document).ready(function() {
    $('.select5').select2({
      placeholder: "Select categories...",
      allowClear: true,
      width: '100%',
      // This ensures the selected values are properly displayed
      templateSelection: function(data) {
        return data.text;
      }
    });

    // Manually trigger change to ensure selected values are displayed
    $('.select5').trigger('change');
  });
</script>
<script>
  $('.select23').select2({
    placeholder: "Select tags...",
    allowClear: true,
    width: '100%',
    tags: true,
    tokenSeparators: [',', ' '],
    templateSelection: function(data) {
      return data.text;
    },
    createTag: function(params) {
      var term = $.trim(params.term);
      if (term === '') {
        return null;
      }
      return {
        id: term, // temp ID (will be replaced by DB ID)
        text: term,
        newTag: true // custom flag
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
@endpush --}}