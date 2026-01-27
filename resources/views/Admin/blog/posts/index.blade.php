{{-- @extends('Admin.layouts.master')

@section('title','Blog Posts')

@section('content')
<div class="container-fluid py-4">




  <div class="card">
    <div class="col-12 d-flex justify-content-betweeen pt-3 px-3 ">

      <div class="col-6">
        <form method="get" class=" d-flex gap-2">
          <input type="text" class="form-control w-auto" name="search" value="{{ request('search') }}" placeholder="Search...">
          <button class="btn btn-outline-secondary mb-0">Search</button>
        </form>
      </div>
      <div class="col-6 text-end"><a href="{{ route('admin.blog.posts.create') }}" class="btn btn-primary mb-0">Create Post</a></div>
    </div>
    <div class="table-responsive ">
      <table class="table align-items-center mb-0">
        <thead>
          <tr>
            <th class="px-3">Title</th>
            <th class="px-3">Status</th>
            <th class="px-3">Published</th>
            <th class="px-3">Author</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($posts as $post)
          <tr>
            <td class="px-3">{{ $post->title }}</td>
            <td class="px-3"><span class="badge bg-{{ $post->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($post->status) }}</span></td>
            <td class="px-3">{{ optional($post->published_at)->format('Y-m-d') }}</td>
            <td class="px-3">{{ $post->author?->fname }} {{ $post->author?->lname }}</td>
            <td class="d-flex gap-2 justify-content-center">
              <a class="" href="{{ route('admin.blog.posts.edit', $post) }}"><i class="fa-regular fa-pen-to-square"></i></a>
              <form id="deleteForm-{{ $post->id }}" method="post" action="{{ route('admin.blog.posts.destroy', $post) }}">
                @csrf
                @method('DELETE')
                <button type="button" class="bg-transparent text-danger border-0" onclick="confirmDelete({{ $post->id }})">
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center">No posts found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer bg-white border-0 p-4">
      {{ $posts->links('pagination::bootstrap-5') }}
    </div>
  </div>
</div>
@endsection


@section('scripts')
<script>
  function confirmDelete(postId) {
    Swal.fire({
      title: 'Are you sure?',
      text: "This action cannot be undone!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('deleteForm-' + postId).submit();
      }
    });
  }
</script>

@endsection --}}