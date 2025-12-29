@extends('layouts.web-app')

@section('title') About Us @endsection

@section('content')
<main>

    <article class="article">
      <section class="topBanner heroSection bsb-hero-5 px-3 bsb-overlay mt-5"
        style="background-image: url('{{ asset('assets/site-assets/img/banner/banner1.jpg') }}');">
        <div class="container">
          <div class="row align-items-center">
            <!-- Left empty column -->
            <div class="col-12 col-md-2"></div>
            <!-- Content column -->
            <div class="col-12 col-md-8 text-start gerw">
              <h2 class="text-center text-start fw-bold mb-4" style="font-size: 50px;">About Us</h2>

              <p class="lead text-white mb-5"> There are three ways to ultimate success: The first way is to be kind.
                The second way is to be kind. The third way is to be kind.</p>
            </div>
            <div class="col-12 col-md-2"></div>
          </div>
        </div>
      </section>

      <section class="bsb-hero-5 px-3 bsb-overlay">
        <div class="container">
          <div class="row header-banner">
            <div class="process-left">
              <img src="{{ asset('assets/site-assets/img/banner/City-3.jpg') }}" width="1200" height="1304"
                alt="ISO Certification ISO 9001, ISO 14001, ISO 45001">

              <!-- <img class="audit appear inview" src="/{{ asset('assets/site-assets/img/certification.svg') }}" alt="ISO Certification HACCP, FSSC 22000, ISO 22000"> -->
            </div>
            <div class="process-right">
              <div class="text">
                <h3>Adding value to your business through certification</h3>
                <p>PHCRO&nbsp;is a fully accredited, third-party certification body providing auditing and certification
                  of international management system standards.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam tenetur quidem consequuntur facilis
                  vel eligendi doloribus. Quos, totam! Odit alias sed molestiae nesciunt? Ipsa ipsum magni ab error quae
                  numquam!</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque ratione eum nihil non at inventore
                  suscipit minima! Eveniet modi quis ipsum accusamus dignissimos iusto atque reprehenderit quod
                  consequatur, culpa similique quaerat perferendis nulla rem repudiandae deserunt odio laborum id?
                  Asperiores totam laudantium amet rerum vitae repudiandae provident, earum, unde enim dignissimos
                  voluptates corporis doloribus sunt veniam? Iure, ratione id. Ad rem quibusdam repellendus cumque
                  animi, ab aliquam ex unde id consequuntur earum modi vitae sed. Saepe ipsum aspernatur ducimus
                  voluptates iusto impedit omnis. Quas nemo, consequuntur amet blanditiis, fugiat rem deleniti ullam sed
                  exercitationem eius error in inventore saepe totam.</p>
              </div>
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