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
<style>
    .cource-description li {
        text-align: left !important;
    }
    .cource-description ul {
        padding: 0;
    }
    .cource-description ul h5{
        font-weight: 800 !important;
        color: #f0bc4a;
    }
    .cource-description li {
        list-style: none;
        position: relative;
        padding-left: 36px;
        text-align: left !important;
        color: #faebd7;
    }


    .cource-description li::before{
        content:"";
        position:absolute;
        left:0;
        top:7px;
        width:20px;
        height:20px;
        background:url("{{ asset('assets/site-assets/checked.png') }}") no-repeat center center;
        background-size:contain;
    }
    .ineedblack{
        background-color: transparent !important;
        color: white;
    }
    .ineedblack:focus {
        color: #f1f3f5;
        background-color: var(--bs-body-bg);
        border-color: #eef1f5;
        outline: 0;
        box-shadow: 0 0 0 .25rem rgb(123 125 129 / 25%);
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
            <div class="row d-flex justify-content-center">
                {{-- <div class="col-lg-12 "> --}}
                <div class="col-lg-6 ">
                    <h4 class="hurry blue-second text-center mt-4" style="color: antiquewhite;" data-aos="fade-up">
                        Hurry Up! Seats Are Limited! 
                        <p style="padding-top:7px;">
                            @if($cource->offer_price)
                                <span style="color: antiquewhite;">Worth</span> 
                                <span class="price custom-strike px-2">₹{{ formatPrice($cource->price) }}/-</span>
                                <p style="margin-top: -10px; color: antiquewhite;font-size: 21px;">
                                    <span style="color: #f0bc4a;">Offer Price</span> <span class="offer">₹{{ formatPrice($cource->offer_price) }}/-</span> <span style="color: #f0bc4a;">Only</span>
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
                            <p class="mt-n5" style="color: white;">Enroll Now</p>
                        </button>
                    </div>
                    <div class="features text-center cource-description">
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
                    A complete digital business system with <span class="text-stroke-black">zero investment,</span>
                    proven growth strategies, expert training, community support,
                    and <span class="text-stroke-black">lifetime access.</span>
                </div>

                <div class="marquee-title">
                    A complete digital business system with <span class="text-stroke-black">zero investment,</span>
                    proven growth strategies, expert training, community support,
                    and <span class="text-stroke-black">lifetime access.</span>
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
                                <span>Is this training suitable for beginners?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                Yes. This program is 100% beginner-friendly. No prior experience or technical skills are required.
                            </p>
                        </div>

                        <div class="question" data-aos="fade-up" data-aos-delay="150">
                            <button class="faq-toggle">
                                <span>Do I really need zero investment to start?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                Yes. You will learn how to start a digital business without any upfront investment using free tools and proven strategies.
                            </p>
                        </div>

                        <div class="question" data-aos="fade-up" data-aos-delay="200">
                            <button class="faq-toggle">
                                <span>What format is the training provided in?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                The training includes pre-recorded video lessons, along with eBooks and PDF resources for easy learning.
                            </p>
                        </div>

                        <div class="question" data-aos="fade-up" data-aos-delay="250">
                            <button class="faq-toggle">
                                <span>Will I get live support?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                Yes. You will get access to weekly live sessions where you can interact, ask questions, and learn with the community.
                            </p>
                        </div>

                        <div class="question" data-aos="fade-up" data-aos-delay="300">
                            <button class="faq-toggle">
                                <span>What is VIP community access?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                VIP community is a private group where you can connect with other learners, get support, updates, and motivation.
                            </p>
                        </div>

                        <div class="question" data-aos="fade-up" data-aos-delay="350">
                            <button class="faq-toggle">
                                <span>Is there any earning opportunity?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                Yes. You will get access to an affiliate program, allowing you to earn by promoting our products.
                            </p>
                        </div>

                        <div class="question" data-aos="fade-up" data-aos-delay="400">
                            <button class="faq-toggle">
                                <span>How long will I have access to the course?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                You get lifetime access, including all future updates—no extra charges.
                            </p>
                        </div>

                        <div class="question" data-aos="fade-up" data-aos-delay="450">
                            <button class="faq-toggle">
                                <span>Can I learn at my own pace?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                Absolutely. Since the lessons are pre-recorded, you can learn anytime, anywhere, at your own speed.
                            </p>
                        </div>

                        <div class="question" data-aos="fade-up" data-aos-delay="500">
                            <button class="faq-toggle">
                                <span>Is this available only in India?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                This program is designed mainly for the Indian market, but anyone can join from anywhere.
                            </p>
                        </div>

                        <div class="question" data-aos="fade-up" data-aos-delay="550">
                            <button class="faq-toggle">
                                <span>How do I get access after purchase?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                You will receive instant access to the training and resources right after successful payment.
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6 col-md-12" data-aos="fade-up" data-aos-delay="500">
                    <div class="blue-second text-center">
                        <h5 class="blue-second" style="color: #97681A;">
                            Best Courses to Build a Successful Digital Business
                        </h5>
                    </div>

                    <div class="para text-center">
                        Our courses are carefully designed to provide the best learning path for building a successful digital business from the ground up. Each module focuses on essential skills such as setting up a business structure, understanding digital marketing basics, and learning proven strategies that work in today’s online world. With step-by-step guidance and actionable lessons, you will gain the confidence to turn your ideas into real results.
                    </div>

                    <div class="para text-center mt-3">
                        The Next Millionaire offers practical courses that focus on skills you can use immediately in the digital marketplace. Instead of vague theories, our training emphasizes real-world application, including social media growth strategies, content creation, and audience engagement techniques. These courses are ideal for beginners and entrepreneurs who want to build a profitable digital business that stands the test of time.
                    </div>

                    <div class="para text-center mt-3">
                        What makes our courses stand out is the combination of quality training and ongoing support. Along with video lessons and downloadable resources, you’ll get access to live sessions, expert feedback, and a community of learners who share your goals. This supportive ecosystem ensures you stay motivated, learn effectively, and grow consistently as you build your digital business.
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
                            <p>"{{ str_replace('&nbsp;', ' ', strip_tags($testimonial->message)) }}"</p>
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
                        <h5 class="blue-second pt-2">About Us</h5>

                        <p class="para pt-1" style="color:#A1A2B1; line-height:22px;">
                            <strong>Brand Name:</strong> The Next Millionaire <br>
                            <strong>Founder:</strong> Rahul Mondal <br>
                            <strong>Type:</strong> Digital Education & Online Training Platform
                        </p>

                        <p class="para pt-1" style="color:#A1A2B1; line-height:22px;">
                            <strong>Services:</strong><br>
                            Digital business training, social media growth education, and online learning programs.
                        </p>

                        <p class="para pt-1" style="color:#A1A2B1; line-height:22px;">
                            <strong>Access Type:</strong> Digital products & online training programs <br>
                            <strong>Operating Region:</strong> India (Global Access Available)
                        </p>


                        <h5 class="blue-second pt-3">Contact Us</h5>
                        {{-- <div class="para pt-1">
                            <strong>Email:</strong> help.thenextmillionaire@gmail.com <br>
                            <span style="color:#A1A2B1;">We usually respond within 24–48 hours.</span>
                        </div> --}}

                        <div class="para pt-2">
                            <strong>Email :</strong> <span>{{ get_setting('email_1') }}</span><br>
                            <span style="color:#A1A2B1;">We usually respond within 24–48 hours.</span>
                        </div>

                        {{-- <div class="para pt-2">
                            <strong>Phone :</strong> <span>{{ get_setting('contact_phone_1') }}</span>
                        </div> --}}
                    </div>
                </div>


                <div class="col-lg-6 mt-4" data-aos="fade">
                    <p class="para pt-1" style="color:#A1A2B1; line-height:22px;">
                        If you have any questions, need support, or require more information, feel free to reach out to us.
We’re here to help you.
                    </p>
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control ineedblack" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-2">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control ineedblack" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-2">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control ineedblack" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection