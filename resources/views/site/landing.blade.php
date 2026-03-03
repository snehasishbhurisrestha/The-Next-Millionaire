<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>Landing</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('assets/site-assets/css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/site-assets/css/responsive.css') }}?v={{ time() }}">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <!-- Toast message -->
    <link href="{{ asset('assets/admin-assets/plugins/toast/toastr.css') }}" rel="stylesheet" type="text/css" />
    <!-- Toast message -->
    
    <style>
.landing-wrapper {
    padding: 100px 20px 80px;
    text-align: center;
}

.landing-wrapper .container {
    max-width: 800px;
    margin: auto;
}
.main-heading {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 20px;
    color:#6c757d;
}
.main-heading span{
    color:#FFA602;
}
.sub-heading {
    font-size: 20px;
    opacity: 0.85;
    margin-bottom: 20px;
}

.video-box {
    position: relative;
    width: 100%;
    padding-top: 56.25%; /* 16:9 ratio */
    border: 3px dashed #FFA903;
    border-radius: 20px;
    overflow: hidden;
    margin: 40px auto;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
}

.video-box iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

.book-btn {
    position: relative;
    display: inline-block;
    padding: 18px 50px;
    font-size: 22px;
    font-weight: 700;
    border: none;
    border-radius: 14px;
    cursor: pointer;
    color: #000;
    overflow: hidden;
    background: linear-gradient(
        90deg,
        #FFD84D 0%,
        #FFA903 50%,
        #FFD84D 100%
    );
    background-size: 200% 200%;
    box-shadow: 
        0 0 25px rgba(255,169,3,0.7),
        0 0 50px rgba(255,169,3,0.4);
    animation: 
        gradientShift 2s ease infinite,
       
    transition: none; 
}
.book-btn:hover {
    animation:
        gradientShift 2s ease infinite,
        glowPulse 1.5s ease-in-out infinite,
        shake 0.6s ease infinite; 
}

@keyframes gradientShift {
    0%   { background-position: 0% 50%; }
    50%  { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/*@keyframes glowPulse {*/
/*    0%, 100% {*/
/*        box-shadow: */
/*            0 0 25px rgba(255,169,3,0.7),*/
/*            0 0 50px rgba(255,169,3,0.4);*/
/*    }*/
/*    50% {*/
/*        box-shadow: */
/*            0 0 40px rgba(255,169,3,1),*/
/*            0 0 80px rgba(255,169,3,0.7),*/
/*            0 0 120px rgba(255,169,3,0.3);*/
/*    }*/
/*}*/

@keyframes shake {
    0%   { transform: rotate(0deg) translateY(0); }
    15%  { transform: rotate(-3deg) translateY(-3px); }
    30%  { transform: rotate(3deg) translateY(-3px); }
    45%  { transform: rotate(-3deg) translateY(-3px); }
    60%  { transform: rotate(3deg) translateY(-3px); }
    75%  { transform: rotate(-1deg) translateY(-2px); }
    100% { transform: rotate(0deg) translateY(0); }
}

/* Shine sweep */
.book-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -75%;
    width: 50%;
    height: 100%;
    background: linear-gradient(
        120deg,
        transparent,
        rgba(255,255,255,0.6),
        transparent
    );
    animation: shineSweep 2s ease-in-out infinite;
}

@keyframes shineSweep {
    0%   { left: -75%; }
    50%  { left: 125%; }
    100% { left: 125%; }
}

.glow-shake-btn {
    text-align: center;
}

@media (max-width: 991px) {
    .main-heading {
        font-size: 36px;
    }

    .sub-heading {
        font-size: 18px;
    }
}

@media (max-width: 576px) {

    .landing-wrapper {
        padding: 100px 15px 60px;
    }

    .main-heading {
        font-size: 26px;
        line-height: 1.4;
    }

    .sub-heading {
        font-size: 16px;
    }

    .book-btn {
        width: 100%;
        font-size: 16px;
        padding: 14px 20px;
    }

    .video-box {
        border-radius: 15px;
    }
}
</style>
    
    {!! get_setting('header_script') !!}

</head>
  
<body>

    <header>
        <nav class="navbar navbar-light fixed-top" id="mainNavbar">
            <div class="container d-flex justify-content-center align-items-center">
    
                <!-- Left (optional menu) -->
                {{-- <div class="d-flex align-items-center">
                    <!-- Add menu links here if needed -->
                </div> --}}
    
                <!-- Center: Logo -->
                <div class="text-center">
                    <a class="navbar-brand" href="{{ route('home') }}" style="margin-top:-30px">
                        <img src="{{ asset('assets/site-assets/images/IMG_64610.png') }}" alt="Logo" height="40">
                    </a>
                </div>
    
                <!-- Right: User Actions -->
                <!--<div class="d-flex align-items-center">-->
    
                <!--    @guest-->
                <!--        <a href="{{ route('login') }}" -->
                <!--           class="btn btn-outline-light d-flex align-items-center mt-lg-0">-->
                <!--            <i class="fa fa-user me-2"></i> Login-->
                <!--        </a>-->
                <!--    @else-->
                <!--        <div class="dropdown">-->
                <!--            <a href="#" -->
                <!--               class="btn btn-outline-light dropdown-toggle d-flex align-items-center mt-lg-0" -->
                <!--               id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="max-width:170px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">-->
                <!--                <i class="fa fa-user me-2"></i> {{ Auth::user()->first_name }}-->
                <!--            </a>-->
                <!--            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">-->
                <!--                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a></li>-->
                <!--                <li>-->
                <!--                    <form method="POST" action="{{ route('logout') }}" style="padding: 0;box-shadow: unset;">-->
                <!--                        @csrf-->
                <!--                        <button type="submit" class="dropdown-item"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</button>-->
                <!--                    </form>-->
                <!--                </li>-->
                <!--            </ul>-->
                <!--        </div>-->
                <!--    @endguest-->
    
                <!--</div>-->
            </div>
        </nav>
    </header>

   
   <section class="landing-wrapper">
    <div class="container">

        <!-- Big Text -->
        <h1 class="main-heading">
           LEARN HOW I MADE <span> 10 CRORE+ IN 1 YEAR </span> BY SELLING DIGITAL PRODUCTS ONLINE <span>(YOU CAN DO IT TOO…)</span>
        </h1>

        <p class="sub-heading">
            Watch this short video carefully before booking your seat.
        </p>

        <!-- Video Box -->
        <div class="video-box">
            <iframe 
                src="https://player.vimeo.com/video/1148466662"
                allow="autoplay; fullscreen; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>

        <!-- Button -->
        <button class="book-btn glow-shake-btn"
    onclick="window.location='{{ route('home') }}'">
    Book Your Slot Now
</button>

    </div>
</section>

    <section class="footer pt-2" style=" margin-top: 30px;">
    <div class="container">
        <div class="row d-flex justify-content-between ">

            <div class="col-lg-3 text-center" style="margin-top: -40px;">
                <img src="{{ asset('assets/site-assets/images/IMG_6469.png') }}" alt="Logo" height="30px">
                <div class="para">Build your digital business from scratch with zero upfront investment. Learn proven strategies, grow on social media, and take action with clear guidance.</div>
            </div>

            <div class="col-lg-3 pt-4">
                <div class="para">Our Policies & Your Responsibilities</div>
                <ul class="footer"style="padding:0 20px">
                    <li class="second1">All payments are final unless a refund policy is mentioned.</li>
                    <li class="second1">Course access is for personal use only (not to be shared or resold).
                    </li>
                    <li class="second1">We do not guarantee earnings — results depend on your effort and
                        consistency.</li>
                    <li class="second1">By enrolling, you agree to respect copyright and not misuse the content.
                    </li>
                </ul>
            </div>


            <div class="col-lg-3 py-2 pt-4">
                <div class="para">© 2025 The Next Millionaire. All rights reserved.</div>
                <h2 class="second1">Our mission is to empower individuals and businesses to achieve their
                    financial goals through education and innovative solutions.</h2>
                <ul class="social-icon"
                    style="display: flex; gap: 10px; list-style: none; padding: 0; margin: 0; justify-content: end;">
                    {{-- <li><i class="fa-brands fa-telegram"></i></li> --}}
                    {{-- <li><i class="fa-brands fa-facebook"></i></li> --}}
                    {{-- <li><i class="fa-brands fa-whatsapp"></i></li>
                    <li><i class="fa-brands fa-instagram"></i></li> --}}
                    <li>
                        <a href="https://wa.me/+917980395623" target="_blank" style="color: #C69F4B;">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    </li>

                    <li>
                        <a href="https://www.instagram.com/xrahulmondal?igsh=MWoxY3J1dzFhOGtmbg==" target="_blank" style="color: #C69F4B;">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
        <div class="row">
    <div class="col-12">
        <hr>
        <p class="text-center para">
            Designed and Developed by 
            <a href="https://orbitalwebworks.com/">Orbital Webworks</a>
        </p>

        <div class="options">
            <ul class="list-unstyled d-flex flex-wrap justify-content-center gap-2 mb-0">
                <li><a href="{{ route('terms') }}" class="text-decoration-none">Terms of Service</a></li>
                <li><a href="{{ route('privacy') }}" class="text-decoration-none">Privacy Policy</a></li>
                <li><a href="{{ route('payment.security') }}" class="text-decoration-none">Payment Security</a></li>
                <li><a href="{{ route('cancellation.refund') }}" class="text-decoration-none">Cancellation & Refund</a></li>
                <li><a href="{{ route('shipping.policy') }}" class="text-decoration-none">Shipping Policy</a></li>
            </ul>
        </div>
    </div>
</div>

    </div>
</section>
    
    <!-- Sticky Support Button -->
    <!--<a href="https://wa.me/+917980395623" class="support-fab" title="Support">-->
    <!--    <i class="fas fa-headset"></i>-->
    <!--</a>-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/site-assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        AOS.init({
            duration: 1200,
            once: false
        });
    </script>
    <script src="{{ asset('assets/site-assets/js/main.js') }}?v={{ time() }}"></script>

    
    {!! get_setting('footer_script') !!}
</body>

</html>