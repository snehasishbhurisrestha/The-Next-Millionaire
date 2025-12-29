@extends('layouts.web-app')

@section('title') Home @endsection

@section('style')
<link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
<script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
<style>
    * {
        overflow-anchor: none;
    }
    .video-wrapper {
        position: relative;
        width: 100%;
        max-width: 1000px;
        aspect-ratio: 16 / 9;
    }

    .video-wrapper iframe {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    html {
        scroll-padding-top: 80px; /* header height */
    }

    iframe {
        border-radius: 10px;
    }
</style>
@endsection

@section('content')

    <section class="course-sell-wrapper wrap py-7">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-lg-8 col-md-10 col-12 text-center  mt-4">

                    <div class="course-sell-text" data-aos="fade-up" style="box-shadow: 0 0 25px rgba(255,255,255,.45), 
            0 0 60px rgba(255,255,255,.15);border-radius: 10px;">
                        <div class="video-section">
                            <div class="video-container mb-4 mt-4" data-aos="zoom-in">
                                {{-- @if($cource->video_url)
                                    @php
                                        $videoId = '';
                                        if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $cource->video_url, $matches)) {
                                            $videoId = $matches[1];
                                        } elseif (preg_match('/youtu\.be\/([^?]+)/', $cource->video_url, $matches)) {
                                            $videoId = $matches[1];
                                        } elseif (preg_match('/youtube\.com\/shorts\/([^?]+)/', $cource->video_url, $matches)) {
                                            $videoId = $matches[1];
                                        }
                                    @endphp
                            
                                    @if($videoId)
                                        <div class="ratio ratio-16x9">
                                            <iframe
                                                id="myVideo"
                                                src="https://www.youtube.com/embed/{{ $videoId }}?controls=1&cc_load_policy=0&modestbranding=1&rel=0&fs=1&playsinline=1"
                                                title="YouTube video"
                                                allow="autoplay; fullscreen"
                                                allowfullscreen>
                                            </iframe>

                                        </div>
                                    @endif
                                @endif --}}

                                {{-- @if ($cource->getFirstMediaUrl('course-video'))
                                    <video
                                        id="myVideo"
                                        class="video-js vjs-default-skin vjs-big-play-centered vjs-fluid"
                                        controls
                                        preload="auto"
                                        data-setup='{
                                            "fluid": true,
                                            "aspectRatio": "16:9"
                                        }'>
                                        <source src="{{ $cource->getFirstMediaUrl('course-video') }}" type="video/mp4">
                                    </video>
                                @else
                                    <p class="text-danger mt-3">No video available.</p>
                                @endif --}}
                                @if($cource->video_url)
                                    {!! $cource->video_url !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 ">
                    <h4 class="hurry blue-second text-center mt-4" style="color: antiquewhite;" data-aos="fade-up">
                        Hurry Up! Seats Are Limited! 
                        <p>
                            @if($cource->offer_price)
                                The Selling Price 
                                <span class="price custom-strike px-2">{{ $cource->price }}/-</span>
                                <p style="margin-top: -10px">
                                    Offer Price <span class="offer">{{ $cource->offer_price }}/-</span> Only
                                </p>
                            @else
                                Price 
                                <span class="price">{{ $cource->price }}/-</span>
                            @endif
                        </p>
                    </h4>


                    <!-- Button -->
                    <div class="btnnn text-center ">
                        <button class="buy-now px-4 mb-4" data-aos="fade-up" 
                                onclick="window.location='{{ route('registration') }}'">
                            <p class="mt-n5" style="color: white;">Buy Now</p>
                        </button>
                    </div>
                    <div class="features text-center">
                        {!! $cource->description !!}
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="marquee my-7">
        <h3>
            <div class="marquee-wrapper">
                <div class="marquee-title">
                    Becoming the <span class="text-stroke-black">Next Millionaire</span>
                    &amp; offers financial freedom,
                    <span class="text-stroke-black">global influence,</span> We think
                    <span class="text-stroke-black"> and the ability to drive change</span>
                    &amp; through business and philanthropy.
                    <span class="text-stroke-black">It opens doors to luxury,</span>
                </div>
                <div class="marquee-title">
                    innovation, <span class="text-stroke-black">and lasting legacy.</span>

                </div>
            </div>
        </h3>
    </section>


    {{-- <section>
        <div class="container pt-5">
            <div class="row">
                <h3 class="text-center" data-aos="fade-up">
                    Your Feedback, Our Future!
                </h3>
                <h2 class="para text-center" data-aos="fade-up" data-aos-delay="100">
                    We value your input and are committed to continuous improvement.
                </h2>
            </div>

            <div class="col-lg-12 pt-5">
                <div class="owl-carousel owl-carousel2 owl-theme">
                    <div class="main-div1" data-aos="fade-up" data-aos-delay="200">
                        <video controls>
                            <source src="{{ asset('assets/site-assets/video/video2.mp4') }}" type="video/mp4">
                        </video>
                    </div>

                    <div class="main-div1" data-aos="fade-up" data-aos-delay="300">
                        <video controls>
                            <source src="{{ asset('assets/site-assets/video/video3.mp4') }}" type="video/mp4">
                        </video>
                    </div>

                    <div class="main-div1" data-aos="fade-up" data-aos-delay="400">
                        <video controls>
                            <source src="{{ asset('assets/site-assets/video/video4.mp4') }}" type="video/mp4">
                        </video>
                    </div>

                    <div class="main-div1" data-aos="fade-up" data-aos-delay="500">
                        <video controls>
                            <source src="{{ asset('assets/site-assets/video/video2.mp4') }}" type="video/mp4">
                        </video>
                    </div>
                    <div class="main-div1" data-aos="fade-up" data-aos-delay="600">
                        <video controls>
                            <source src="{{ asset('assets/site-assets/video/video4.mp4') }}" type="video/mp4">
                        </video>
                    </div>
                    <div class="main-div1" data-aos="fade-up" data-aos-delay="700">
                        <video controls>
                            <source src="{{ asset('assets/site-assets/video/video3.mp4') }}" type="video/mp4">
                        </video>
                    </div>
                    <div class="main-div1" data-aos="fade-up" data-aos-delay="800">
                        <video controls>
                            <source src="{{ asset('assets/site-assets/video/video2.mp4') }}" type="video/mp4">
                        </video>
                    </div>
                    <div class="main-div1" data-aos="fade-up" data-aos-delay="900">
                        <video controls>
                            <source src="{{ asset('assets/site-assets/video/video4.mp4') }}" type="video/mp4">
                        </video>
                    </div>
                    <div class="main-div1" data-aos="fade-up" data-aos-delay="1000">
                        <video controls>
                            <source src="{{ asset('assets/site-assets/video/video3.mp4') }}" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}




    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mt-5" data-aos="fade-up">
                    <h3>Frequently Asked Questions</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 text-center py-4">
                    <div class="questions-container">
                        <div class="question" data-aos="fade-up" data-aos-delay="100">
                            <button class="faq-toggle">
                                <span>How can I become a millionaire as a developer?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">To become a millionaire as a developer, focus on mastering high-demand skills, building scalable projects, and looking for opportunities in startups, freelance, or creating your own tech company. Additionally, passive income through coding-related content, such as courses or YouTube channels, can also help grow wealth.</p>
                        </div>

                    <div class="question" data-aos="fade-up" data-aos-delay="200">
                            <button class="faq-toggle">
                                <span>What are the best side hustles for developers?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">Some popular side hustles include freelance web development, creating and selling digital products (themes, plugins), developing mobile apps, and contributing to open-source projects. Consulting or mentoring other developers is another way to earn extra income while sharing your expertise.</p>
                        </div>

                        <!-- FAQ 3 -->
                        <div class="question" data-aos="fade-up" data-aos-delay="300">
                            <button class="faq-toggle">
                                <span>What are the most lucrative programming languages to learn?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">Languages like Python, Go, Rust, and Kotlin tend to offer higher-paying opportunities, especially in fields such as machine learning, system programming, and mobile app development. JavaScript and its related frameworks (React, Node.js) remain in high demand for web development.</p>
                        </div>

                        <!-- FAQ 4 -->
                        <div class="question" data-aos="fade-up" data-aos-delay="400">
                            <button class="faq-toggle">
                                <span>How can I scale my freelance career in tech?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">Scaling your freelance career involves building a personal brand, offering niche services, increasing rates as you gain experience, and outsourcing or collaborating with other professionals. Networking and maintaining strong client relationships will help sustain long-term growth.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12" data-aos="fade-up" data-aos-delay="500">
                    <div class="blue-second text-center">
                        <h5 class="blue-second" style="color: #97681A;">Best Courses to Become a Successful Developer</h5>
                    </div>
                    <div class="para text-center">
                        Explore our curated selection of top-rated courses designed to help you master the skills needed to thrive in the tech industry. Whether you're a beginner or looking to advance your career, our expert-led courses cover everything from programming languages and web development to data science and machine learning. Start your journey to becoming a successful developer today!
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($testimonials->isNotEmpty())
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-5"data-aos="fade-up" data-aos-delay="500">
                    <h3 class="text-center">From Learners to Millionaires</h3>
                    <p class="text-center para">Read what future leaders are saying — and share
                        your path to success.</p>
                </div>
                <div class="col-lg-12 pt-4">
                    <div class="owl-carousel owl-carousel1 owl-theme">
                        @foreach ($testimonials as $testimonial)
                        <div class="item">

                            <h5>{{ $testimonial->name }}</h5>
                            <p>"{{ strip_tags($testimonial->message) }}"</p>
                            <div class="rating">
                                @for ($i = 1; $i <= $testimonial->rating; $i++)
                                    <span>⭐</span>
                                @endfor
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section id="contact">
        <div class="container py-2">
            <div class="row">
                <div class="col-lg-12 text-center" data-aos="fade-up">
                    <h3>Connect With Us</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 pt-4" data-aos="fade">
                    <div class="company-details">
                        <h5 class="blue-second pt-2">Company Details</h5>

                        <p class="para pt-1" style="color:#A1A2B1; line-height:22px;">
                            Empowering Ambitions,<br>
                            Creating Opportunities,<br>
                            Building Tomorrow’s Millionaires
                        </p>

                        <div class="para pt-2"><strong>Emails : </strong>
                            <span>{{ get_setting('email_1') }}</span>
                        </div>

                        <div class="para pt-2"><strong>Phone : </strong>
                            <span>{{ get_setting('contact_phone_1') }}</span>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6" data-aos="fade">
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control1" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-2">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control1" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-2">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection