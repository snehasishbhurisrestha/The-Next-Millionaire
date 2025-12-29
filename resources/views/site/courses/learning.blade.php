@extends('layouts.web-app')

@section('style')
    <style>
        .a_hover:hover {
            border-radius: 10px;
            background-color: #00225b;
            color: #ffffff !important;
            text-decoration: none
        }

        a.a_hover.p-2 {
            text-decoration: none;
            color: #000;
        }

        .col-md-3 {
            box-shadow: 13px 0px 24px -19px #999;
            background: #f1f1f1;
            border-radius: 15px;
        }

        .col-md-3 ul {
            list-style: none;
        }

        .col-md-3 ul {
            padding-left: 0px;
        }

        .col-md-8 {
            background: #f1f1f1;
            border-radius: 15px;
            justify-content: space-between;
            display: flex;
            flex-direction: column;
        }

        .col-md-8 button {
            background-color: #113995;
            width: 80px;
            height: 40px;
            border-radius: 30px;
            top: 40%;
            color: #000;
            opacity: 1;
            box-shadow: 0px 0px 5px 0px #00000036;
            border: 2px solid #fff;
        }
        .col-md-8 button span{
            color: #fff;
            font-weight: 600;    
        }
        .carousel-control-next-icon{
            width: 15px;
        }
        .carousel-control-prev-icon{
            width: 15px;
        }
    </style>
@endsection


@section('title')
    Learning
@endsection

@section('content')
    <main>
        <!-- Sidebar -->
        <article class="article">
            <div class="container p-3 bsb-overlay mt-5">
                <div class="row gap-3 justify-content-center">
                    <!-- Sidebar -->
                    <div class="col-md-3 p-4">
                        <h3 class="mb-3">{{ $course->title }}</h3>
                        <hr>
                        <ul style="z-index: 99999;position: relative;">
                            @foreach ($lessons as $lesson)
                                <li class="my-1">
                                    <a href="{{ route('course.learn', ['course_slug' => $course->slug, 'lesson_id' => $lesson->id]) }}"
                                        class="a_hover p-2">
                                        {{ $lesson->title }}
                                    </a>
                                </li>
                                <hr>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Content Area -->
                    <div class="col-md-8 p-4">
                        <div>
                            @if ($currentLesson)
                                <h2>{{ $currentLesson->title }}</h2>
                                <p>{!! $currentLesson->content !!}</p>
                            @else
                                <p>No lesson selected.</p>
                            @endif
                        </div>
                        {{-- <div class="d-flex justify-content-between">
                            <button><span class="d-flex justify-content-center"><p class="carousel-control-prev-icon me-1"></p><p class="d-flex align-items-center">Prev</p></span></button>
                            <button><span class="d-flex justify-content-center"><p class="d-flex align-items-center">Next</p><p class="carousel-control-next-icon ms-1"></p></span></button>
                        </div> --}}
                        <div class="d-flex justify-content-between" style="z-index: 99999;">
                            @if ($prevLesson)
                                <a href="{{ route('course.learn', ['course_slug' => $course->slug, 'lesson_id' => $prevLesson->id]) }}">
                                    <span class="d-flex align-items-center">
                                        <p class="carousel-control-prev-icon me-1"></p> Prev
                                    </span>
                                </a>
                            @else
                                <span class="btn btn-secondary disabled">Prev</span>
                            @endif
                        
                            @if ($nextLesson)
                                <a href="{{ route('course.learn', ['course_slug' => $course->slug, 'lesson_id' => $nextLesson->id]) }}">
                                    <span class="d-flex align-items-center">
                                        Next <p class="carousel-control-next-icon ms-1"></p>
                                    </span>
                                </a>
                            @else
                                <span class="btn btn-secondary disabled">Next</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- <nav aria-label="Page navigation example ">
                    <ul class="pagination justify-content-end me-4 my-4">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav> --}}

            </div>
            </div>
        </article>
    </main>
@endsection
