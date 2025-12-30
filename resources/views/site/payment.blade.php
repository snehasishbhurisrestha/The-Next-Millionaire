@extends('layouts.web-app')

@section('title') Payment @endsection

@section('content')
<section style="
    min-height: 80vh;
    display:flex;
    justify-content:center;
    align-items:center;
">
    <div class="container" style="
        text-align:center;
        color:#ffffff;
        background:#0c0c0c;
        padding:50px 30px;
        border-radius:18px;
        max-width:650px;
        margin:auto;
        box-shadow:0 0 40px rgba(0,0,0,0.6);
        border:1px solid rgba(255,255,255,.1);
    ">

        <h2 style="
            font-size:28px;
            font-weight:800;
            margin-bottom:10px;
            letter-spacing:1px;
        ">
            Processing Your Payment
        </h2>

        <p style="
            font-size:18px;
            opacity:.9;
        ">
            Please do not refresh or close this page.
        </p>

        <img src="{{ asset('assets/site-assets/payment_loading.gif') }}"
             alt="Processing Payment"
             style="
                width:420px;
                max-width:100%;
                margin:25px 0;
             ">

        <p style="
            font-size:15px;
            color:#8df89c;
            margin-top:10px;
        ">
            Secure payment powered by Razorpay
        </p>

    </div>
</section>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
var options = {
    "key": "{{ $razorpay_key }}",
    "amount": "{{ $amount }}",
    "currency": "{{ $currency }}",
    "name": "The Next Millionaire",
    "description": "Course Payment",
    "order_id": "{{ $order_id }}",
    "prefill": {
        "name": "{{ auth()->user()->name ?? '' }}",
        "email": "{{ auth()->user()->email ?? '' }}",
        "contact": "{{ $phone ?? auth()->user()->phone ?? '' }}"
    },
    "handler": function (response){

        $.post("{{ route('course.payment.verify') }}", {
            _token: "{{ csrf_token() }}",
            razorpay_payment_id: response.razorpay_payment_id,
            razorpay_order_id: response.razorpay_order_id,
            razorpay_signature: response.razorpay_signature,
            course_id : "{{ $course_id }}"
        }, function(res){
            showToast('success', 'Success', 'Payment Successful!');
            // window.location.href = "{{ route('dashboard') }}";
            window.location.href = res.redirect;
        });

    },
    "modal": {
        "ondismiss": function(){
            window.location.href = "{{ route('home') }}";
        }
    },
    "theme": {
        "color": "#ddc27d"
    }
};

var rzp = new Razorpay(options);
rzp.open();
</script>

@endsection
