{{-- @extends('Admin.layouts.master')
@section('content')
@section('source', 'Contact')
@section('page-title', 'Edit Contact')
<div class="container">
    <form action="" method="POST" enctype="multipart/form-data">{{-- {{route('admin.insert_contact')}} --}}
    {{-- @csrf
        
      <div class="card">
        <div class="form-group">
            <label for="f_name">First Name</label>
            <input type="text" class="form-control" id="f_name" name="f_name" value="{{$contact_data->f_name}}" required >

        </div>
        @error('f_name')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
         <div class="form-group">
            <label for="f_name">Last Name</label>
            <input type="text" class="form-control" id="l_name" name="l_name" value="{{$contact_data->l_name}}" required>
         </div>
         @error('l_name')
             <div class="alert alert-danger">{{$message}}</div>
         @enderror
        <div class="form-group">
            <label for="l_name">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{$contact_data->email}}" required>

        </div>
        @error('email')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
     
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{$contact_data->phone}}" >

        </div>
        @error('phone')
             <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <div class="form-group">
        <label>Services:</label><br>
        @foreach($service_data as $service)
        <input type="checkbox" name="services[]" value="{{$service->name}}"> {{$service->name}}<br> --}} --}}
        {{-- <input type="checkbox" name="services[]" value="Web Design"> Web Design<br>
        <input type="checkbox" name="services[]" value="Marketing"> Marketing<br> --}}
        {{-- @endforeach

        </div>
        @error('services[]')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
          <div>
            <select name="status" class="form-select" style="width: 150px;" required>
                            <option value="" hidden selected>select status</option>
                            @foreach($status_data as $status)
                               
                                <option value="{{ $status->status }}" >
                                    {{ $status->status_id }} - {{ $status->status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
            @error('status')
                                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
        <div class="form-group">
            <label for="message">Message</label>
            <input type="text" class="form-control" id="message" name="message" value="{{$contact_data->message}}" >

        </div>
       @error('message')
             <div class="alert alert-danger">{{$message}}</div>
        @enderror
        
        </div>
         <button type="submit" class="btn btn-primary">submit</button>
      </form>
      
</div>
        
@endsection --}}