@extends('layouts.app')

@section('title') Add Course Content @endsection

@section('style')
<link rel="stylesheet" href="{{ asset('assets/admin-assets/plugins/dropify/css/dropify.min.css') }}">

{{-- UPPY CSS --}}
<link href="https://releases.transloadit.com/uppy/v3.4.0/uppy.min.css" rel="stylesheet">
@endsection

@section('content')

<div class="section-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header-action">
                <h1 class="page-title">Add Course Content</h1>
                <ol class="breadcrumb page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cource.index') }}">Courses</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cource-content.index', request()->segment(2)) }}">Course Content</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </div>
            <ul class="nav nav-tabs page-header-tab">
                <li class="nav-item">
                    <a class="btn btn-info" href="{{ route('cource-content.index', request()->segment(2)) }}">
                        <i class="fa fa-arrow-left me-2"></i>Back
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<form action="{{ route('cource-content.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{ request()->segment(2) }}" name="course_id">

    {{-- THIS WILL STORE FINAL VIDEO PATH --}}
    <input type="hidden" name="uploaded_video_path" id="uploaded_video_path">

    <div class="section-body mt-4">
        <div class="container-fluid">
            <div class="row">

                {{-- Left Column --}}
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Basic Information</h3>
                        </div>
                        <div class="card-body">

                            {{-- Title --}}
                            <div class="form-group row mb-4">
                                <label class="col-md-3 col-form-label">Content Title <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Enter title" name="title" value="{{ old('title') }}" required>
                                </div>
                            </div>

                            {{-- Content Type --}}
                            <div class="form-group row mb-4">
                                <label class="col-md-3 col-form-label">Content Type <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <select name="content_type" id="content_type" class="form-control" required>
                                        <option value="text" {{ old('content_type') == 'text' ? 'selected' : '' }}>Text</option>
                                        <option value="video" {{ old('content_type') == 'video' ? 'selected' : '' }}>Video</option>
                                        <option value="pdf" {{ old('content_type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Text Content --}}
                            <div id="text_content_field" class="form-group row mb-4">
                                <label class="col-md-3 col-form-label">Content</label>
                                <div class="col-md-9">
                                    <textarea rows="5" class="form-control summernote" placeholder="Enter lesson text..." name="content">{{ old('content') }}</textarea>
                                </div>
                            </div>

                            {{-- UPPY VIDEO UPLOADER --}}
                            <div id="video_upload_field" class="form-group row mb-4" style="display:none;">
                                <label class="col-md-3 col-form-label">Upload Vimeo Embed Link</label>
                                <div class="col-md-9">
                                    <input type="text" name="video_url" class="form-control">
                                    {{-- <div id="drag-drop-area"></div>
                                    <small class="text-success">
                                        Supports resume upload. You can upload 50GB+ safely.
                                    </small> --}}
                                </div>
                            </div>

                            {{-- PDF Upload --}}
                            <div id="pdf_upload_field" class="form-group row mb-4" style="display:none;">
                                <label class="col-md-3 col-form-label">Upload PDF</label>
                                <div class="col-md-9">
                                    <input type="file" name="pdf_file" class="dropify" data-allowed-file-extensions="pdf" data-max-file-size="20M" />
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-md-3 col-form-label">Upload Multiple PDF</label>
                                <div class="col-md-9">
                                    <input type="file"
                                        name="pdf_files[]"
                                        class="dropify"
                                        data-allowed-file-extensions="pdf"
                                        data-max-file-size="40M"
                                        multiple />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Save & Publish</h3>
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

@section('script')
<script src="{{ asset('assets/admin-assets/plugins/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/page-assets/js/form/dropify.js') }}"></script>

{{-- UPPY --}}
<script src="https://releases.transloadit.com/uppy/v3.4.0/uppy.min.js"></script>

<script>
let uppyInitialized = false;

function initUppy() {
    if (uppyInitialized) return;
    uppyInitialized = true;

    const uppy = new Uppy.Uppy({
        autoProceed: true,
        restrictions: {
            allowedFileTypes: ['video/*']
        }
    })
    .use(Uppy.Dashboard, {
        inline: true,
        target: '#drag-drop-area',
        showProgressDetails: true,
        proudlyDisplayPoweredByUppy: false
    })
    .use(Uppy.Tus, {
        endpoint: "/tus"
    })

    uppy.on('complete', function (result) {
        const file = result.successful[0];
        document.getElementById("uploaded_video_path").value = file.uploadURL;
        alert("Video uploaded successfully");
    })
}


$(document).ready(function () {

    function toggleContentFields() {
        const type = $('#content_type').val();

        $('#text_content_field, #video_upload_field, #pdf_upload_field').hide();

        if (type === 'text') $('#text_content_field').show();
        if (type === 'pdf') $('#pdf_upload_field').show();

        if (type === 'video') {
            $('#video_upload_field').show();
            initUppy(); // 🚀 init only when visible
        }
    }

    toggleContentFields();
    $('#content_type').on('change', toggleContentFields);
});
</script>

@endsection
