@extends('layouts.web-app')

@section('title') Home @endsection

@section('content')

<main>
    <!-- Hero 5 - Bootstrap Brain Component -->
    <section class="bsb-hero-5 px-3 bsb-overlay">
        <div class="container">
            <div class="row ">
                <div class="top_sarch_warp">
                    <div class="col-lg-12 col-md-6" style="padding: 0rem 4rem;">
                        <h2 class="col-lg-12 display-1 text-white text-center fw-bold mb-4" style="font-size: 40px;">Search Your <span>Business</span></h2>
                        <nav class=" navbar navbar-light flex-nowrap">
                            <input class=" search form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <a href="#" class="btn btn-primary" type="submit">Search</a>
                        </nav>
                        <!-- <a href="#">Free Consultation</a> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <article class="article">
        <section class="fre_cunsultend4">
            <div class="container">
                <div class="row">
                    <h2 class="text-dark text-center fw-bold mb-4" style="font-size: 40px;">Inkspiration Awaits: Explore Our Latest Tattoo Stories!</h2>
                    <div class="d-flex flex-wrap col-lg-12 text-design">
                        <div class="col-lg-4">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="{{ asset('assets/site-assets/img/tattoo/tattoo1.png') }}" alt="Card image cap" >
                                <div class="card-body">
                                    <h5 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius quos animi
                                        possimus minus a minima.</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                                        card's content.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="{{ asset('assets/site-assets/img/tattoo/tattoo2.jpg') }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius quos animi
                                        possimus minus a minima.</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                                        card's content.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="{{ asset('assets/site-assets/img/tattoo/tattoo3.jpg') }}" alt="Card image cap" >
                                <div class="card-body">
                                    <h5 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio earum quia ex
                                        placeat delectus maiores.</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                                        card's content.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="{{ asset('assets/site-assets/img/tattoo/tattoo6.jpeg') }}" alt="Card image cap" >
                                <div class="card-body">
                                    <h5 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius quos animi
                                        possimus minus a minima.</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                                        card's content.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="{{ asset('assets/site-assets/img/tattoo/tattoo7.jpg') }}" alt="Card image cap">                
                                <div class="card-body">
                                    <h5 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius quos animi
                                        possimus minus a minima.</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                                        card's content.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 button-border">
                            <div class="card" style="width: 18rem;background-color: #e3e6e9;">
                                <img class="card-img-top" src="{{ asset('assets/site-assets/img/tattoo/tattoo4.jpg') }}" alt="Card image cap" >
                                <div class="card-body">
                                    <h5 class="card-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius quos animi
                                        possimus minus a minima.</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                                        card's content.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="fre_cunsultend">
            <div class="container">
                <div class="container">
                    <div class="row header-banner box_warp">
                        <div class="heading" style="border-radius:30px;">
                            <p>Bring Your Vision to Life with Expert Ink!</p>
                            <a href="{{ route('contact') }}">Book Your Free Consultation</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <section class="programs">
            <div class="container">
                <div class="row">
                    <div class="prog_ram">
                        <h2 class="text-dark text-center fw-bold mb-4" style="font-size: 50px;">Certified for Trust & Quality</h2>
                        <p class="lead text-dark text-center mb-5">
                            <span>Ensure your tattoo studio meets the highest standards of safety, hygiene, and professionalism. Get certified and build trust with your clients today!</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div class="row">
                    <div id="cardCarousel" class="carousel slide" data-bs-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-bs-target="#cardCarousel" data-bs-slide-to="0" class="active"></li>
                            <li data-bs-target="#cardCarousel" data-bs-slide-to="1"></li>
                            <li data-bs-target="#cardCarousel" data-bs-slide-to="2"></li>
                        </ol>

                        <!-- Carousel Inner -->
                        <div class="carousel-inner home_ban_sli">
                            <div class="carousel-item active">
                                <div class="row">
                                    <!-- Card 1 -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset('assets/site-assets/img/certificate/certificate1.jpg') }}" class="card-img-top" alt="Card 1">
                                            <div class="card-body">
                                                <h5 class="card-title">Card 1</h5>
                                                <p class="card-text">Some quick example text for card 1.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card 2 -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset('assets/site-assets/img/certificate/certificate2.jpg') }}" class="card-img-top" alt="Card 2">
                                            <div class="card-body">
                                                <h5 class="card-title">Card 2</h5>
                                                <p class="card-text">Some quick example text for card 2.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card 3 -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset('assets/site-assets/img/certificate/certificate3.jpg') }}" class="card-img-top" alt="Card 3">
                                            <div class="card-body">
                                                <h5 class="card-title">Card 3</h5>
                                                <p class="card-text">Some quick example text for card 3.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset('assets/site-assets/img/certificate/certificate4.jpg') }}" class="card-img-top" alt="Card 3">
                                            <div class="card-body">
                                                <h5 class="card-title">Card 3</h5>
                                                <p class="card-text">Some quick example text for card 3.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div class="row">
                                    <!-- Card 4 -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset('assets/site-assets/img/certificate/certificate5.jpg') }}" class="card-img-top" alt="Card 4">
                                            <div class="card-body">
                                                <h5 class="card-title">Card 4</h5>
                                                <p class="card-text">Some quick example text for card 4.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card 5 -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset('assets/site-assets/img/certificate/certificate6.jpg') }}" class="card-img-top" alt="Card 5">
                                            <div class="card-body">
                                                <h5 class="card-title">Card 5</h5>
                                                <p class="card-text">Some quick example text for card 5.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card 6 -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset('assets/site-assets/img/certificate/certificate7.jpg') }}" class="card-img-top" alt="Card 6">
                                            <div class="card-body">
                                                <h5 class="card-title">Card 6</h5>
                                                <p class="card-text">Some quick example text for card 6.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset('assets/site-assets/img/certificate/certificate8.jpg') }}" class="card-img-top" alt="Card 3">
                                            <div class="card-body">
                                                <h5 class="card-title">Card 3</h5>
                                                <p class="card-text">Some quick example text for card 3.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div class="row">
                                    <!-- Card 7 -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset('assets/site-assets/img/certificate/certificate9.jpg') }}" class="card-img-top" alt="Card 7">
                                            <div class="card-body">
                                                <h5 class="card-title">Card 7</h5>
                                                <p class="card-text">Some quick example text for card 7.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card 8 -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset('assets/site-assets/img/certificate/certificate4.jpg') }}" class="card-img-top" alt="Card 8">
                                            <div class="card-body">
                                                <h5 class="card-title">Card 8</h5>
                                                <p class="card-text">Some quick example text for card 8.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset('assets/site-assets/img/certificate/certificate5.jpg') }}" class="card-img-top" alt="Card 3">
                                            <div class="card-body">
                                                <h5 class="card-title">Card 3</h5>
                                                <p class="card-text">Some quick example text for card 3.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset('assets/site-assets/img/certificate/certificate6.jpg') }}" class="card-img-top" alt="Card 3">
                                            <div class="card-body">
                                                <h5 class="card-title">Card 3</h5>
                                                <p class="card-text">Some quick example text for card 3.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Controls -->
                        <a class="carousel-control-prev" href="#cardCarousel" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#cardCarousel" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>



        <section class="fre_cunsultend2">
            <div class="container button-border">
                <div class="row header-banner">
                    <div class="rei_r">
                        <p class="lead">Explore our latest certifications awarded to trusted tattoo studios and artists. Ensure quality, safety, and professionalism in every inked masterpiece.</p>
                        <a href="{{ route('certificate') }}">See All Certificates</a>
                    </div>
                </div>
            </div>
        </section>
    


        <section class="bsb-hero-5 px-3 bsb-overlay mt-5" style="background-image: url('{{ asset('assets/site-assets/img/banner/banner1.jpg') }}'); background-size: cover; background-position: center;border-radius: 0px;">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left empty column -->
                    <div class="col-12 col-md-2"></div>
                    <!-- Content column -->
                    <div class="col-12 col-md-8 text-start gerw">
                        <h2 class="text-center text-start fw-bold mb-4" style="font-size: 50px;">Empowering Artists, Elevating Standards</h2>
                        <p class="lead text-white mb-5">"Great things are not done by impulse, but by a series of small things brought together." – Vincent Van Gogh</p>
                    </div>
                    <div class="col-12 col-md-2"></div>
                </div>
            </div>
        </section>


        <section class="home-process container appear inview">
            <div class="container">
                <div class="row col-lg-12 header-banner text-design1 button-border">
                    <div class="col-lg-4">
                        <div class="card text-start">
                            <div class="card-body">
                                <h2 class="text-dark text-start fw-bold mb-4" style="font-size: 30px;">About PHCRO Certification</h2>
                                <h5 class="card-title">Recognizing Excellence in Tattoo Studios & Artists</h5>
                                <p class="card-text">PHCRO Certification ensures tattoo studios meet the highest standards of hygiene, safety, and professionalism.</p>
                                <button type="button" class="btn bsb-btn-2xl btn-outline-light">Get Certified</button>
                            </div>
                        </div>
                    </div>

                    <div class="process-left col-lg-4">
                        <img src="{{ asset('assets/site-assets/img/banner/City-3.jpg') }}" width="1200" height="1304" alt="">
                    </div>
                    <div class="process-right col-lg-4">
                        <div class="text">
                            <h3>We provide a reliable, no nonsense and simple process for organisations to achieve ISO
                                certification.</h3>
                            <p>PHCRO&nbsp;is a fully accredited, third-party certification body providing auditing and certification
                                of international management system standards.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="home-process container appear inview">
            <div class="container">
                <div class="row" style="padding: 0px 50px;">
                    <div class="process-left">
                    <img src="{{ asset('assets/site-assets/img/banner/City-3.jpg') }}" width="1200"
                        height="1304" alt="ISO Certification ISO 9001, ISO 14001, ISO 45001">
                    
                    <!-- <img class="audit appear inview" src="/{{ asset('assets/site-assets/img/certification.svg') }}" alt="ISO Certification HACCP, FSSC 22000, ISO 22000"> -->
                    </div>
                    <div class="process-right">
                        <div class="text">
                            <h3>Adding value to your business through certification</h3>
                            <p>PHCRO&nbsp;is a fully accredited, third-party certification body providing auditing and certification
                            of international management system standards.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="bsb-hero-5 px-3 bsb-overlay mt-5 home-locations appear inview">
            <div class="container">
                <div class="row align-items-center header-banner" style="padding: 0rem 4rem;">
                    <!-- Left empty column -->
                    <div class="col-12 col-md-6 text-start">
                        <h2 class="text-light text-start fw-bold mb-4" style="font-size: 50px;">Get Certified with PHCRO</h2>

                        <p class="lead text-light">
                            Take the first step towards excellence! Book your <strong>Free Consultation</strong> with PHCRO and ensure your tattoo studio meets the highest industry standards for safety, professionalism, and client trust.
                        </p>

                        <button type="button" class="btn bsb-btn-2xl btn-outline-light">Free Consultation</button>
                    </div>
                    <div class="col-12 col-md-6 text-start">
                        <img src="{{ asset('assets/site-assets/img/banner/City-3.jpg') }}"  alt="ISO Certification ISO 9001, ISO 14001, ISO 45001">
                    </div>
                    <!-- Content column -->
                </div>
            </div>
        </section>
    </article>
</main>

@endsection