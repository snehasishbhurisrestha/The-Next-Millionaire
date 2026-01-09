@extends('layouts.user-dashboard')

@section('title','Profile')

@section('content')

<h1 class="h3 mb-4 text-gray-800" style="color: white !important;">Update Profile</h1>

<div class=" shadow mb-4">
    <div class="card-body">
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- Left Side: Profile Image -->
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <img id="profilePreview"
                            src="{{ $user->getFirstMediaUrl('user-image') ?: asset('assets/user-admin-assets/img/default-user.png') }}"
                            class="rounded-circle img-fluid"
                            style="width: 150px; height: 150px; object-fit: cover;">
                    </div>

                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file"
                                name="profile_image"
                                class="custom-file-input"
                                id="profileImageInput"
                                onchange="previewImage(event)">
                            <label class="custom-file-label" for="profileImageInput">Choose image</label>
                        </div>
                    </div>

                </div>

                <!-- Right Side: Inputs -->
                <div class="col-md-8">
                    <div class="form-group">
                        <label style="color: white !important;">Name</label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}"
                               required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label style="color: white !important;">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ $user->email }}"
                               disabled>
                    </div>

                    <div class="form-group">
                        <label style="color: white !important;">Phone</label>
                        <input type="text"
                               name="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $user->phone) }}">
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <button class="btn btn-primary mt-2">
                        Update Profile
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('profilePreview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection
