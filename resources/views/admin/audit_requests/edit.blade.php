@extends('layouts.app')

    @section('title') Audit Enquiry @endsection
    
    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Audit Enquiry</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('audit.index') }}">Audit Enquiry</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Audit Enquiry</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}

                    <li class="nav-item"><a class="btn btn-info" href="{{ route('audit.index') }}"><i class="fa fa-arrow-left me-2"></i>Back</a></li>
                </ul>
            </div>
        </div>
    </div>

    <form action="{{ route('audit.update',$audit->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
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
                                <label class="col-md-3 col-form-label">Choose User <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <select class="form-control input-height" name="user" required>
                                        <option value selected disabled>Select...</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if($audit->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Certification / Enquiry <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <select class="form-control input-height" name="certification" required>
                                        <option value selected disabled>Select...</option>
                                        @foreach($certification_types as $certification_type)
                                        <option value="{{ $certification_type->id }}" @if($audit->certification_type_id == $certification_type->id) selected @endif>{{ $certification_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Audit Date <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="audit_date" value="{{ $audit->audit_date }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
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