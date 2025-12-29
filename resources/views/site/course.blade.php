@extends('layouts.web-app')

@section('title') Cource @endsection

@section('content')
<main>
    <article class="article">
        <section class="topBanner heroSection bsb-hero-5 px-3 bsb-overlay mt-5" style="background-image: url('{{ asset('assets/site-assets/img/course/course_img.jpg') }}');">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left empty column -->
                    <div class="col-12 col-md-2"></div>
                    <!-- Content column -->
                    <div class="col-12 col-md-8 text-start gerw">
                        <h2 class="text-center text-start fw-bold mb-4" style="font-size: 50px;">Courses</h2>

                        <p class="lead text-white mb-5"> There are three ways to ultimate success: The first way is to be kind.
                            The second way is to be kind. The third way is to be kind.</p>
                    </div>
                    <div class="col-12 col-md-2"></div>
                </div>
            </div>
        </section>


        <section class="courses">
            <div class="container">
                <div class="row">
                    <h2 class="text-dark text-center fw-bold mb-4" style="font-size: 50px;">Courses We Provide</h2>

                    <div class="d-flex flex-wrap col-lg-12 text-design">
                        @foreach($courses as $course)
                        <div class="col-lg-4">
                            <a href="{{ route('course-details',$course->slug) }}">
                                <div class="card" style="width: 18rem;">
                                    <div class="design">
                                        <img class="card-img-top" src="{{ $course->getFirstMediaUrl('course-image') }}" alt="Card image cap">
                                        <div class="card-body">

                                            <h5 class="card-title">{{ $course->title }}</h5>
                                            <p class="card-text">{!! $course->description !!}</p>

                                        </div>
                                        <div class="card-body">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star-half-stroke"></i>
                                            <span>4.9</span>
                                            <span class="reviews_course">3.6K reviews</span>
                                            <p>Beginner · Specialization · 1 - 3 Months</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                        {{-- <div class="col-lg-4">
                            <a href="{{ route('course-details') }}">
                            <div class="card" style="width: 18rem;">
                                <div class="design">
                                <img class="card-img-top" src="{{ asset('assets/site-assets/img/tattoo/tattoo2.jpg') }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Stencil Making & Transfer Techniques</h5>
                                    <p class="card-text"><b>Skills you will gain :</b> Creating and applying tattoo stencils
                                    correctly, drawing & sketching, precision & hand control, hygiene & sanitation, color theory &
                                    mixing, patience & attention to detail, adaptability, customer service & professionalism.</p>
                                </div>
                                <div class="card-body">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <span>4.9</span>
                                    <span class="reviews_course">3.6K reviews</span>
                                    <p>Beginner · Course · 1 - 3 Months</p>
                                </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-lg-4">
                            <a href="{{ route('course-details') }}">
                            <div class="card" style="width: 18rem;">
                                <div class="design">
                                <img class="card-img-top" src="{{ asset('assets/site-assets/img/tattoo/tattoo3.jpg') }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Tattooing Techniques</h5>
                                    <p class="card-text"><b>Skills you will gain :</b> Linework, shading, dotwork, and color packing
                                    techniques, drawing & sketching, precision & hand control, hygiene & sanitation, color theory
                                    & mixing, patience & attention to detail, adaptability, customer service & professionalism.
                                    </p>
                                </div>
                                <div class="card-body">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <span>4.9</span>
                                    <span class="reviews_course">3.6K reviews</span>
                                    <p>Intermediate · Specialization · 3 - 6 Months</p>
                                </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-lg-4">
                            <a href="{{ route('course-details') }}">
                            <div class="card" style="width: 18rem;">
                                <div class="design">
                                <img class="card-img-top" src="{{ asset('assets/site-assets/img/tattoo/tattoo6.jpeg') }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Tattoo Styles & Specializations</h5>
                                    <p class="card-text"><b>Skills you will gain :</b> Exploring different styles like traditional,
                                    realism, black & grey, neo-traditional, drawing & sketching, precision & hand control, hygiene
                                    & sanitation, color theory & mixing, patience & attention to detail, adaptability, customer
                                    service & professionalism.</p>
                                </div>
                                <div class="card-body">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <span>4.9</span>
                                    <span class="reviews_course">3.6K reviews</span>
                                    <p>Intermediate · Course · 2 - 6 Months</p>
                                </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-lg-4">
                            <a href="{{ route('course-details') }}">
                            <div class="card" style="width: 18rem;">
                                <div class="design">
                                <img class="card-img-top" src="{{ asset('assets/site-assets/img/tattoo/tattoo7.jpg') }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Client Consultation & Communication</h5>
                                    <p class="card-text"><b>Skills you will gain :</b> Learning how to discuss ideas and advise
                                    clients on designs, drawing & sketching, precision & hand control, hygiene & sanitation, color
                                    theory & mixing, patience & attention to detail, customer service & professionalism, customer
                                    service & professionalism. </p>
                                </div>
                                <div class="card-body">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <span>4.9</span>
                                    <span class="reviews_course">3.6K reviews</span>
                                    <p>Beginner · Specialization · 1 - 3 Months</p>
                                </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-lg-4 button-border">
                            <a href="{{ route('course-details') }}">
                            <div class="card" style="width: 18rem;">

                                <div class="design">
                                <img class="card-img-top" src="{{ asset('assets/site-assets/img/tattoo/tattoo4.jpg') }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Business & Licensing</h5>
                                    <p class="card-text"><b>Skills you will gain :</b> Understanding how to set up a legal tattoo
                                    business, marketing, pricing, drawing & sketching, precision & hand control, hygiene &
                                    sanitation, color theory & mixing, patience & attention to detail, adaptability, customer
                                    service & professionalism.</p>
                                </div>
                                <div class="card-body">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <span>4.9</span>
                                    <span class="reviews_course">3.6K reviews</span>
                                    <p>Beginner · Specialization · 3 - 6 Months</p>
                                </div>
                            </a>
                            <div class="style">
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
    </article>
</main>
@endsection