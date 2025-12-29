@extends('layouts.app')

    @section('title') Course @endsection

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
                    <h1 class="page-title">Course</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cource.index') }}">Course</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Course</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}

                    <li class="nav-item"><a class="btn btn-info" href="{{ route('cource.index') }}"><i class="fa fa-arrow-left me-2"></i>Back</a></li>
                </ul>
            </div>
        </div>
    </div>

    <form action="{{ route('cource.update',$item->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="hidden" name="uploaded_video_path" id="uploaded_video_path">

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
                                <label class="col-md-3 col-form-label">Cource Title <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Enter title" name="name" value="{{ old('name', $item->title) }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Description</label>
                                <div class="col-md-9">
                                    <textarea rows="4" class="form-control no-resize summernote" placeholder="Enter Description" name="description">{{ old('description',$item->description) }}</textarea>
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                <label class="col-md-3 col-form-label">Course Payment Type <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <select class="form-control input-height" name="type" id="courseType" required>
                                        <option {{ old('type', $item->type) == 'free' ? 'selected' : '' }} value="free" selected>Free</option>
                                        <option {{ old('type', $item->type) == 'paid' ? 'selected' : '' }} value="paid">Paid</option>
                                    </select>
                                </div>
                            </div> --}}
                            
                            <div class="form-group row" id="cource-price">
                                <label class="col-md-3 col-form-label">Course Price <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" placeholder="Enter price" name="price" id="priceField" value="{{ old('price',$item->price) }}" step="0.01">
                                </div>
                            </div>

                            <div class="form-group row" id="cource-price">
                                <label class="col-md-3 col-form-label">Course Offer Price <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" placeholder="Enter Offer price" name="offer_price" id="priceField" value="{{ old('offer_price',$item->offer_price) }}" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Course Video</h3>
                            <div class="card-options ">
                                {{-- <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            {!! $item->video_url !!}
                            <div class="clearfix">
                                <div class="form-group mt-10">
                                    {{-- <input type="file" class="dropify" name="video" data-default-file="{{ $item->getFirstMediaUrl('course-video') }}"> --}}
                                    <label class="col-form-label">Enter Vimeo Embed Link <span class="text-danger">*</span></label>
                                    <input type="text" name="video_url" value="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Course Video</h3>
                        </div>

                        <div class="card-body">
                            @if($item->getFirstMediaUrl('course-video'))
                                <video width="100%" controls class="mb-3">
                                    <source src="{{ $item->getFirstMediaUrl('course-video') }}" type="video/mp4">
                                </video>
                            @else
                                <p class="text-danger">No video uploaded.</p>
                            @endif

                            <p class="text-muted">
                                Upload New Video (optional). If you don't upload, old video will remain.
                            </p>
                            <div id="drag-drop-area"></div>
                            <small class="text-success">
                                Supports resume. Upload 50GB+ safely.
                            </small>

                        </div>
                    </div> --}}
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
                                <div class="col-sm-12 mb-3">
                                    <label class="form-label mb-3 d-flex">Visibility</label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline1" name="is_visible" class="form-check-input" value="1" {{ check_uncheck($item->is_visible,1) }}>
                                        <label class="form-check-label" for="customRadioInline1">Show</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline2" name="is_visible" class="form-check-input" value="0" {{ check_uncheck($item->is_visible,0) }}>
                                        <label class="form-check-label" for="customRadioInline2">Hide</label>
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
        // $(document).ready(function () {
        //     function togglePriceField() {
        //         var type = $('#courseType').val();
        //         if (type === 'paid') {
        //             $('#cource-price').show();
        //             $('#priceField').attr('required', true);
        //         } else {
        //             $('#cource-price').hide();
        //             $('#priceField').removeAttr('required');
        //             $('#priceField').val('');
        //         }
        //     }
    
        //     // Initial check (in case old value is pre-filled)
        //     togglePriceField();
    
        //     // On change event
        //     $('#courseType').on('change', function () {
        //         togglePriceField();
        //     });
        // });
    </script>
    <script src="https://releases.transloadit.com/uppy/v3.4.0/uppy.min.js"></script>

<script>
let uppyInitialized = false;
initUppy();

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
    });

    uppy.on('complete', function(result){
        const file = result.successful[0];
        document.getElementById("uploaded_video_path").value = file.uploadURL;
        alert("Video uploaded successfully");
    });
}
</script>

    @endsection