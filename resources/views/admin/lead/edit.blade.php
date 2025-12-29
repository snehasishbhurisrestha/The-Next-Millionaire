@extends('layouts.app')

    @section('title') Leades @endsection
    
    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Leades</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('lead.index') }}">Leades</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Leades</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}

                    <li class="nav-item"><a class="btn btn-info" href="{{ route('lead.index') }}"><i class="fa fa-arrow-left me-2"></i>Back</a></li>
                </ul>
            </div>
        </div>
    </div>

    <form action="{{ route('lead.update',$item->id) }}" method="post" enctype="multipart/form-data">
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
                                <label class="col-md-3 col-form-label">First Name <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Enter First name" name="first_name" value="{{ $item->first_name }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Last Name <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Enter Last name" name="last_name" value="{{ $item->last_name }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Business Name <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Enter Business Name" name="business_name" value="{{ $item->business_name }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Business Category <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <select class="form-control input-height" name="business_category_id" required>
                                        <option value selected disabled>Select...</option>
                                        @foreach($business_categorys as $business_category)
                                        <option value="{{ $business_category->id }}" @if( $item->business_category_id == $business_category->id) selected @endif>{{ $business_category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Email <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="email" class="form-control" name="email" id="email" value="{{ $item->email }}" placeholder="Enter Email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Gender <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <select class="form-control input-height" name="gender" required>
                                        <option value selected disabled>Select...</option>
                                        <option value="male" @if( $item->gender == 'male') selected @endif>Male</option>
                                        <option value="female" @if( $item->gender == 'female') selected @endif>Female</option>
                                        <option value="others" @if( $item->gender == 'others') selected @endif>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Mobile No. <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="phone" value="{{ $item->phone }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Alternative Mobile No. <span class="text-danger"></span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="opt_mobile_no" value="{{ $item->opt_mobile_no }}" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Contact Person</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Enter contact person name" name="contact_person" value="{{ $item->contact_person }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Address <span class="text-danger"></span></label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="address">{{ $item->address }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Business Address <span class="text-danger"></span></label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="business_address">{{ $item->business_address }}</textarea>
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