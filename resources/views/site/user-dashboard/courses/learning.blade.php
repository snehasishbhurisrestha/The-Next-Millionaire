@extends('layouts.user-dashboard')

@section('style')
<style>
    /* Page Layout */
    .lesson-container {
        /* background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 25px; */
        margin-bottom: 30px;
    }

    /* Lesson Title */
    .lesson-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #113995;
        border-bottom: 2px solid #e1e1e1;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    /* Video / PDF / Text */
    .lesson-content {
        margin-top: 20px;
    }

    .lesson-content p {
        line-height: 1.7;
        font-size: 1.05rem;
        color: #333;
    }

    video, iframe {
        width: 100%;
        border-radius: 10px;
        /* margin-top: 15px; */
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    iframe {
        height: 600px;
    }

    /* Navigation Buttons */
    .lesson-nav {
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
    }

    .lesson-nav a, .lesson-nav span {
        border-radius: 30px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .lesson-nav .btn-outline-primary {
        border-color:#f7f6f4;
        color:#f0f0ee;
    }

    .lesson-nav .btn-outline-primary:hover {
        background-color: #202021;
        color: #fff;
    }

    .lesson-nav .btn-secondary {
        background-color: #ccc;
        border: none;
        cursor: not-allowed;
    }

    .btn i {
        margin-right: 5px;
    }
    #lessonVideo {
        max-width: 100%;
        border-radius: 8px;
    }

    .btn-outline-primary:not(:disabled):not(.disabled):active {
        color: #fff;
        background-color: #080808;
        border-color: #080808;
    }

</style>

<style>
    .pdf-btn {
        display: inline-block;
        padding: 8px 13px;
        border-radius: 30px;
        background: #000000;
        border: 2px solid #C9A227;
        color: #C9A227;
        font-weight: 600;
        text-decoration: none;
        transition: all .3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, .4);
        margin: 8px;
    }

    .pdf-btn:hover{
        background:#C9A227;
        color:#000;
        transform: translateY(-2px);
        box-shadow:0 8px 25px rgba(0,0,0,.6);
    }

    /* Show pointer hand */
    .pdf-btn{
        cursor:pointer;
    }
</style>


<link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
<script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;900&display=swap" rel="stylesheet">

<style>
    .lesson-heading{
        font-family: "Poppins", sans-serif;
        font-weight: 700;
    }
</style>
@endsection

@section('title')
    Learning
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 lesson-heading" style="color: white !important;">{{ $currentLesson->title }}</h1>
</div>

<div class="lesson-container">
    @if ($currentLesson)

        <div class="lesson-content">
            {{-- Content Type Display --}}
            @if ($currentLesson->content_type === 'text')
                <p>{!! $currentLesson->content !!}</p>

            @elseif ($currentLesson->content_type === 'video')

                @if($currentLesson->video_url)
                    <div style="box-shadow: 0 0 25px rgba(255,255,255,.45), 
            0 0 60px rgba(255,255,255,.15);">

                    {!! $currentLesson->video_url !!}
                    </div>
                @endif


            @elseif ($currentLesson->content_type === 'pdf')
                @if ($currentLesson->getFirstMediaUrl('pdfs'))
                    <iframe src="{{ $currentLesson->getFirstMediaUrl('pdfs') }}"></iframe>
                    <div class="mt-3 text-center">
                        <a href="{{ $currentLesson->getFirstMediaUrl('pdfs') }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fa fa-file-pdf-o"></i> Open PDF in New Tab
                        </a>
                    </div>
                @else
                    <p class="text-danger mt-3">No PDF available.</p>
                @endif
            @endif
        </div>
    @else
        <p class="text-muted text-center">No lesson selected.</p>
    @endif

    @if ($currentLesson && $currentLesson->hasMedia('pdf_files'))
        <div class="mt-4 text-center">
            <h5 class="mb-2" style="color: white !important;">PDF Resources</h5>

            <div class="d-flex flex-wrap gap-2 justify-content-center">
                @foreach ($currentLesson->getMedia('pdf_files') as $index => $pdf)
                    {{-- <a href="{{ $pdf->getUrl() }}"
                    target="_blank"
                    class="btn btn-outline-primary btn-sm m-1">
                        <i class="fa fa-file-pdf-o"></i>
                        {{ $pdf->file_name }}
                    </a> --}}
                    <a href="{{ $pdf->getUrl() }}" download
                        class="pdf-btn">
                        <i class="fa fa-file-pdf-o"></i>
                        Download PDF {{ $index+1 }}
                    </a>

                @endforeach
            </div>
        </div>
    @endif




    <!-- Navigation Buttons -->
    <div class="lesson-nav">
        @if ($prevLesson)
            <a href="{{ route('learning.page', ['course_slug' => $course->slug, 'lesson_id' => $prevLesson->id]) }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Prev
            </a>
        @else
            <span class="btn btn-secondary text-dark d-none">Prev</span>
        @endif

        @if ($nextLesson)
            <a href="{{ route('learning.page', ['course_slug' => $course->slug, 'lesson_id' => $nextLesson->id]) }}" class="btn btn-outline-primary">
                Next <i class="fas fa-arrow-right"></i>
            </a>
        @else
            <span class="btn btn-secondary text-dark d-none">Next</span>
        @endif
    </div>
</div>
@endsection
