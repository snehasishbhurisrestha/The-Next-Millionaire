@extends('layouts.app')

@section('title','Enrollment Details')

@section('content')

<div class="section-body">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center">
            <div class="header-action">
                <h1 class="page-title">Enrollment Details</h1>
                <ol class="breadcrumb page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.enrollments.index') }}">Enrollments</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </div>
        </div>

    </div>
</div>


<div class="section-body mt-4">
<div class="container-fluid">

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Enrollment Information</h5>
    </div>

    <div class="card-body">

        <h6>User Details</h6>
        <p>
            <strong>Name:</strong> {{ $enrollment->user->name }} <br>
            <strong>Email:</strong> {{ $enrollment->user->email }} <br>
            <strong>Phone:</strong> {{ $enrollment->user->phone ?? '-' }}
        </p>

        <hr>

        <h6>Course Details</h6>
        <p>
            <strong>Course:</strong> {{ $enrollment->course->title }} <br>
            <strong>Status:</strong> {{ ucfirst($enrollment->status) }} <br>
            <strong>Enrolled On:</strong> {{ $enrollment->created_at->format('d M Y h:i A') }}
        </p>

    </div>
</div>

</div>
</div>

@endsection
