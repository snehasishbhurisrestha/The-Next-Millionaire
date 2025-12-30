<section class="footer pt-2" style=" margin-top: 30px;">
    <div class="container">
        <div class="row d-flex justify-content-between ">

            <div class="col-lg-3 text-center" style="margin-top: -40px;">
                <img src="{{ asset('assets/site-assets/images/IMG_6469.png') }}" alt="Logo" height="30px">
                <div class="para">A brand built with one goal — to make financial freedom simple, real, and
                    accessible for those ready to grow.</div>
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
                    <li><i class="fa-brands fa-whatsapp"></i></li>
                    {{-- <li><i class="fa-brands fa-facebook"></i></li> --}}
                    <li><i class="fa-brands fa-instagram"></i></li>
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