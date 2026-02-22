@extends('layouts.app')

@section('title','Testimonial Video')

@section('style')
<style>
    .star {
        font-size: 20px;
        margin-right: 3px;
    }

    .star-rating {
        direction: rtl;
        display: inline-block;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        font-size: 30px;
        color: #ccc;
        padding: 0 5px;
        cursor: pointer;
    }

    .star-rating input:checked ~ label {
        color: gold;
    }

    .preview-img {
        max-width: 120px;
        border-radius: 6px;
    }
</style>
@endsection

@section('content')

<div class="section-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header-action">
                <h1 class="page-title">Testimonial Videos / Screenshots</h1>
            </div>

            @can('Testimonial2 Create')
                <button class="btn btn-info" data-toggle="modal" data-target="#addTestimonialModal">
                    <i class="fa fa-plus"></i> Add New
                </button>
            @endcan
        </div>
    </div>
</div>

<div class="section-body mt-4">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Sl.no</th>
                                <th>Type</th>
                                <th>Preview</th>
                                <th>Visibility</th>
                                <th>Created At</th>
                                @canany(['Testimonial2 Edit','Testimonial2 Delete'])
                                    <th>Action</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $testimonial)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <span class="badge badge-info">
                                            {{ ucfirst($testimonial->type) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if($testimonial->type == 'video')
                                            {!! $testimonial->video_url !!}
                                        @endif

                                        @if($testimonial->type == 'screenshort')
                                            <img src="{{ $testimonial->getFirstMediaUrl('testimonialss') }}"
                                                 class="preview-img">
                                        @endif
                                    </td>

                                    <td>
                                        {!! check_status($testimonial->is_visible) !!}
                                    </td>

                                    <td>
                                        {{ format_datetime($testimonial->created_at) }}
                                    </td>

                                    @canany(['Testimonial2 Edit','Testimonial2 Delete'])
                                    <td>

                                        @can('Testimonial2 Edit')
                                            <button class="btn btn-sm btn-primary"
                                                    data-toggle="modal"
                                                    data-target="#editModal{{ $testimonial->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        @endcan

                                        @can('Testimonial2 Delete')
                                            <form action="{{ route('testimonial2.destroy', $testimonial->id) }}"
                                                  method="POST"
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan

                                    </td>
                                    @endcanany
                                </tr>

                                <!-- EDIT MODAL -->
                                <div class="modal fade" id="editModal{{ $testimonial->id }}">
                                    <div class="modal-dialog">
                                        <form action="{{ route('testimonial2.update',$testimonial->id) }}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Edit Testimonial</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        &times;
                                                    </button>
                                                </div>

                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label>Type</label>
                                                        <select name="type"
                                                                class="form-control edit-type"
                                                                onchange="toggleEditFields(this)">
                                                            <option value="video"
                                                                {{ $testimonial->type=='video'?'selected':'' }}>
                                                                Video
                                                            </option>
                                                            <option value="screenshort"
                                                                {{ $testimonial->type=='screenshort'?'selected':'' }}>
                                                                Screenshot
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group video-field
                                                        {{ $testimonial->type!='video'?'d-none':'' }}">
                                                        <label>Video URL</label>
                                                        <input type="text"
                                                               name="video_url"
                                                               class="form-control"
                                                               value="{{ $testimonial->video_url }}">
                                                    </div>

                                                    <div class="form-group image-field
                                                        {{ $testimonial->type!='screenshort'?'d-none':'' }}">
                                                        <label>Upload Screenshot</label>
                                                        <input type="file"
                                                               name="image"
                                                               class="form-control">

                                                        <br>
                                                        <img src="{{ $testimonial->getFirstMediaUrl('testimonialss') }}"
                                                             class="preview-img">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Visibility</label>
                                                        <select name="is_visible" class="form-control">
                                                            <option value="1"
                                                                {{ $testimonial->is_visible==1?'selected':'' }}>
                                                                Visible
                                                            </option>
                                                            <option value="0"
                                                                {{ $testimonial->is_visible==0?'selected':'' }}>
                                                                Hidden
                                                            </option>
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-success">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- ADD MODAL -->
<div class="modal fade" id="addTestimonialModal">
    <div class="modal-dialog">
        <form action="{{ route('testimonial2.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Testimonial</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Type</label>
                        <select name="type"
                                id="typeSelect"
                                class="form-control">
                            <option value="video" selected>Video</option>
                            <option value="screenshort">Screenshot</option>
                        </select>
                    </div>

                    <div class="form-group" id="videoField">
                        <label>Video URL</label>
                        <input type="text"
                               name="video_url"
                               class="form-control">
                    </div>

                    <div class="form-group d-none" id="imageField">
                        <label>Upload Screenshot</label>
                        <input type="file"
                               name="image"
                               class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Visibility</label>
                        <select name="is_visible" class="form-control">
                            <option value="1">Visible</option>
                            <option value="0">Hidden</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@section('script')
<script>
    document.getElementById('typeSelect').addEventListener('change', function () {

        if (this.value === 'video') {
            document.getElementById('videoField').classList.remove('d-none');
            document.getElementById('imageField').classList.add('d-none');
        } else {
            document.getElementById('videoField').classList.add('d-none');
            document.getElementById('imageField').classList.remove('d-none');
        }

    });

    function toggleEditFields(selectElement) {

        let modal = selectElement.closest('.modal');

        let videoField = modal.querySelector('.video-field');
        let imageField = modal.querySelector('.image-field');

        if (selectElement.value === 'video') {
            videoField.classList.remove('d-none');
            imageField.classList.add('d-none');
        } else {
            videoField.classList.add('d-none');
            imageField.classList.remove('d-none');
        }
    }
</script>
@endsection
