@extends('layouts.user-dashboard')

@section('title','Profile')

@section('content')

<h1 class="h3 mb-2 text-gray-800" style="color: white !important;">Update Profile</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-body">

        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Name</label>
                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}"
                       required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email"
                       name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}" disabled
                       required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text"
                       name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $user->phone) }}">
                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- <hr> --}}

            {{-- <h6 class="text-primary">Change Password (Optional)</h6>

            <div class="form-group">
                <label>New Password</label>
                <input type="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div> --}}

            <button class="btn btn-primary">
                Update Profile
            </button>
        </form>

    </div>
</div>

@endsection
