@extends('layouts.web-app')

@section('title') Cancellation & Refund Policy @endsection

@section('content')

    <section class="course-sell-wrapper wrap py-7">
        <div class="container">
            <h3 class="heading">Cancellation & Refund Policy</h3>
            <p><strong>Effective Date:</strong> 2025</p>

            <p>At <strong>The Next Millionaire</strong>, we aim to provide our customers with the best experience. This Cancellation & Refund Policy explains the conditions under which you can cancel your order and request a refund.</p>

            <h2>1. Course / Service Cancellation</h2>
            <ul>
                <li>Orders can be cancelled within <strong>24 hours</strong> of purchase, provided the course/service has not been accessed.</li>
                <li>Once the service/course is activated or accessed, cancellation will not be allowed.</li>
            </ul>

            <h2>2. Refund Eligibility</h2>
            <ul>
                <li>Refunds will only be processed if the cancellation request is made within the eligible time frame.</li>
                <li>Refunds are applicable only for payments made directly on our website.</li>
                <li>Any promotional or discounted purchases are <strong>non-refundable</strong>.</li>
            </ul>

            <h2>3. Refund Process</h2>
            <p>To request a refund, please contact us at <strong>{{ get_setting('email_1') }}</strong> with your order details. Refunds, once approved, will be processed within <strong>7-10 business days</strong> to the original payment method.</p>

            <h2>4. Non-Refundable Situations</h2>
            <ul>
                <li>If the course/service has already been accessed or used.</li>
                <li>If the refund request is made after the eligible time period.</li>
                <li>If the payment was made via a third-party or affiliate site.</li>
            </ul>

            <h2>5. Contact Us</h2>
            <p>If you have any questions regarding our Cancellation & Refund Policy, please contact us:</p>
            <p><strong>Email:</strong> {{ get_setting('email_1') }}</p>
            <p><strong>Phone:</strong> {{ get_setting('contact_phone_1') }}</p>

            <div class="foooter text-center">
                <p>&copy; 2025 The Next Millionaire. All rights reserved.</p>
            </div>
        </div>
    </section>

@endsection
