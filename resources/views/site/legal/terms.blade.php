@extends('layouts.web-app')

@section('title') Terms of Service @endsection

@section('content')

    <section class="course-sell-wrapper wrap py-7">
        <div class="container">
            <h3 class="heading">Terms and Conditions</h2>
            <h2><strong>Effective Date:</strong>2025 </h2>

            <div class="terms-section">
                <p>These Terms and Conditions govern your use of <strong>Next Millionaire</strong> , including all its features, services, and content provided by <strong> Next Millionaire</strong>. By accessing or purchasing from this website, you agree to be bound by these Terms. If you do not agree with these Terms, do not use our website or services.</p>
            </div>

            <div class="terms-section">
                <h2>1. Overview</h2>
                <p>The Next Millionaire offers educational courses delivered via digital media. By accessing our website and purchasing our Courses, you agree to comply with the terms outlined in this document.</p>
            </div>

            <div class="terms-section">
                <h2>2. User Account</h2>
                <p>To access certain Courses, you may be required to create an account. You agree to:</p>
                <ul>
                    <li>Provide accurate, current, and complete information when creating your account.</li>
                    <li>Maintain the security and confidentiality of your login credentials.</li>
                    <li>Notify us immediately of any unauthorized access or breach of security.</li>
                </ul>
                <p>You are responsible for all activities that occur under your account.</p>
            </div>

            <div class="terms-section">
                <h2>3. Course Access</h2>
                <p>Upon purchasing a Course, you are granted access to the Course materials for a limited period, as specified at the time of purchase. Access to the Courses is non-transferable and only available for individual use.</p>
            </div>

            <div class="terms-section">
                <h2>4. Payment and Pricing</h2>
                <p>- All prices for Courses are displayed on the website at the time of purchase.</p>
                <p>- Payments for Courses are processed via third-party payment processors and are subject to their respective terms.</p>
                <p>- Prices are subject to change without prior notice, but the price at the time of purchase will be honored.</p>
            </div>

            

            <div class="terms-section">
                <h2>6. Intellectual Property</h2>
                <p>All content on the website, including but not limited to Course materials, videos, graphics, logos, trademarks, and text, is owned by Next Millionare and protected by copyright, trademark, and other intellectual property laws. You may not:</p>
                <ul>
                    <li>Copy, reproduce, modify, or distribute any content without our express permission.</li>
                    <li>Use the content for commercial purposes without written consent.</li>
                </ul>
            </div>

            <div class="terms-section">
                <h2>7. User Conduct</h2>
                <p>You agree to use our website and Courses for lawful purposes only and agree not to:</p>
                <ul>
                    <li>Engage in any behavior that disrupts or interferes with the website's operations or security.</li>
                    <li>Upload or share any offensive, illegal, or inappropriate content.</li>
                    <li>Use the Courses for any unlawful or unauthorized purpose.</li>
                </ul>
            </div>

            <div class="terms-section">
                <h2>8. Limitation of Liability</h2>
                <p>To the fullest extent permitted by law, Next Millionaire is not responsible for any indirect, incidental, special, or consequential damages arising from your use or inability to use our Courses, including but not limited to loss of data, revenue, or business.</p>
                <p>Our liability is limited to the amount paid for the Course.</p>
            </div>

            <div class="terms-section">
                <h2>9. Termination</h2>
                <p>We reserve the right to suspend or terminate your access to the website and Courses at our sole discretion if you violate these Terms. Upon termination, your access to the Courses will be revoked, and no refunds will be issued.</p>
            </div>

            <div class="terms-section">
                <h2>10. Privacy Policy</h2>
                <p>By using our website and purchasing Courses, you agree to our Privacy Policy, which explains how we collect, use, and protect your personal information.</p>
            </div>

            <div class="terms-section">
                <h2>11. Changes to Terms</h2>
                <p>We may update these Terms from time to time to reflect changes in our services, legal requirements, or business practices. Any changes will be posted on this page with the updated effective date.</p>
            </div>

            <div class="terms-section">
                <h2>12. Governing Law</h2>
                <p>These Terms are governed by and construed in accordance with the laws of India, without regard to its conflict of law principles. Any legal action arising from these Terms shall be brought in the courts.</p>
            </div>

            <div class="terms-section">
                <h2>13. Contact Us</h2>
                <p>If you have any questions about these Terms and Conditions, please contact us at:</p>
                <ul>
                    <li>Email: <a href="mailto:{{ get_setting('email_1') }}">{{ get_setting('email_1') }}</a></li>
                    <li>Phone: {{ get_setting('contact_phone_1') }}</li>
                </ul>
            </div>

            <foooter class="text-center">
                <p>&copy; 2025 Next Millionaire. All rights reserved. <br>
                
                </p>
            </footer>

        </div>

    </section>

@endsection