@extends('layouts.app')

    @section('title') Blog @endsection
    
    @section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin-assets/plugins/dropify/css/dropify.min.css') }}">
    @endsection

    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Blog</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Blog</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}

                    <li class="nav-item"><a class="btn btn-info" href="{{ route('blog.index') }}"><i class="fa fa-arrow-left me-2"></i>Back</a></li>
                </ul>
            </div>
        </div>
    </div>

    <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="section-body mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Basic Information</h3>
                            <div class="card-options ">
                                {{-- <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Name <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Blog Category <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <select class="form-control input-height" name="blog_category" required>
                                        <option value selected disabled>Select...</option>
                                        @foreach($blog_caregories as $blog_caregorie)
                                        <option value="{{ $blog_caregorie->id }}">{{ $blog_caregorie->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Sort Description</label>
                                <div class="col-md-9">
                                    <textarea rows="4" class="form-control no-resize summernote" placeholder="Enter Sort Description" name="sort_description">{{ old('sort_description') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Long Description</label>
                                <div class="col-md-9">
                                    <textarea rows="4" class="form-control no-resize summernote" placeholder="Enter Description" name="description">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Blog Image</h3>
                            <div class="card-options ">
                                {{-- <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="form-group">
                                    <input type="file" class="dropify" name="image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Save & Publish</h3>
                            <div class="card-options ">
                                {{-- <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row clearfix">
                                <div class="col-sm-12 mb-3">
                                    <label class="form-label mb-3 d-flex">Visibility</label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline1" name="is_visible" class="form-check-input" value="1" checked>
                                        <label class="form-check-label" for="customRadioInline1">Show</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline2" name="is_visible" class="form-check-input" value="0">
                                        <label class="form-check-label" for="customRadioInline2">Hide</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    @endsection

    @section('script')
    <script src="{{ asset('assets/admin-assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/page-assets/js/form/dropify.js') }}"></script>
    @endsection