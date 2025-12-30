<!DOCTYPE html>
<html>
<head>
<title>The Next Millionaire - Payment Successful</title>
<style>
body{font-family:Arial;background:#f5f7fb;margin:0;padding:0}
.container{max-width:700px;margin:auto;background:#fff;border-radius:10px;overflow:hidden}
.header{background:#111;padding:25px;color:#fff;text-align:center}
.header h2{margin:0;font-size:26px;color:#ffd700}
.content{padding:30px;color:#333;font-size:14px;line-height:22px}
.box{background:#f4f4f4;padding:18px;border-radius:8px;margin-top:10px}
.invoice{margin-top:25px}
.table{width:100%;border-collapse:collapse;margin-top:12px}
.table th,.table td{border:1px solid #ddd;padding:10px;text-align:left}
.footer{text-align:center;padding:20px;background:#111;color:#aaa;font-size:13px}
span.gold{color:#d4a838;font-weight:700}
</style>
</head>

<body>
<div class="container">

<div class="header">
<h2>🎉 Welcome to <span style="color:#ffd700;">The Next Millionaire</span></h2>
<p>Your Digital Success Journey Starts Now 🚀</p>
</div>

<div class="content">

<p>Hi {{ $user->name ?? 'Champion' }},</p>

<p>
Congratulations! Your payment has been successfully received and your course access is now activated. 
You’ve officially taken the first step toward building your digital future.
</p>

<div class="box">
<p><strong>Inside Your Program:</strong></p>
<ul>
<li>Zero-Investment Digital Business Training</li>
<li>Fast Social Media Growth Strategies</li>
<li>Pre-recorded Lessons (Learn Anytime)</li>
<li>High-value eBooks & PDF Resources</li>
<li>VIP Community Access</li>
<li>Weekly Live Sessions</li>
<li>Affiliate Earning Opportunity</li>
<li>Lifetime Access + Future Updates</li>
</ul>
</div>

<div class="invoice">
<h3>🧾 Payment Invoice</h3>

<table class="table">
<tr>
<th>Invoice No</th>
<td>{{ $transaction->transaction_id }}</td>
</tr>

<tr>
<th>Course</th>
<td>{{ $course->title }}</td>
</tr>

<tr>
<th>Amount Paid</th>
<td>₹{{ $transaction->amount }}</td>
</tr>

<tr>
<th>Status</th>
<td>Paid</td>
</tr>

<tr>
<th>Date</th>
<td>{{ $transaction->created_at->format('d M Y, h:i A') }}</td>
</tr>
</table>
</div>

<br>

<h3>🚀 Your Next Steps</h3>
<ul>
<li>Login to your account</li>
<li>Start with Module 1</li>
<li>Follow Step-by-Step Roadmap</li>
<li>Join VIP Community</li>
</ul>

<p><strong>Need Help?</strong><br>
📧 help.thenextmillionaire@gmail.com</p>

<p>Welcome again — your journey starts now.</p>

<p>
Best Regards,<br>
<strong>Rahul Mondal</strong><br>
Founder, <span class="gold">The Next Millionaire</span>
</p>

</div>

<div class="footer">
© {{ date('Y') }} The Next Millionaire. All Rights Reserved.
</div>

</div>
</body>
</html>
