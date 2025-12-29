@extends('layouts.web-app')

@section('content')
<main>
    <article class="article">
        <section class="details_course1 heroSection bsb-hero-5 px-3 bsb-overlay mt-5">
            <div class="container mt-5">
                <h2 class="text-light">Payment for {{ $course->title }}</h2>
                <p class="text-light">Amount: ₹{{ number_format($course->price, 2) }}</p>

                <button id="pay-btn" class="btn btn-success">Pay Now</button>

                <form id="razorpay-form" action="{{ route('course.payment.verify') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                </form>
            </div>
        </section>
    </article>
</main>
@endsection

@section('script')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('pay-btn').addEventListener('click', function () {
        fetch("{{ route('course.payment.process') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ course_id: "{{ $course->id }}" })
        })
        .then(response => response.json())
        .then(data => {
            var options = {
                "key": data.razorpay_key,
                "amount": data.amount,
                "currency": "INR",
                "name": "{{ $course->title }}",
                "description": "Course Enrollment Payment",
                "order_id": data.order_id,
                "handler": function (response) {
                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('razorpay_signature').value = response.razorpay_signature;
                    document.getElementById('razorpay-form').submit();
                },
                "theme": {
                    "color": "#3399cc"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection
