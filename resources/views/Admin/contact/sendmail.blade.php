{{-- @extends('Admin.layouts.master')
@section('title')
Leelija - Pages

@endsection

@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card row py-5 px-2">
            <div class="border rounded mx-auto col-md-12 col-lg-10">
                <div class="card-body">
                    <h4 class="card-title">Send Mail to {{@$contact->name}}</h4>
                    <form class="mail-form" action="{{ route('admin.sendmail.send', $contact->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="to-name" value="{{$contact->name}}">
                        <input type="hidden" name="to-email" value="{{$contact->email}}">

                        <div class="d-md-flex">

                                        <div class="form-group col-sm">
                                            <label for="toName">User Name</label>
                                            <p class="font-weight-bolder border-bottom pb-1 pl-1">{{$contact->f_name}} {{$contact->l_name}}
                                            </p>
                                        </div>
                                        <div class="form-group col-sm">
                                            <label for="userEmail">User Email</label>
                                            <p class="font-weight-bolder border-bottom pb-1 pl-1">
                                               {{$contact->email}}</p>
                                        </div>
                                    </div>
                        <div class="form-group">
                            <label for="mailSubject">Subject</label>
                            <input type="text" class="form-control" id="mailSubject" name="mail-subject">
                        </div>
                        <!-- <div class="form-group">
                                        <label for="mailMessage">Message</label>
                                        <textarea class="form-control" id="mailMessage" name="mailMessage"
                                            rows="20">< ?php echo "Dear ".$toName.",\r\n\n";?></textarea>
                                    </div> -->
                        <div class="form-group">
                            <label for="mailMessage">Message</label>
                            <textarea class="form-control" name="mailMessage" id="mailMessage"
                                required></textarea>
                        </div>
                        <!-- <div class="form-group">
                                        <label for="mail-format">Format</label>
                                        <select class="custom-select" id="mail-format" name="mail-format">
                                            <option value="0">Text</option>
                                            <option value="1">HTML</option>
                                        </select>
                                    </div> -->
                        <div class="d-flex justify-content-around justify-content-md-end">
                            <button class="btn btn-danger mr-2" onclick="history.back()">Cancel</button>
                           <button type="submit" class="btn btn-primary">Submit</button>


                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- content-wrapper ends -->

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var summernote = document.getElementById("mailMessage");
// alert(summernote);
        if (summernote) {
            $(summernote).summernote({
                height: "300px"
            });
        }
    });
</script>
@endsection --}}
