@extends('layouts.web-app')

@section('title') {{ $blog->title }} @endsection

@section('content')

<main>
    <article class="article">
        <section class="topBanner heroSection bsb-hero-5 px-3 bsb-overlay mt-5" style="background-image: url('{{ $blog->getFirstMediaUrl('blog-image') }}');height: 500px;">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left empty column -->
                    <div class="col-12 col-md-2"></div>
                    <!-- Content column -->
                    <div class="col-12 col-md-8 text-start gerw">
                        <h2 class="text-center text-start fw-bold mb-4" style="font-size: 50px;">Blog Details</h2>
        
                        <p class="lead text-white mb-5"> {{ $blog->title }}</p>
                    </div>
                    <div class="col-12 col-md-2"></div>
                </div>
            </div>
        </section>
  
        <section class="bsb-hero-5 px-3 bsb-overlay">
            <div class="container">
                <div class="row header-banner">
                    <div class="process-right">
                        <div class="text">
                            <h3>{{ $blog->title }}</h3>
                            {!! $blog->description !!}
                        </div>
                    </div>
                    <div class="process-left">
                        <img src="{{ $blog->getFirstMediaUrl('blog-image') }}" width="1200" height="1304" alt="{{ $blog->title }}">
        
                        <!-- <img class="audit appear inview" src="/assets/img/certification.svg" alt="ISO Certification HACCP, FSSC 22000, ISO 22000"> -->
                    </div>
                </div>
            </div>
        </section>
  
        <section class="fre_cunsultend">
            <div class="container">
                <div class="row header-banner box_warp">
                    <div class="heading" style=" border-radius:30px;">
                        <p>Bring Your Vision to Life with Expert Ink!</p>
                        <a href="{{ route('contact') }}">Book Your Free Consultation</a>
                    </div>
                </div>
            </div>
        </section>
    </article>
</main>

@endsection