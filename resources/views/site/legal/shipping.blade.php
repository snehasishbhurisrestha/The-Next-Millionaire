@extends('layouts.web-app')

@section('title') Shipping Policy @endsection

@section('content')

    <section class="course-sell-wrapper wrap py-7">
        <div class="container">
            <h3 class="heading">Shipping Policy</h3>
            <p><strong>Effective Date:</strong> 2025</p>

            <p>At <strong>The Next Millionaire</strong>, we are committed to ensuring timely and reliable delivery of our services and products. This Shipping Policy outlines our delivery practices and timelines.</p>

            <h2>1. Delivery of Digital Products</h2>
            <ul>
                <li>For online courses and digital products, access will be provided immediately after successful payment.</li>
                <li>Login credentials or course access details will be sent to your registered email address.</li>
            </ul>

            <h2>2. Delivery of Physical Products (if applicable)</h2>
            <ul>
                <li>Orders for physical items (if any) are processed within <strong>2-3 business days</strong> of payment confirmation.</li>
                <li>Shipping times may vary between <strong>5-10 business days</strong>, depending on your location.</li>
                <li>You will receive a tracking number once your order has been shipped.</li>
            </ul>

            <h2>3. Shipping Charges</h2>
            <ul>
                <li>Shipping charges (if applicable) will be displayed at checkout before you complete your purchase.</li>
                <li>Free shipping may be offered on promotional orders as specified.</li>
            </ul>

            <h2>4. Delays in Delivery</h2>
            <p>While we strive to deliver within the estimated timeframes, delays may occur due to factors beyond our control (logistics delays, natural disasters, or strikes). We will inform you promptly if such delays arise.</p>

            <h2>5. International Shipping</h2>
            <p>Currently, our services and products are primarily available within India. For international orders, please contact us directly at <strong>contact@thenextmillionaire.in</strong>.</p>

            <h2>6. Contact Us</h2>
            <p>If you have any questions about our Shipping Policy, please contact us:</p>
            <p><strong>Email:</strong> {{ get_setting('email_1') }}</p>
            <p><strong>Phone:</strong> {{ get_setting('contact_phone_1') }}</p>

            <div class="foooter text-center">
                <p>&copy; 2025 The Next Millionaire. All rights reserved.</p>
            </div>
        </div>
    </section>

@endsection
