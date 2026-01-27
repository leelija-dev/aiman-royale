@extends('Admin.layouts.master')
@section('source', 'Permission')
@section('page-title', 'Add Permission')
@section('title')
{{config('app.name')}} - Add Permission
@endsection

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
            <div class="card px-0 pt-0 pb-2">

                <form action="{{route('admin.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row px-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service">Permission</label>
                                <input type="text" name="name" id="name" placeholder="Regular"
                                    class="form-control" />
                            </div>
                            <!-- <div class="form-group">
                                <label for="service">Slug</label>
                                <input type="text" name="slug" id="slug" placeholder="Regular"
                                    class="form-control" />
                            </div> -->

                            <!-- <div class="form-group">
                                <label for="category">Slug </label>
                                <select class="form-control" id="slug" name="category" required>

                                </select>
                            </div> -->
                            <!-- <div class="form-group">
                                <label for="meta_description">Meta Description: </label>
                                <textarea class="form-control" name="meta_description" id="meta_description"
                                    rows="2"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="page-title">Page Title: </label>
                                <input type="text" name="page_title" id="page_title" class="form-control" />
                            </div> -->




                        </div>

                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="seo-url">Meta Keyword: </label>
                                <input type="text" name="meta_keyword" id="meta_keyword" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="seo-url">Meta Tags: </label>
                                <input type="text" name="meta_tags" id="meta_tags" class="form-control" />
                            </div>

                           
                            <div>
                                <input type="file" class="dropify" name="service-icon"
                                    data-default-file="" data-max-file-size="2M"
                                    data-allowed-file-extensions="jpg jpeg png" data-height="200" />
                            </div>

                            <div class="form-group">
                                <label for="seo-url">Alt</label>
                                <input type="text" name="alt" id="alt" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="seo-url">Schema</label>
                                <input type="text" name="schema" id="schema" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="category">Status </label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>

                            
                    
                        </div> -->
                    </div>
                    <!-- <div class="col-12 px-4 mt-2">
                                    <textarea class="form-control" id="summernote"
                                        name="service-description"></textarea>
                                </div> -->
                    <div class="d-flex justify-content-evenly mt-2">
                        <a href="services.php" role="button" class="btn btn-secondary btm-sm">Cancel</a>
                        <button type="submit" class="btn btn-primary btm-sm">Add</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection