{{-- @extends('Admin.layouts.master')
@section('source', 'Contact')
@section('page-title', 'Contact Form')
@section('content')
<div class="container py-4 ">
    <div class="row">
        
        <div class="col-12">
        <div class="card mb-4">
       <div class="col-6">
        <form action="" method="POST" enctype="multipart/form-data"> {{--{{route('admin.insert-contact')}} --}}
        {{-- @csrf
        
      
        <div class="form-group">
            <label for="f_name">First Name</label>
            <input type="text" class="form-control" id="f_name" name="f_name" required>

        </div>
        @error('f_name')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
         <div class="form-group">
            <label for="f_name">Last Name</label>
            <input type="text" class="form-control" id="l_name" name="l_name" required>
         </div>
        @error('l_name')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <div class="form-group">
            <label for="l_name">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>

        </div>
        @error('email')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
      </div>
      <div class="col-6">
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" >

        </div>
        @error('phone')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <div class="form-group">
        <label>Services:</label><br>
        @foreach($data as $service)
            <input type="checkbox" name="services[]" value="{{$service->name}}"> {{$service->name}}<br> --}}
        {{-- <input type="checkbox" name="services[]" value="Web Design"> Web Design<br>
        <input type="checkbox" name="services[]" value="Marketing"> Marketing<br> --}}
        {{-- @endforeach
        </div>
        @error('services')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
       
        <div class="form-group">
            <label for="message">Message</label>
            <input type="text" class="form-control" id="message" name="message" >

        </div>
        @error('message')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
       
        
    </div>
           <button type="submit" class="btn btn-primary">submit</button>
      </form>
     
            </div>
          
</div>
         
@endsection --}} 