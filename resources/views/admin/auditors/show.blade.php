@extends('layouts.app')

    @section('title') Auditors @endsection
    
    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Auditors</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('auditors.index') }}">Auditors</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Auditor Details</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}

                    <li class="nav-item"><a class="btn btn-info" href="{{ route('auditors.index') }}"><i class="fa fa-arrow-left me-2"></i>Back</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="section-body mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header text-center">
                            <h5>Auditor Profile</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ $auditor->getFirstMediaUrl('auditors-image') }}" alt="Profile Picture" class="profile-image mb-3">
                            <h6>{{ $auditor->name }}</h6>
                            <p class="text-muted">{{ $auditor->email }}</p>
                            {!! check_visibility($auditor->status) !!}
                        </div>
                    </div>
                </div>
    
                <!-- Details Section -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Auditor Details</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered details-table">
                                <tbody>
                                    <tr>
                                        <th>First Name</th>
                                        <td>{{ $auditor->first_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Name</th>
                                        <td>{{ $auditor->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $auditor->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ $auditor->gender }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mobile No.</th>
                                        <td>{{ $auditor->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alternative Mobile No.</th>
                                        <td>{{ $auditor->opt_mobile_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>{{ $auditor->date_of_birth }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $auditor->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Aadhar Number</th>
                                        <td>{{ $auditor->aadhaar_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>PAN Number</th>
                                        <td>{{ $auditor->pan_card_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $auditor->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Documents Section -->
            <div class="row mt-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Aadhar Card</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ $auditor->getFirstMediaUrl('auditors-aadhar') }}" alt="Aadhar Card" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>PAN Card</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ $auditor->getFirstMediaUrl('auditors-pan') }}" alt="PAN Card" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
