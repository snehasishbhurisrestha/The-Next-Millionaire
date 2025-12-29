<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Verify Your Email</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
body{
    background:#f0f2f5;
    margin:0;
    padding:0;
    font-family:'Poppins',Arial,Helvetica,sans-serif;
}
.email-container{
    max-width:650px;
    margin:40px auto;
    background:#ffffff;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}
.header{
    background:#111827;
    padding:30px 20px;
    text-align:center;
}
.header img{
    width:120px;
    margin-bottom:5px;
}
.header h2{
    color:#ffffff;
    margin:10px 0 0;
    letter-spacing:1px;
}
.content{
    padding:35px 35px 20px;
    text-align:center;
}
.title{
    font-size:26px;
    font-weight:700;
    color:#111827;
}
.subtitle{
    font-size:16px;
    color:#555;
    margin-top:8px;
}

.otp-box{
    margin:30px auto;
    background:#f9fafb;
    border-radius:10px;
    padding:18px 0;
    width:240px;
    border:2px dashed #d1d5db;
}
.otp{
    font-size:34px;
    font-weight:800;
    letter-spacing:6px;
    color:#111827;
}

.info{
    font-size:14px;
    color:#666;
    margin-top:20px;
}

.button{
    margin-top:25px;
}
.btn{
    background:#111827;
    padding:14px 45px;
    color:white;
    font-size:15px;
    font-weight:600;
    text-decoration:none;
    border-radius:8px;
    display:inline-block;
}

.footer{
    margin-top:30px;
    background:#f9fafb;
    padding:18px;
    text-align:center;
    color:#777;
    font-size:13px;
}
.footer strong{
    color:#111827;
}
</style>
</head>

<body>

<div class="email-container">

    <!-- Header -->
    <div class="header">
        <img src="{{ asset('assets/site-assets/images/IMG_6469.png') }}" alt="Logo">
        <h2>The Next Millionaire</h2>
    </div>

    <!-- Content -->
    <div class="content">
        
        <div class="title">Verify Your Email</div>
        <div class="subtitle">
            Use the OTP below to verify your email and activate your account.
        </div>

        <div class="otp-box">
            <div class="otp">{{ $otp }}</div>
        </div>

        <div class="info">
            This OTP is valid for <strong>10 minutes</strong>.<br>
            If you didn’t request this, you can safely ignore this email.
        </div>

        <div class="button">
            <a class="btn">Do Not Share This OTP</a>
        </div>

    </div>

    <!-- Footer -->
    <div class="footer">
        <strong>The Next Millionaire</strong><br>
        © {{ date('Y') }} All Rights Reserved.
    </div>

</div>

</body>
</html>
