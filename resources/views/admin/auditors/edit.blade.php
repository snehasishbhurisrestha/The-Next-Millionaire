@extends('layouts.app')

    @section('title') Auditors @endsection
    
    @section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin-assets/plugins/dropify/css/dropify.min.css') }}">
    @endsection
    
    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Auditors</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('auditors.index') }}">Auditors</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Auditor</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}

                    <li class="nav-item"><a class="btn btn-info" href="{{ route('auditors.index') }}"><i class="fa fa-arrow-left me-2"></i>Back</a></li>
                </ul>
            </div>
        </div>
    </div>

    <form action="{{ route('auditors.update',$auditor->id) }}" method="post" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control" placeholder="Enter First name" name="first_name" value="{{ $auditor->first_name }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Last Name <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Enter Last name" name="last_name" value="{{ $auditor->last_name }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Email <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="email" class="form-control" name="email" id="email" value="{{ $auditor->email }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Specialization <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <select name="specialization[]" class="select2 form-control select2-multiple" multiple="multiple" multiple data-placeholder="Choose ..." required>
                                        @foreach($certification_types as $certification_type)
                                        <option value="{{ $certification_type->id }}" @if($auditor->specialization->contains($certification_type->id)) selected @endif>{{ $certification_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Gender <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <select class="form-control input-height" name="gender" required>
                                        <option value selected disabled>Select...</option>
                                        <option value="male" @if($auditor->gender == 'male') selected @endif>Male</option>
                                        <option value="female" @if($auditor->gender == 'female') selected @endif>Female</option>
                                        <option value="others" @if($auditor->gender == 'others') selected @endif>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Mobile No. <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="phone" value="{{ $auditor->phone }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Alternative Mobile No. <span class="text-danger"></span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="opt_mobile_no" value="{{ $auditor->opt_mobile_no }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Date Of Birth  <span class="text-danger"></span></label>
                                <div class="col-md-9">
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="date_of_birth" value="{{ $auditor->date_of_birth }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Address <span class="text-danger"></span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="address" value="{{ $auditor->address }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Profile Picture</label>
                                <div class="col-md-9">
                                    <input type="file" class="dropify" name="profile_image">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Aadhar Card Number <span class="text-danger"></span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="aadhaar_number" value="{{ $auditor->aadhar_card_number }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Aadhar Card Image</label>
                                <div class="col-md-9">
                                    <input type="file" class="dropify" name="aadhar_image">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Pan Card Number <span class="text-danger"></span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="pan_card_number" value="{{ $auditor->pan_card_number }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Pan Card Image</label>
                                <div class="col-md-9">
                                    <input type="file" class="dropify" name="pan_image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bank A/C Information</h3>
                            <div class="card-options ">
                                {{-- <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Bank Name</label>
                                        <input type="text" name="bank_name" value="{{ $auditor->bank_name }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Branch Name</label>
                                        <input type="text" name="branch_name" value="{{ $auditor->branch_name }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Account Number</label>
                                        <input type="number" name="account_number" value="{{ $auditor->account_number }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>IFSC Code</label>
                                        <input type="text" name="ifsc_code" value="{{ $auditor->ifsc_code }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Account Information</h3>
                            <div class="card-options ">
                                {{-- <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" id="login-email" class="form-control" value="{{ $auditor->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="password" value="{{ old('password') }}">
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label class="form-label mb-3 d-flex">Status</label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline1" name="status" class="form-check-input" value="1" {{ check_uncheck($auditor->status,1) }}>
                                        <label class="form-check-label" for="customRadioInline1">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline2" name="status" class="form-check-input" value="0" {{ check_uncheck($auditor->status,0) }}>
                                        <label class="form-check-label" for="customRadioInline2">Inactive</label>
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
    <script>
        $('#email').on('keyup',function(){
            $('#login-email').val($(this).val());
        });
    </script>
    @endsection