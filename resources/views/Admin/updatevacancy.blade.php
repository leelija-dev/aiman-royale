{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

 @extends('Admin.layouts.master')
 @section('source','Careers')
 @section('page-title','Update Vacancy')
  @section('content') 
  <div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="cards px-0 pt-0 pb-2">
                       
                <form action={{route('updatevacancy', $user->id) }} method="POST" enctype="multipart/form-data">
                    @csrf
                      <div class="row px-4">
                            <div class="col-md-8">

                                <div class="form-group " >
                                    <label for="description" class="text-uppercase text-secondary">Job Description</label>
                                    <textarea type="text" name="description" id="description" placeholder="Enter job description"
                                            class="form-control" rows="13" style="height:400px">{{$user->description}}</textarea>
                                </div>
                            </div>
                            @error('description')
                                <div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                </div>
                            @enderror
                       
                   <div class="col-md-4">
                            <div class="form-group">
                                <label for="service" class="text-uppercase text-secondary">Job Role</label>
                                <input type="text" name="job_role" id="meta_title" value={{$user->job_role}}
                                    class="form-control" />
                            </div>
                            @error('job_role')
                                <div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                </div>
                            @enderror
                            <div class="form-group">
                                <label for="service" class="text-uppercase text-secondary">Exprience</label>
                                <input type="textarea" name="exprience" id="slug" value={{$user->exprience}}
                                    class="form-control" />
                            </div>
                            @error('exprience')
                                <div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                </div>
                            @enderror
                            
                            <div class="form-group">
                                <label for="service" class="text-uppercase text-secondary">Location</label>
                                <input type="text" name="location" id="slug" value={{$user->location}}
                                    class="form-control" />
                            </div>
                            @error('location')
                                <div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                </div>
                            @enderror
                           <div class="form-group">
                            <label for="skills" class="text-uppercase text-secondary">Skills</label>
                            <select id="skills" name="skills[]" multiple="multiple" class="form-control select2" >
                                <option value="">{{$user->skills}}</option>
                                <option value="PHP">PHP</option>
                                <option value="PYTHON">PYTHON</option>
                                <option value="JAVA">JAVA</option>
                                <option value="C">C</option>
                                <option value="C++">C++</option>
                                
   
                            </select>
                        </div>
                        @error('skills')
                            <div>
                                <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                </span>
                            </div>
                        @enderror
                        <div class="form-group mt-3">
                                <label for="department" class="text-uppercase text-secondary">Department</label>
                                <select id="department" name="department" class="form-control">
                                    <option vaue="" hidden selected>{{$user->department}}</option>
                                    <option value="Web Devloper">Web Devloper</option>
                                    <option value="SEO">SEO</option>
                                    <option value="Content Writer">Content Writer</option>
                                    <option value="HR">HR</option>
                                </select>
                            </div>
                            @error('department')
                                <div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                </div>
                            @enderror
                            <div class="form-group mt-3">
                             <label for="stauts" class="text-uppercase text-secondary">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option vaue=""hidden selected>{{$user->status}}</option>
                                    <option value="active">Active</option>
                                    <option value="close">Close</option>
                                    <option value="draft">Draft</option>
                                  
                                </select>
                            </div>
                            @error('status')
                                <div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                </div>
                            @enderror
                        <button type="submit" class="btn btn-secondary btn-sm">Save</button>
                        
                    </div>
                </div>
                </form>

            
        
    </div>
    </div>
    </div>
  </div>
    <style>
    .ck-editor__editable_inline {
        min-height:410px !important;
        max-height:410px!important;
        overflow-y: auto;
    }
     </style>                           <!-- Load CKEditor 5 from CDN -->
            <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

          <script>
                ClassicEditor
                    .create(document.querySelector('#description'))
                    .catch(error => {
                        console.error(error);
                    });
                    $(document).ready(function() {
                $('#skills').select2({
                    tags: true,
                    
                    placeholder: 'Select skills',
                    width: '100%',
                    tokenSeparators: [',']
                });
            });
       
            </script>
                        
        
                       
@endsection
 --}}
