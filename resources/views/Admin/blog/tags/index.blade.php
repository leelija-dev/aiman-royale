{{-- @extends('Admin.layouts.master')

@section('title','Tags')

@section('content')
<div class="container-fluid py-4">


  <div class="card">
    <div class="col-12 text-end px-3 pt-3">
      <a href="{{ route('admin.blog.tags.create') }}" class="btn btn-primary mb-0">Create Tag</a>
    </div>
    <div class="table-responsive">
      <table class="table align-items-center mb-0">
        <thead>
          <tr>
            <th class="px-3">Name</th>
            <th class="px-3">Slug</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($tags as $tag)
          <tr>
            <td class="px-3">{{ $tag->name }}</td>
            <td class="px-3">{{ $tag->slug }}</td>
            <td class="d-flex gap-2 justify-content-center">
              <a class="" href="{{ route('admin.blog.tags.edit', $tag) }}"><i class="fa-regular fa-pen-to-square"></i></a>
              <form id="deleteTag-{{ $tag->id }}" method="post" action="{{ route('admin.blog.tags.destroy', $tag) }}">
                @csrf
                @method('DELETE')
                <button type="button" class="bg-transparent text-danger border-0" onclick="confirmDeleteTag({{ $tag->id }})">
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="3" class="text-center">No tags found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      {{ $tags->links('pagination::bootstrap-5') }}
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function confirmDeleteTag(tagId) {
    Swal.fire({
      title: 'Are you sure?',
      text: "This tag will be permanently deleted!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('deleteTag-' + tagId).submit();
      }
    });
  }
</script>

@endsection --}}
