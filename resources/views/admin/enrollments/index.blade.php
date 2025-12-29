@extends('layouts.app')

@section('title','Enrollments')

@section('content')

<div class="section-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header-action">
                <h1 class="page-title">Enrollments</h1>
                <ol class="breadcrumb page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Enrollments</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body mt-4">
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Course Enrollment Records</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($enrollments as $en)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $en->user->name ?? '-' }} <br>
                                <small>{{ $en->user->email ?? '' }}</small>
                            </td>

                            <td>{{ $en->course->title ?? '-' }}</td>

                            <td>
                                <span class="badge badge-success">
                                    {{ ucfirst($en->status) }}
                                </span>
                            </td>

                            <td>{{ $en->created_at->format('d M Y') }}</td>

                            <td>
                                <a href="{{ route('admin.enrollments.show',$en->id) }}" class="btn btn-info btn-sm">
                                    View
                                </a>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No enrollments found</td>
                        </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
