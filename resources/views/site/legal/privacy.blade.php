@extends('layouts.web-app')

@section('title') Privacy Policy @endsection

@section('content')

    <section class="course-sell-wrapper wrap py-7">
        <div class="container">
        <h3 class="heading">Privacy Policy</h2>
        <p><strong>Effective Date:</strong> 2025</p>

        <p>At <strong>Next Millionaire</strong>, we are committed to protecting and respecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website, purchase courses, or use our services.</p>

        <p>By using our website, you agree to the collection and use of information in accordance with this Privacy Policy.</p>

        <h2>1. Information We Collect</h2>
        <p>We may collect and process the following types of personal information:</p>
        <ul>
            <li><strong>Personal Identification Information</strong>: Name, email address, phone number, billing address, and other similar information.</li>
            <li><strong>Account Information</strong>: Username, password, and profile details created when you register for an account on our platform.</li>
            <li><strong>Payment Information</strong>: Credit card details, PayPal information, and billing data required for processing transactions (Note: We use third-party payment processors and do not store your full credit card details).</li>
            <li><strong>Course Data</strong>: Information about the courses you have enrolled in, viewed, or purchased.</li>
            <li><strong>Usage Data</strong>: Information about how you interact with our website, such as IP address, browser type, device type, pages visited, and time spent on the site.</li>
        </ul>

        <h2>2. How We Use Your Information</h2>
        <p>We use the information we collect for the following purposes:</p>
        <ul>
            <li><strong>To Provide Services</strong>: To process course orders, manage your account, and deliver courses or related content.</li>
            <li><strong>To Communicate with You</strong>: To send transactional emails (such as order confirmations, password resets), marketing communications (such as course updates, promotions), and customer service support.</li>
            <li><strong>To Improve Our Services</strong>: To analyze usage trends, fix bugs, and enhance the functionality of our website.</li>
            <li><strong>To Process Payments</strong>: To complete financial transactions for course purchases, refunds, and other financial interactions.</li>
            <li><strong>To Prevent Fraud and Abuse</strong>: To protect the security of our services and prevent unauthorized use.</li>
        </ul>

        <h2>3. Cookies and Tracking Technologies</h2>
        <p>We use cookies and other tracking technologies to enhance your experience on our website. Cookies are small files stored on your device that help us improve site navigation, analyze trends, and customize your experience.</p>
        <p><strong>Types of Cookies We Use:</strong></p>
        <ul>
            <li><strong>Necessary Cookies</strong>: Essential for the operation of our site (e.g., for logging in and processing transactions).</li>
            <li><strong>Performance Cookies</strong>: Collect anonymous data on website usage to help us improve our site.</li>
            <li><strong>Functional Cookies</strong>: Allow us to remember your preferences (e.g., language, login information) for a better experience.</li>
            <li><strong>Targeting Cookies</strong>: Used for personalized advertising and marketing purposes.</li>
        </ul>
        <p>You can control cookie preferences in your browser settings, but disabling certain cookies may affect your experience on our site.</p>

        <h2>4. Sharing Your Information</h2>
        <p>We may share your personal information with the following parties:</p>
        <ul>
            <li><strong>Third-Party Service Providers</strong>: To help us provide services, such as payment processors, email marketing platforms, and cloud hosting providers.</li>
            <li><strong>Legal Requirements</strong>: If required by law or to protect our rights, we may disclose your information to comply with legal processes, such as court orders or investigations.</li>
            <li><strong>Business Transfers</strong>: In the event of a merger, acquisition, or sale of assets, your information may be transferred as part of that transaction.</li>
        </ul>

        <h2>5. Data Retention</h2>
        <p>We retain your personal information for as long as necessary to fulfill the purposes outlined in this Privacy Policy or as required by law. After this period, we may anonymize or delete your data.</p>

        <h2>6. Your Data Protection Rights</h2>
        <p>Depending on your jurisdiction, you may have the following rights regarding your personal data:</p>
        <ul>
            <li><strong>Access</strong>: You have the right to request access to the personal information we hold about you.</li>
            <li><strong>Correction</strong>: You can request corrections to any inaccurate or incomplete information.</li>
            <li><strong>Deletion</strong>: You can request that we delete your personal information under certain circumstances.</li>
            <li><strong>Opt-out</strong>: You can opt out of receiving marketing communications from us at any time by clicking the "unsubscribe" link in emails or by contacting us directly.</li>
            <li><strong>Portability</strong>: You can request a copy of your data in a commonly used format for transfer to another service provider.</li>
        </ul>
        <p>To exercise any of these rights, please contact us at [your email address].</p>

        <h2>7. Security of Your Data</h2>
        <p>We take the security of your data seriously and use commercially reasonable measures to protect it. However, no method of transmission over the internet or electronic storage is 100% secure, and we cannot guarantee absolute security.</p>

        <h2>8. Children’s Privacy</h2>
        <p>Our website and services are not intended for children under the age of 13. We do not knowingly collect or solicit personal information from children under 13. If we learn that we have inadvertently collected personal information from a child under 13, we will take steps to delete that information.</p>

        <h2>9. Changes to This Privacy Policy</h2>
        <p>We may update our Privacy Policy from time to time. We will notify you of any material changes by posting the new Privacy Policy on this page. You are advised to review this Privacy Policy periodically for any updates.</p>

        <h2>10. Contact Us</h2>
        <p>If you have any questions or concerns about this Privacy Policy, please contact us at:</p>
        <p><strong>Email:</strong> {{ get_setting('email_1') }}</p>
        <p><strong>Phone:</strong> {{ get_setting('contact_phone_1') }}</p>

        <div class="foooter text-center">
            <p>&copy; 2025 The Next Millionaire . All rights reserved.</p>
        </div>
    </div>

    </section>

@endsection