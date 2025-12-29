@extends('layouts.web-app')

@section('title') Contact Us @endsection

@section('content')

<main>
    <article class="article">
        <section class="topBanner heroSection bsb-hero-5 px-3 bsb-overlay mt-5"  style="background-image: url('{{ asset('assets/site-assets/img/banner/360.jpg') }}');">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left empty column -->
                    <div class="col-12 col-md-2"></div>
                    <!-- Content column -->
                    <div class="col-12 col-md-8 text-start gerw">
                        <h2 class="text-center text-start fw-bold mb-4" style="font-size: 50px;">Contact Us</h2>
                        <p class="lead text-white mb-5">Have questions or need assistance? We're here to help! Whether you're interested in certification, need advice, or have any inquiries, reach out to us. Our team is ready to support you on your journey to excellence.</p>
                    </div>
                    <div class="col-12 col-md-2"></div>
                </div>
            </div>
        </section>

        <section class="bsb-hero-5 px-3 bsb-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <img src="{{ asset('assets/site-assets/img/photo/HILmr.png') }}" alt="World illustration" class="img-fluid">
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="contact-form">
                            <h2>Contact Us</h2>
                            <form action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">Your Name <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name">Gender <span class="text-danger">*</span></label>
                                        <select class="col-lg-12 custom-select my-1 mr-sm-2" id="gender" name="gender" required>
                                            <option selected disabled>Choose...</option>
                                            <option value="male" @if( old('gender') == 'male' ) selected @endif>Male</option>
                                            <option value="female" @if( old('gender') == 'female' ) selected @endif>Female</option>
                                            <option value="others" @if( old('gender') == 'others' ) selected @endif>Others</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="business_name">Business Name <span class="text-danger">*</span></label>
                                        <input type="text" id="business_name" name="business_name" value="{{ old('business_name') }}" placeholder="Enter business name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name">Business Category <span class="text-danger">*</span></label>
                                        <select class="col-lg-12 custom-select my-1 mr-sm-2" id="businessCategory" name="business_category_id" required>
                                            <option selected disabled>Choose...</option>
                                            @foreach($business_categorys as $business_category)
                                            <option value="{{ $business_category->id }}" @if( old('business_category_id') == $business_category->id ) selected @endif>{{ $business_category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email">Your Email <span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone">Your Phone <span class="text-danger">*</span></label>
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address">Your Address</label>
                                        <textarea id="address" name="address" rows="2" placeholder="Enter your address">{{ old('address') }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="business_address">Business Address</label>
                                        <textarea id="business_address" name="business_address" rows="2" placeholder="Enter business address">{{ old('business_address') }}</textarea>
                                    </div>
                                </div>
                            
                                <label for="message">Your Message</label>
                                <textarea id="message" name="message" rows="3" placeholder="Enter your message">{{ old('message') }}</textarea>
                            
                                <button type="submit">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>
</main>

@endsection