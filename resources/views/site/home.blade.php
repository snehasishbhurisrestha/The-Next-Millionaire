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
    .text-stroke-yellow{
        -webkit-text-stroke: 1px #FFBA06;
    color: transparent;
    }
</style>

<style>
    .course-section {
        background: #000;
        color: #fff;
        padding: 60px 0;
    }
    
    /* Image */
    .course-img {
        border-radius: 12px;
    }
    
    .price-badge {
        /*position: absolute;*/
        top: 20px;
        right: 20px;
    
        background: linear-gradient(45deg, #ff9800, #ffc107);
        color: #000;
    
        padding: 8px 16px;
        border-radius: 25px;
    
        font-weight: bold;
        font-size: 25px;
    
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    
    .price-badge span {
        font-size: 27px;
    }

    /* Countdown Box (if not added already) */
    .countdown-box {
        /*position: absolute;*/
        /*bottom: 20px;*/
        /*left: 50%;*/
        /*transform: translateX(-50%);*/
    
        background: rgba(0,0,0,0.8);
        padding: 15px 25px;
        border-radius: 10px;
    
        display: flex;
        gap: 25px;
        justify-content: center;
    }
    
    /* Timer Item */
    .time-box h3 {
        color: #ffc107;
        margin: 0;
        font-size: 32px;
    }
    
    .time-box span {
        font-size: 13px;
        color: #fff;
    }
    
    /* Lessons */
    .lesson-list li {
        display: flex;
        align-items: center;
        justify-content: space-between;
    
        padding: 12px 0;
        border-bottom: 1px solid #222;
        font-size: 18px;
        color: #faebd7;
    }
    
    .lesson-list i {
        margin-right: 10px;
    }
    
    .lesson-list li span {
        color: #ffc107;
        font-size: 21px;
        text-align: right;
        white-space: nowrap; /* ✅ Prevent line break */
    }
    
    .trust-stats {
        text-align: center;
    }
    
    .trust-box {
        /*background: #fff;*/
        border: 2px solid #f1c40f; /* Yellow Border */
        color: #fff;
        padding: 10px 22px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 22px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .trust-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }
    
    .custom-del {
        position: relative;
        display: inline-block;
        font-size: 48px !important;
    }

    @media (max-width: 1200px) {
        .custom-del {
            font-size: 38px !important;
        }
    }
    @media (max-width: 992px) {
        .custom-del {
            font-size: 30px !important;
        }
    }
    @media (max-width: 768px) {
        .custom-del {
            font-size: 40px !important;
        }
    }
    @media (max-width: 576px) {
        .custom-del {
            font-size: 40px !important;
        }
    }
    .custom-del::after {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 3px;
        background: #ff0018;
        transform: translateY(-50%) rotate(10deg);
    }

    .custom-del1 {
        position: relative;
        display: inline-block;
        font-size: 24px !important;  /* ← increase from 23px to 30px */
    }

    .custom-del1::after {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 3px;
        background: #ff0018;
        transform: translateY(-50%) rotate(10deg);  /* ← also fix this line */
    }

</style>

<style>
    .customh2{
        color: #f3f9ff;
        margin-top: 0px; 
        font-size: 20px;
    }
</style>
@endsection

@section('content')

    <section class="course-sell-wrapper wrap py-7">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-lg-8 col-md-10 col-12 text-center  mt-4">

                    <div class="course-sell-text" data-aos="fade-up" style="box-shadow: 0 0 25px rgba(255,255,255,.45), 0 0 60px rgba(255,255,255,.15);border-radius: 10px;">
                        <div class="video-section">
                            <div class="video-container mb-4 mt-4" data-aos="zoom-in">
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
                    <h4 class="hurry blue-second text-center mt-4" style="color: antiquewhite;">
                        Hurry Up! Seats Are Limited! 
                        <p style="padding-top:7px;">
                            @if($cource->offer_price)
                                {{--<span style="color: antiquewhite;">Worth</span> 
                                <span class="price custom-strike px-2">₹{{ formatPrice($cource->price) }}/-</span>
                                <p style="margin-top: -10px; color: antiquewhite;font-size: 21px;">
                                    <span style="color: #f0bc4a;">Valentine Week Offer Price</span> <span class="offer">₹{{ formatPrice($cource->offer_price) }}/-</span> <span style="color: #f0bc4a;">Only</span>
                                </p>--}}
                                <button class="px-4  price-badge"
                                        onclick="window.location='{{ route('registration') }}'">
                                    <p class="mt-n5" style="color: #000;font-size: 25px;">Join Now For <span class="custom-del1">₹{{ formatPrice($cource->price) }}</span> ₹{{ formatPrice($cource->offer_price) }}</p>
                                    <p style="color: #000;    font-size: 16px;" >(DOUBLE MONEY BACK GUARANTEE)</p>
                                </button>
                                
                                <div class="countdown-box">
    
                                    <div class="time-box">
                                        <h3 id="hourss">00</h3>
                                        <span>Hours</span>
                                    </div>
                
                                    <div class="time-box">
                                        <h3 id="minutess">00</h3>
                                        <span>Minutes</span>
                                    </div>
                
                                    <div class="time-box">
                                        <h3 id="secondss">00</h3>
                                        <span>Seconds</span>
                                    </div>
                
                                </div>
                            @else
                                Price 
                                <span class="price">{{ $cource->price }}/-</span>
                            @endif
                        </p>
                    </h4>


                    <!-- Button -->
                    {{--<div class="btnnn text-center ">
                        <button class="buy-now px-4 mb-4"
                                onclick="window.location='{{ route('registration') }}'">
                            <p class="mt-n5" style="color: white;">Enroll Now</p>
                        </button>
                    </div>--}}
                    {{--<div class="features text-center cource-description">
                        {!! $cource->description !!}
                    </div>--}}

                </div>
            </div>
        </div>
    </section>

    <section class="marquee my-7">
        <h3>
            <div class="marquee-wrapper">
                <div class="marquee-title" style="color:#FFBA06">
                    LIMITED TIME OFFER – <span class="">85% OFF</span> |
                    WORTH <span class="custom-del">₹5,499</span> NOW ONLY
                    <span class="">₹799</span> |
                    <span class="">SALE IS LIVE!</span>
                </div>
                <div class="marquee-title" style="color:#FFBA06">
                    LIMITED TIME OFFER – <span class="">85% OFF</span> |
                    WORTH <span class="custom-del">₹5,499</span> NOW ONLY
                    <span class="">₹799</span> |
                    <span class="">SALE IS LIVE!</span>
                </div>
                <div class="marquee-title" style="color:#FFBA06">
                    LIMITED TIME OFFER – <span class="">85% OFF</span> |
                    WORTH <span class="custom-del">₹5,499</span> NOW ONLY
                    <span class="">₹799</span> |
                    <span class="">SALE IS LIVE!</span>
                </div>
                <div class="marquee-title" style="color:#FFBA06">
                    LIMITED TIME OFFER – <span class="">85% OFF</span> |
                    WORTH <span class="custom-del">₹5,499</span> NOW ONLY
                    <span class="">₹799</span> |
                    <span class="">SALE IS LIVE!</span>
                </div>
                <div class="marquee-title" style="color:#FFBA06">
                    LIMITED TIME OFFER – <span class="">85% OFF</span> |
                    WORTH <span class="custom-del">₹5,499</span> NOW ONLY
                    <span class="">₹799</span> |
                    <span class="">SALE IS LIVE!</span>
                </div>
            </div>
        </h3>
    </section>
    
    @if($testimonial_screenshorts->isNotEmpty())
    <section>
        <div class="container pt-5">
            <div class="row">
                <h3 class="text-center">
                    Our Happy Students!
                </h3>
                <h2 class="para text-center">
                    We value your input and are committed to continuous improvement.
                </h2>
            </div>

            <div class="col-lg-12 pt-5">
                <!--<div class="owl-carousel owl-carousel2 owl-theme">-->
                <div class="owl-carousel owl-carousel1 owl-theme">
                    <!--<div class="main-div1">-->
                    @foreach($testimonial_screenshorts as $testimonial_screenshort)
                    <div class="item">
                        <img src="{{ $testimonial_screenshort->getFirstMediaUrl('testimonialss') }}" class="preview-img">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
    
    <section class="course-section">
        <div class="container">
            <div class="row align-items-center">
    
                <!-- Left Image + Timer -->
                <div class="col-lg-6 col-md-12 text-center py-4 position-relative">
    
                    <img src="{{ asset('assets/site-assets/images/corsrimg.avif') }}"
                         class="img-fluid course-img"
                         alt="Course Image">
    
                    <!-- Timer -->
                    <div class="countdown-box">
    
                        <div class="time-box">
                            <h3 id="hours">00</h3>
                            <span>Hours</span>
                        </div>
    
                        <div class="time-box">
                            <h3 id="minutes">00</h3>
                            <span>Minutes</span>
                        </div>
    
                        <div class="time-box">
                            <h3 id="seconds">00</h3>
                            <span>Seconds</span>
                        </div>
    
                    </div>
                    
                    <!-- Price Tag -->
                    <!--<div class="price-badge">-->
                    <!--    Today Only : <span>₹1599</span>-->
                    <!--</div>-->
                     <button class="px-4 mb-4 price-badge"
                            onclick="window.location='{{ route('registration') }}'">
                        <p class="mt-n5" style="color: #000;font-size: 25px;">Join Now For <span class="custom-del1">₹{{ formatPrice($cource->price) }}</span> ₹{{ formatPrice($cource->offer_price) }}</p>
                        <p style="color: #000;    font-size: 16px;" >(DOUBLE MONEY BACK GUARANTEE)</p>
                    </button>
    
                </div>
    
    
                <!-- Right Lessons -->
                <div class="col-lg-6 col-md-12">
    
                    <ul class="list-unstyled lesson-list">
                        @foreach($cource->contents as $content)
                        <li>
                            <i class="fa-solid fa-check text-warning"></i>
                            {{ $content->title }}
                            <span>5 min</span>
                        </li>
                        @endforeach
    
                    </ul>
    
                </div>
                
               
            </div>
        </div>
    </section>
    
    @if($testimonial_videos->isNotEmpty())
    <section>
        <div class="container pt-5">
            <div class="row">
                <h3 class="text-center">
                    What Our Students Are Saying!
                </h3>
                <h2 class="para text-center">
                    We value your input and are committed to continuous improvement.
                </h2>
            </div>

            <div class="col-lg-12 pt-5">
                <!--<div class="owl-carousel owl-carousel2 owl-theme">-->
                <div class="owl-carousel owl-carousel3 owl-theme">
                    <!--<div class="main-div1">-->
                    @foreach($testimonial_videos as $testimonial_video)
                    <div class="item">
                        {!! $testimonial_video->video_url !!}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif




    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mt-5" >
                    <h3>Frequently Asked Questions</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 text-center py-4">
                    <div class="questions-container">
                        <div class="question">
                            <button class="faq-toggle">
                                <span>Is this training suitable for beginners?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                Yes. This program is 100% beginner-friendly. No prior experience or technical skills are required.
                            </p>
                        </div>

                        <div class="question">
                            <button class="faq-toggle">
                                <span>Do I really need zero investment to start?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                Yes. You will learn how to start a digital business without any upfront investment using free tools and proven strategies.
                            </p>
                        </div>

                        <div class="question">
                            <button class="faq-toggle">
                                <span>What format is the training provided in?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                The training includes pre-recorded video lessons, along with eBooks and PDF resources for easy learning.
                            </p>
                        </div>

                        <div class="question">
                            <button class="faq-toggle">
                                <span>Will I get live support?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                Yes. You will get access to weekly live sessions where you can interact, ask questions, and learn with the community.
                            </p>
                        </div>

                        <div class="question">
                            <button class="faq-toggle">
                                <span>What is VIP community access?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                VIP community is a private group where you can connect with other learners, get support, updates, and motivation.
                            </p>
                        </div>

                        <div class="question">
                            <button class="faq-toggle">
                                <span>Is there any earning opportunity?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                Yes. You will get access to an affiliate program, allowing you to earn by promoting our products.
                            </p>
                        </div>

                        <div class="question">
                            <button class="faq-toggle">
                                <span>How long will I have access to the course?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                You get lifetime access, including all future updates—no extra charges.
                            </p>
                        </div>

                        <div class="question">
                            <button class="faq-toggle">
                                <span>Can I learn at my own pace?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                Absolutely. Since the lessons are pre-recorded, you can learn anytime, anywhere, at your own speed.
                            </p>
                        </div>

                        <div class="question">
                            <button class="faq-toggle">
                                <span>Is this available only in India?</span>
                                <i class="fas fa-chevron-down d-arrow"></i>
                            </button>
                            <p class="answer">
                                This program is designed mainly for the Indian market, but anyone can join from anywhere.
                            </p>
                        </div>

                        <div class="question">
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

                <div class="col-lg-6 col-md-12">
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
                <!-- Heading -->
                <div class="col-lg-12 pt-5 text-center">
                    <h3>Student Testimonials!</h3>
    
                    <!-- Trust Stats -->
                    <div class="trust-stats d-flex justify-content-center gap-4 mt-3 mb-3 flex-wrap">
                        <div class="trust-box text-warning">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                            <span>4.8</span>
                        </div>
                    
                        <div class="trust-box">
                            🎓 1000+ Happy Students
                        </div>
                    
                    </div>

    
                    <p class="para">
                        Read what future leaders are saying — and share
                        your path to success.
                    </p>
                </div>
                {{--<div class="col-lg-12 pt-5">
                    <h3 class="text-center">From Learners to Millionaires</h3>
                    <p class="text-center para">Read what future leaders are saying — and share
                        your path to success.</p>
                </div>--}}
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
    
    
    <section class="mt-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 col-md-12 mb-3">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mb-3 text-center">
                            <img src="{{ asset('assets/site-assets/images/moneyback.png') }}"
                                 class="img-fluid course-img"
                                 alt="Money Back Guarantee"
                                 style="height:auto;">
                            </div>
                        <div class="col-md-8 col-sm-8 d-flex flex-column justify-content-center">
                            <h2 class="customh2">100% Double Money Back Guarantee</h2>
                            <p>We proudly offer a Double Money-Back Guarantee on our course. If you consistently apply everything taught inside the course for a continuous period of six months and still do not achieve any measurable results, we will refund double the amount you originally paid to enroll. To qualify, you must provide valid proof that you implemented the training with full consistency and effort for the entire six months. You can claim this guarantee by contacting our official WhatsApp support team and submitting the required proof for review, and once your claim is approved, your double refund will be processed within 24 hours.</p>
                        </div>
                    </div>
                </div>
    
    
                <!-- Right Lessons -->
                <!--<div class="col-lg-6 col-md-12">-->
                <!--    <div class="row">-->
                <!--        <div class="col-md-4 col-sm-4 mb-3">-->
                <!--            <img src="{{ asset('assets/site-assets/images/secure.png') }}" class="img-fluid course-img" alt="Course Image">-->
                <!--        </div>-->
                <!--        <div class="col-md-8 col-sm-8 d-flex flex-column justify-content-center">-->
                <!--            <h2 class="customh2">Secure Payment Processing</h2>-->
                <!--            <p>Each order is processed through a secure, 256-bit encrypted payment processing gateway to ensure your privacy.</p>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
        </div>
    </section>

    <section id="contact">
        <div class="container py-2">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3>Connect With Us</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 pt-4">
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
                            <strong>WhatsApp :</strong> <span>{{ get_setting('contact_phone_1') }}</span><br>
                            <span style="color:#A1A2B1;">We usually respond within 24–48 hours.</span>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6 mt-4">
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

@section('script')
<script>
    // 15 minutes in milliseconds
    let duration = 15 * 60 * 1000;

    // Set end time when page loads
    let endTime = new Date().getTime() + duration;

    function updateTimer() {

        let now = new Date().getTime();
        let diff = endTime - now;

        if (diff <= 0) {
            diff = 0;
            clearInterval(timerInterval);
        }

        let minutes = Math.floor(diff / (1000 * 60));
        let seconds = Math.floor((diff % (1000 * 60)) / 1000);

        document.getElementById("minutes").innerHTML =
            minutes.toString().padStart(2, '0');
            
        document.getElementById("minutess").innerHTML =
            minutes.toString().padStart(2, '0');

        document.getElementById("seconds").innerHTML =
            seconds.toString().padStart(2, '0');
            
        document.getElementById("secondss").innerHTML =
            seconds.toString().padStart(2, '0');
    }

    let timerInterval = setInterval(updateTimer, 1000);
    updateTimer();
</script>


@endsection