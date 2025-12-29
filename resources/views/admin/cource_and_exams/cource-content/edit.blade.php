@extends('layouts.app')

@section('title') Edit Course Content @endsection

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
                <h1 class="page-title">Edit Course Content</h1>
                <ol class="breadcrumb page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cource.index') }}">Course</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cource-content.index', request()->segment(2)) }}">Course Content</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
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


<form action="{{ route('cource-content.update', $item->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Hidden Tus Path --}}
    <input type="hidden" name="uploaded_video_path" id="uploaded_video_path">

    <div class="section-body mt-4">
        <div class="container-fluid">
            <div class="row">

                {{-- LEFT --}}
                <div class="col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Basic Information</h3>
                        </div>

                        <div class="card-body">

                            {{-- Title --}}
                            <div class="form-group row mb-4">
                                <label class="col-md-3 col-form-label">Content Title <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" name="title" class="form-control"
                                           value="{{ old('title',$item->title) }}" required>
                                </div>
                            </div>

                            {{-- Type --}}
                            <div class="form-group row mb-4">
                                <label class="col-md-3 col-form-label">Content Type</label>
                                <div class="col-md-9">
                                    <select name="content_type" id="content_type" class="form-control">
                                        <option value="text" {{ $item->content_type=='text' ? 'selected':'' }}>Text</option>
                                        <option value="video" {{ $item->content_type=='video' ? 'selected':'' }}>Video</option>
                                        <option value="pdf" {{ $item->content_type=='pdf' ? 'selected':'' }}>PDF</option>
                                    </select>
                                </div>
                            </div>


                            {{-- TEXT --}}
                            <div id="text_content_field" style="display: {{ $item->content_type=='text'?'':'none' }}" class="form-group row mb-4">
                                <label class="col-md-3 col-form-label">Content</label>
                                <div class="col-md-9">
                                    <textarea class="form-control summernote" rows="5" name="content">{{ old('content',$item->content) }}</textarea>
                                </div>
                            </div>


                            {{-- VIDEO --}}
                            <div id="video_upload_field" style="display: {{ $item->content_type=='video'?'block':'none' }}">

                                <label>Existing Video</label>
                                {{-- @if($item->getFirstMediaUrl('videos'))
                                    <video width="100%" controls class="mb-2">
                                        <source src="{{ $item->getFirstMediaUrl('videos') }}" type="video/mp4">
                                    </video>
                                @else
                                    <p class="text-danger">No video uploaded.</p> 
                                @endif --}}

                                @if($item->video_url)
                                    {!! $item->video_url !!}
                                @endif

                                <label class="mt-3">Upload Vimeo Embed Link (Optional)</label>
                                <input type="text" name="video_url" value="" class="form-control">
                                {{-- <div id="drag-drop-area"></div>
                                <small class="text-success">
                                    Supports resume upload. You can upload 50GB+ safely.
                                </small> --}}
                            </div>


                            {{-- PDF --}}
                            <div id="pdf_upload_field"
                                 style="display: {{ $item->content_type=='pdf'?'block':'none' }}">
                                <label>Upload PDF</label>
                                <input type="file" name="pdf_file" class="dropify"
                                       data-default-file="{{ $item->getFirstMediaUrl('pdfs') }}"
                                       data-allowed-file-extensions="pdf" />
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


                {{-- RIGHT --}}
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Save & Publish</h3>
                        </div>

                        <div class="card-body">
                            <button class="btn btn-primary">Update</button>
                            <a href="{{ route('cource-content.index', request()->segment(2)) }}"
                               class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

</form>
<div class="section-body mt-4">
    <div class="container-fluid">
        <div class="row">

            {{-- LEFT --}}
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Existing PDFs</h3>
                    </div>

                    <div class="card-body">
                        @if($item->hasMedia('pdf_files'))
                            <div class="form-group row mb-4">
                                <label class="col-md-3 col-form-label">Existing PDFs</label>
                                <div class="col-md-9">

                                    @foreach($item->getMedia('pdf_files') as $pdf)
                                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">

                                            <a href="{{ $pdf->getUrl() }}" target="_blank">
                                                {{ $pdf->file_name }}
                                            </a>

                                            <form action="{{ route('cource-content.pdf.delete', $pdf->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Delete this PDF?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                            </form>

                                        </div>
                                    @endforeach

                                    

                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('script')
<script src="{{ asset('assets/admin-assets/plugins/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/page-assets/js/form/dropify.js') }}"></script>

<script src="https://releases.transloadit.com/uppy/v3.4.0/uppy.min.js"></script>


<script>

function toggleFields(){
    let t = $('#content_type').val();

    $('#text_content_field').hide();
    $('#video_upload_field').hide();
    $('#pdf_upload_field').hide();

    if(t==='text') $('#text_content_field').show();
    if(t==='video') { $('#video_upload_field').show(); initUppy(); }
    if(t==='pdf') $('#pdf_upload_field').show();
}

$('#content_type').on('change', toggleFields);



let uppyInitialized = false;

function initUppy(){
    if(uppyInitialized) return;
    uppyInitialized = true;

    const uppy = new Uppy.Uppy({
        autoProceed:true,
        restrictions:{ allowedFileTypes:['video/*'] }
    })
    .use(Uppy.Dashboard,{
        inline:true,
        target:'#drag-drop-area',
        showProgressDetails:true,
        proudlyDisplayPoweredByUppy:false
    })
    .use(Uppy.Tus,{
        endpoint:'/tus'
    });

    uppy.on('complete', res=>{
        const file = res.successful[0];
        document.getElementById('uploaded_video_path').value = file.uploadURL;
        alert('Video uploaded successfully');
    });
}

toggleFields();
</script>

@endsection
