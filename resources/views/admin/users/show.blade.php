@extends('layouts.app')

    @section('title') Users @endsection

    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Users</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users Details</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}

                    <li class="nav-item"><a class="btn btn-info" href="{{ route('users.index') }}"><i class="fa fa-arrow-left me-2"></i>Back</a></li>
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
                            <h5>Users Profile</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ $user->getFirstMediaUrl('user-image') }}" alt="Profile Picture" class="profile-image mb-3">
                            <h6>{{ $user->name }}</h6>
                            <p class="text-muted">{{ $user->email }}</p>
                            {!! check_visibility($user->status) !!}
                        </div>
                    </div>
                </div>
    
                <!-- Details Section -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Users Details</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered details-table">
                                <tbody>
                                    <tr>
                                        <th>First Name</th>
                                        <td>{{ $user->first_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Name</th>
                                        <td>{{ $user->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Name</th>
                                        <td>{{ $user->business->business_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Category</th>
                                        <td>{{ $user->business?->category?->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ $user->gender }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mobile No.</th>
                                        <td>{{ $user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alternative Mobile No.</th>
                                        <td>{{ $user->opt_mobile_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>{{ $user->date_of_birth }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $user->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Address</th>
                                        <td>{{ $user->business->business_address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trade Licence Number</th>
                                        <td>{{ $user->business->trade_license_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Documents Section -->
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Trade Licence</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ $user->getFirstMediaUrl('user-trade-licence') }}" alt="Trade Licence" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    @endsection
