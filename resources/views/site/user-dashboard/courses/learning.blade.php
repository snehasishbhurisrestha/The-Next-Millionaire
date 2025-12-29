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
        padding: 8px 10px;
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

<style>
    .end-lesson-box{
        /* background:#0b1f14; */
        padding:24px;
        margin:35px 10px;
        border-radius:18px;
        box-shadow:0 10px 25px rgba(0,0,0,.4);
        text-align:center;
    }

    .special-btn{
        display:inline-block;
        padding:14px 28px;
        border-radius:50px;
        font-weight:700;
        color:#000;
        background: linear-gradient(145deg,#ffd700,#ffb400,#000000);
        text-decoration:none;
        border:2px solid #ffea00;
        transition:.3s;
        margin: 10px 5px;
    }

    .special-btn:hover{
        transform:scale(1.05);
        background: linear-gradient(145deg,#000000,#ffb400,#ffd700);
        color:#fff;
    }

    .review-box{
        /* background:#111; */
        padding:9px;
        border-radius:15px;
        max-width: 324px;
        margin:25px auto;  
    }


    .thankyou-box{
        max-width:520px;
        margin:30px auto;
        background: linear-gradient(135deg,#111,#000,#1f1f1f);
        border-radius:18px;
        padding:35px 25px;
        text-align:center;
        color:#fff;
        box-shadow:0 10px 30px rgba(0,0,0,.5);
        border:2px solid #ffd700;
    }

    .thankyou-box h3{
        margin-bottom:10px;
        background: linear-gradient(45deg,#ffd700,#ffae00,#fff);
        -webkit-background-clip:text;
        -webkit-text-fill-color:transparent;
        font-weight:800;
    }

    .thankyou-box p{
        font-size:16px;
        opacity:.9;
    }

    .thankyou-box .heart{
        font-size:32px;
        display:block;
        margin-top:8px;
    }

</style>

<style>
    .star-rating{
    direction: rtl;
    display: inline-flex;
    gap:5px;
}

.star-rating input{
    display:none;
}

.star-rating label{
    font-size:34px;
    color:#e5e0e0;
    cursor:pointer;
    transition:0.3s;
}

.star-rating label:hover,
.star-rating label:hover ~ label{
    color:#ffd700;
    transform:scale(1.1);
}

.star-rating input:checked ~ label{
    color:#ffd700;
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
            0 0 60px rgba(255,255,255,.15);border-radius: 10px;">

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
    @php $is_end = false; @endphp
    <div class="lesson-nav">
        @if ($prevLesson)
            <a href="{{ route('learning.page', ['course_slug' => $course->slug, 'lesson_id' => $prevLesson->id]) }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Prev
            </a>
        @else
            {{-- <span class="btn btn-secondary text-dark">Prev</span> --}}
            <span class="btn "></span>
        @endif

        @if ($nextLesson)
            <a href="{{ route('learning.page', ['course_slug' => $course->slug, 'lesson_id' => $nextLesson->id]) }}" class="btn btn-outline-primary">
                Next <i class="fas fa-arrow-right"></i>
            </a>
        @else
            <span class="btn btn-secondary text-dark d-none">Next</span>
            @php $is_end = true; @endphp
        @endif
    </div>

    {{-- 🔥 END OF COURSE UI --}}
    @if($is_end)
    <div class="end-lesson-box">

        <h3 class="text-white mb-4" style="font-weight:800;">🎉 Congratulations! You’ve completed the course.</h3>

        <div class="d-flex gap-3 flex-wrap justify-content-center">
            <a href="{{ route('community') }}" class="special-btn">
                Join Our Community
            </a>

            <a href="{{ route('user-dashboard') }}" class="special-btn">
                Join Our Affiliate Program
            </a>
        </div>

        {{-- ⭐ Course Review Section --}}
        @if(!$course->reviews()->where('user_id', auth()->id())->exists())
        <div class="review-box mt-4">
            <h4 class="text-white mb-3" style="font-weight:800;">✍️ Share Your Review</h4>

            <form action="{{ route('course.review.submit', $course->id) }}" method="POST">
                @csrf

                <div class="mb-3 text-center">
                    <label class="text-white d-block mb-2">Rating</label>

                    <div class="star-rating">
                        <input type="radio" name="rating" id="star5" value="5" required>
                        <label for="star5">★</label>

                        <input type="radio" name="rating" id="star4" value="4">
                        <label for="star4">★</label>

                        <input type="radio" name="rating" id="star3" value="3">
                        <label for="star3">★</label>

                        <input type="radio" name="rating" id="star2" value="2">
                        <label for="star2">★</label>

                        <input type="radio" name="rating" id="star1" value="1">
                        <label for="star1">★</label>
                    </div>
                </div>


                <div class="mb-3">
                    <label class="text-white">Your Feedback</label>
                    <textarea name="review" class="form-control" rows="4" placeholder="Write your thoughts..." required></textarea>
                </div>

                <button type="submit" class="special-btn w-100">
                    Submit Review
                </button>
            </form>
        </div>
        @else
        <div class="thankyou-box">
            <h3>🎉 Thank You!</h3>
            <p>Thanks for your beautiful review 🌟  
            Your feedback helps us improve and motivates other learners!</p>

            <span class="heart">💛</span>
        </div>
        @endif

    </div>
    @endif

</div>
@endsection
