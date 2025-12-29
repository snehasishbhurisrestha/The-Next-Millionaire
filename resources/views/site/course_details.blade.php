@extends('layouts.web-app')

@section('title') Cource @endsection

@section('content')
<main>
    <article class="article">
        <section class="details_course1 heroSection bsb-hero-5 px-3 bsb-overlay mt-5">
            <div class="container">
                <div class="row align-items-center px-5">
                    <!-- Left empty column -->

                    <!-- Content column -->
                    <div class="col-12 col-md-8 col-lg-6 text-start gerw">
                        <h2 class="text-start fw-bold mb-4" style="font-size: 50px;color: #000 !important;">{{ $course->title }}</h2>

                        <p class="text-start lead text-dark" style="margin-bottom: 40px !important;color: #000 !important;">
                            {!! $course->description !!}
                        </p>
                        {{-- <a href="#" class="btn btn-primary square mb-2">Enroll Now</a>
                        <a href="#" class="btn btn-primary square mb-2">Price</a>
                        <p class="enrolled_course" style="font-size: 13px !important;color: #000 !important;">569,712 already
                        enrolled</p> --}}

                        @if(auth()->check())
                            @php
                                $isEnrolled = auth()->user()->enrollments()->where('course_id', $course->id)->exists();
                            @endphp

                            @if($isEnrolled)
                                <!-- Already Enrolled -->
                                <a href="{{ route('course.learn', $course->slug) }}" class="btn btn-success square mb-2">
                                    View Course
                                </a>
                            @else
                                @if($course->price > 0)
                                    <!-- Paid Course -->
                                    <a href="{{ route('course.enroll', $course->id) }}" class="btn btn-primary square mb-2">
                                        Enroll Now (₹{{ number_format($course->price, 2) }})
                                    </a>
                                @else
                                    <!-- Free Course -->
                                    <a href="{{ route('course.enroll', $course->id) }}" class="btn btn-primary square mb-2">
                                        Enroll Now (Free)
                                    </a>
                                @endif
                            @endif
                        @else
                            <!-- User Not Logged In -->
                            <a href="{{ route('login') }}" class="btn btn-warning square mb-2">
                                Login to Enroll
                            </a>
                        @endif
                        <p class="enrolled_course" style="font-size: 13px !important;color: #000 !important;">
                            450 already enrolled
                        </p>

                    </div>
                    <div class="col-12 col-md-2 col-lg-6"><img src="{{ $course->getFirstMediaUrl('course-image') }}" alt="" srcset=""></div>

                </div>
            </div>
        </section>

        <section class="details_course px-3 pt-5">
            <div class="container mt-4">
                <div class="row px-5">
                    <div class="course_shadow">
                        <!-- Nav Tabs -->
                        <ul class="nav nav-tabs px-2 py-2" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="intro-tab" data-bs-toggle="tab" data-bs-target="#intro"
                                type="button" role="tab">Introduction</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="art-fundamentals-tab" data-bs-toggle="tab"
                                data-bs-target="#art-fundamentals" type="button" role="tab">Art Fundamentals</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tattoo-techniques-tab" data-bs-toggle="tab"
                                data-bs-target="#tattoo-techniques" type="button" role="tab">Tattoo Techniques</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="safety-tab" data-bs-toggle="tab" data-bs-target="#safety" type="button"
                                role="tab">Safety & Hygiene</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="business-tab" data-bs-toggle="tab" data-bs-target="#business"
                                type="button" role="tab">Business & Career</button>
                            </li>   
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content mt-3 px-2 py-2" id="myTabContent">

                        <!-- Introduction -->
                        <div class="tab-pane fade show active" id="intro" role="tabpanel">
                            <h3>Welcome to Tattoo Design & Art Fundamentals</h3>
                            <p>This course is designed for aspiring tattoo artists who want to develop strong artistic skills and
                            understand the fundamentals of tattooing. Whether you're a beginner or looking to refine your
                            techniques, this course will guide you through the essential concepts of tattoo art.</p>
                        </div>

                        <!-- Art Fundamentals -->
                        <div class="tab-pane fade" id="art-fundamentals" role="tabpanel">
                            <h3>Art Fundamentals for Tattooing</h3>
                            <p>Before mastering tattooing, it’s important to develop strong artistic skills. This section covers:
                            </p>
                            <ul>
                            <li>Basic drawing techniques (line work, shading, and textures)</li>
                            <li>Understanding anatomy and body placement</li>
                            <li>Color theory and how it applies to tattoos</li>
                            <li>Design principles: composition, contrast, and balance</li>
                            </ul>
                        </div>

                        <!-- Tattoo Techniques -->
                        <div class="tab-pane fade" id="tattoo-techniques" role="tabpanel">
                            <h3>Essential Tattooing Techniques</h3>
                            <p>Here, we will explore the key techniques used by professional tattoo artists:</p>
                            <ul>
                            <li>Understanding tattoo machines and needles</li>
                            <li>Black & grey shading techniques</li>
                            <li>Color packing and blending</li>
                            <li>Linework precision and fine detailing</li>
                            </ul>
                        </div>

                        <!-- Safety & Hygiene -->
                        <div class="tab-pane fade" id="safety" role="tabpanel">
                            <h3>Safety, Hygiene, and Client Care</h3>
                            <p>Ensuring safety is crucial in tattooing. This module covers:</p>
                            <ul>
                            <li>Proper sterilization and hygiene practices</li>
                            <li>Avoiding cross-contamination</li>
                            <li>Understanding skin types and how they affect healing</li>
                            <li>Aftercare instructions for clients</li>
                            </ul>
                        </div>

                        <!-- Business & Career -->
                        <div class="tab-pane fade" id="business" role="tabpanel">
                            <h3>Building Your Career as a Tattoo Artist</h3>
                            <p>Turn your passion into a profession with these key business insights:</p>
                            <ul>
                            <li>Setting up your tattoo studio</li>
                            <li>Marketing your work through social media and portfolios</li>
                            <li>Understanding pricing and client consultations</li>
                            <li>Legal aspects and licensing requirements</li>
                            </ul>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bsb-hero-5 px-3">
            <div class="container">
                <div class="row header-banner pb-4">
                <div class="process-left">
                    <img src="{{ asset('assets/site-assets/img/banner/360.jpg') }}" width="1200" height="1304"
                    alt="ISO Certification ISO 9001, ISO 14001, ISO 45001">

                    <!-- <img class="audit appear inview" src="/assets/img/certification.svg" alt="ISO Certification HACCP, FSSC 22000, ISO 22000"> -->
                </div>
                <div class="process-right">
                    <div class="text">
                    <h3>Course Overview</h3>
                    <p>This course is designed for aspiring tattoo artists, illustrators, and enthusiasts who want to learn
                        the core principles of tattoo design and art. Covering everything from drawing fundamentals to
                        tattoo-specific techniques, this course will help you build a strong foundation for creating
                        professional tattoo designs.</p>

                    </div>
                    <!-- <img src="https://www.tqcsi.com/uploads/_resized/_portraitSmall/11352/Christine.webp" width="250"
                                height="714" alt="ISO certification ISO/IEC 27001, AS 9100, ISO 55001"> -->
                </div>
                </div>
            </div>
        </section>

        <section class="details_course benefits px-3 py-5">
            <div class="container">
                <h3 class=" mb-4 px-5">Why Take This Course?</h3>
                <div class="row px-5">
                <div class="col-md-4">
                    <div class="benefit-box p-3 shadow-sm">
                    <i class="fa-solid fa-paint-brush fa-2x mb-2"></i>
                    <h5>Master Artistic Techniques</h5>
                    <p>Improve your drawing, shading, and color blending skills essential for tattoo design.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="benefit-box p-3 shadow-sm">
                    <i class="fa-solid fa-hand-holding-medical fa-2x mb-2"></i>
                    <h5>Learn Safety & Hygiene</h5>
                    <p>Understand sterilization, skin types, and best practices for safe tattooing.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="benefit-box p-3 shadow-sm">
                    <i class="fa-solid fa-briefcase fa-2x mb-2"></i>
                    <h5>Start Your Tattoo Career</h5>
                    <p>Gain business knowledge, marketing strategies, and licensing insights to succeed.</p>
                    </div>
                </div>
                </div>
            </div>
        </section>
        <section class="details_course faq px-3 py-5 bg-light">
            <div class="container">
                <h3 class="text-center mb-4 px-5">Frequently Asked Questions</h3>
                <div class="accordion px-5" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        Do I need prior drawing experience?
                    </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        No, this course covers art fundamentals, making it beginner-friendly.
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo">
                        Is certification provided?
                    </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        Yes, upon completion, you will receive a certification recognized in the industry.
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree">
                        Can I take this course online?
                    </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        Yes, we offer both online and in-person training options.
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </section>
    </article>
</main>
@endsection