@extends('layouts.web-app')

@section('title') Payment Security @endsection

@section('content')

    <section class="course-sell-wrapper wrap py-7">
        <div class="container">
        <h3 class="heading">Payment security</h2>
        <p><strong>Effective Date:</strong> 2025</p>

        <p>At <strong>Next Millionaire</strong>, we take the security of your personal and payment information very seriously. We employ a variety of advanced technologies and industry best practices to ensure that your transactions are secure. Your privacy and security are our top priorities, and we are committed to safeguarding your information every step of the way.</p>

        <h2>How We Secure Your Payment Information</h2>
        <ul>
            <li><strong>Secure Payment Processors:</strong> We rely on trusted, PCI-compliant payment processors like <strong>Stripe</strong> and <strong>PayPal</strong>. These providers use advanced encryption technologies and follow the strictest industry standards to ensure your payment data is protected.</li>
            <li><strong>SSL Encryption:</strong> Every payment transaction on our website is transmitted securely using SSL (Secure Sockets Layer) encryption. This ensures that all sensitive information, such as your credit card details, is securely encrypted and transmitted over the internet.</li>
            <li><strong>Tokenization:</strong> When you make a payment, your payment details are tokenized. Tokenization replaces your sensitive payment information with a unique identifier or "token" which cannot be reversed or used outside of the transaction. This ensures that your actual payment information is never stored on our servers.</li>
            <li><strong>2-Factor Authentication (2FA):</strong> For added security, we encourage customers to enable two-factor authentication (2FA) for their accounts. This method adds an additional layer of security by requiring a second form of verification, such as a one-time code sent to your phone, when logging into your account or making significant changes.</li>
            <li><strong>PCI-DSS Compliance:</strong> Our third-party payment processors (e.g., PayPal, Stripe) are fully compliant with PCI-DSS (Payment Card Industry Data Security Standard). This ensures that they meet the stringent security requirements for processing, storing, and transmitting credit card data.</li>
        </ul>

        <h2>Fraud Prevention and Risk Management</h2>
        <p>We employ multiple layers of fraud prevention to protect both you and our platform from fraudulent transactions. These measures include:</p>
        <ul>
            <li><strong>Real-Time Fraud Detection:</strong> Our payment providers utilize advanced algorithms to detect and prevent fraudulent activity in real time. These systems analyze factors such as IP addresses, transaction patterns, and geographical locations to flag suspicious activity.</li>
            <li><strong>Address Verification Service (AVS):</strong> To ensure the security of credit card transactions, we use the Address Verification System (AVS). This system compares the billing address entered by you with the address on file with your card issuer to help detect potential fraud.</li>
            <li><strong>CVV Verification:</strong> Our payment systems require the Card Verification Value (CVV) to process credit card transactions. This additional layer of security ensures that the person making the payment has the physical card in their possession.</li>
            <li><strong>Transaction Monitoring:</strong> We continuously monitor transactions for signs of fraudulent behavior. If suspicious activity is detected, we may ask for additional verification or temporarily block the transaction for your safety.</li>
        </ul>

        <h2>How We Protect Your Privacy</h2>
        <p>We understand how important it is to protect your personal information. Our platform follows strict data protection measures to ensure that your personal details are handled securely:</p>
        <ul>
            <li><strong>No Storage of Payment Information:</strong> We do not store your full credit card details. All sensitive payment data is securely processed and stored by our third-party payment processors, which are responsible for the protection of this information.</li>
            <li><strong>Strict Data Access Controls:</strong> Only authorized personnel within our organization have access to personal data, and they are trained to handle this information with the utmost care and security.</li>
            <li><strong>Encryption of Personal Data:</strong> Any personal information you provide, such as your name, address, or contact details, is encrypted and stored securely. We use advanced encryption technologies to ensure that your data is safe from unauthorized access.</li>
        </ul>

        <h2>Your Responsibility for Payment Security</h2>
        <p>While we take every precaution to protect your information, it is important that you also take steps to ensure the security of your account and payment information:</p>
        <ul>
            <li><strong>Use Strong and Unique Passwords:</strong> Always use a strong, unique password for your account. A strong password typically includes a mix of uppercase and lowercase letters, numbers, and special characters.</li>
            <li><strong>Enable Two-Factor Authentication:</strong> We strongly recommend enabling 2FA for your account to provide an extra layer of security.</li>
            <li><strong>Monitor Your Transactions:</strong> Regularly check your bank and credit card statements for unauthorized transactions. If you notice anything suspicious, contact your bank or credit card provider immediately.</li>
            <li><strong>Logout After Each Session:</strong> If you're using a shared or public computer, always log out of your account after completing your payment or transaction to protect your information from unauthorized access.</li>
        </ul>

        <h2>What Happens in the Event of a Security Breach?</h2>
        <p>While we work hard to ensure your data is always safe, in the unlikely event of a data breach, we will notify you promptly and take immediate action to secure your information. This may include resetting your account password, temporarily disabling account access, or issuing new payment information.</p>

        <p>If you have any questions about the security of your payment information or our practices, please don't hesitate to contact our support team at <strong>contact@thenextmillionaire.in</strong>.</p>

        <h2>Additional Payment Security Tips</h2>
        <ul>
            <li><strong>Be Cautious of Phishing Scams:</strong> Be careful of unsolicited emails or phone calls requesting personal or payment information. Always verify the source of any communication before providing sensitive details.</li>
            <li><strong>Use Secure Networks:</strong> Avoid making payments or entering sensitive information when using public or unsecured Wi-Fi networks. Use a trusted, secure network whenever possible.</li>
            <li><strong>Keep Your Devices Secure:</strong> Ensure that your devices (computer, smartphone, etc.) have up-to-date antivirus software and firewalls enabled to help protect against malicious attacks.</li>
        </ul>

        <div class="foooter text-center">
            <p>&copy; 2025 The Next Millionaire. All rights reserved.</p>
        </div>
    </div>

    </section>
@endsection