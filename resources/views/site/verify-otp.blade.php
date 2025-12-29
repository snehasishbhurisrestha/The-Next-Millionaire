@extends('layouts.web-app')

@section('title','Verify OTP')

@section('style')
<style>

    .otp-wrapper{
        background:#000;               /* black panel */
        color:#fff;
        max-width:520px;
        margin:auto;
        border-radius:18px;
        padding:40px 35px;
        box-shadow:0px 10px 30px rgba(0,0,0,.6);
    }

    /* Title */
    .otp-title{
        text-align:center;
        font-size:28px;
        font-weight:700;
        color:#ffd500;                 /* yellow */
    }

    .otp-sub{
        text-align:center;
        font-size:14px;
        margin-top:5px;
        color:#fffa9e;
    }

    /* OTP BOX */
    .otp-box{
        display:flex;
        justify-content:center;
        gap:12px;
        margin-top:25px;
        flex-wrap:wrap;
    }

    .otp-input{
        width:55px;
        height:60px;
        text-align:center;
        font-size:24px;
        border-radius:10px;
        border:2px solid #ffd500;
        background:#1a1a1a;
        color:#fff;
        outline:none;
        transition:.2s;
    }

    .otp-input:focus{
        border-color:#ffec00;
        box-shadow:0 0 10px #ffec00;
    }

    /* Button */
    .verify-btn{
        margin-top:25px;
        width:100%;
        background:#ffd500;
        color:#000;
        padding:12px;
        font-weight:700;
        border-radius:10px;
        border:none;
        transition:.2s;
    }

    .verify-btn:hover{
        background:#ffec00;
    }

    /* Resend */
    .resend-section{
        text-align:center;
        margin-top:18px;
        color:#fffa9e;
    }

    .resend-btn{
        background:none;
        border:none;
        color:#ffd500;
        font-weight:700;
        text-decoration:underline;
    }


    /* ===================== RESPONSIVE ===================== */
    @media(max-width:768px){

        .otp-wrapper{
            padding:25px 20px;
        }

        .otp-title{
            font-size:22px;
        }

        .otp-input{
            width:45px;
            height:50px;
            font-size:20px;
        }
    }

    @media(max-width:480px){

        .otp-box{
            gap:8px;
        }

        .otp-input{
            width:40px;
            height:45px;
            font-size:18px;
        }
    }

</style>
@endsection



@section('content')

<section style="display:flex;justify-content:center;align-items:center;margin:120px 0;">
    <div class="container">

        <div class="otp-wrapper">

            <h3 class="otp-title">Verify Your Email</h3>

            <p class="otp-sub">
                OTP has been sent to <strong>{{ Auth::user()->email }}</strong>
            </p>

            @if(session('error'))
                <div class="alert alert-danger mt-2">{{ session('error') }}</div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif


            <form method="POST" action="{{ route('verify.otp') }}" id="otpForm" style="padding: 30px 0px !important;">
                @csrf

                <div class="otp-box">
                    {{-- <input type="text" maxlength="1" class="otp-input">
                    <input type="text" maxlength="1" class="otp-input">
                    <input type="text" maxlength="1" class="otp-input">
                    <input type="text" maxlength="1" class="otp-input">
                    <input type="text" maxlength="1" class="otp-input">
                    <input type="text" maxlength="1" class="otp-input"> --}}
                    <input type="tel" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*">
                    <input type="tel" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*">
                    <input type="tel" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*">
                    <input type="tel" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*">
                    <input type="tel" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*">
                    <input type="tel" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*">

                </div>

                <input type="hidden" name="otp" id="otp_value">

                <button type="submit" class="verify-btn">
                    Verify OTP
                </button>

                <div class="resend-section">
                    Didn't receive OTP?
                    <br>
                    <span id="timer">Resend in 60s</span>
                    <button type="button" id="resendBtn" class="resend-btn" style="display:none;">
                        Resend OTP
                    </button>
                </div>

            </form>

        </div>

    </div>
</section>

@endsection



@section('script')
<script>
const inputs = document.querySelectorAll(".otp-input");
const otpInput = document.getElementById("otp_value");

// focus first box on load
inputs[0].focus();

// typing move forward
inputs.forEach((input, index) => {
    input.addEventListener("input", () => {
        if(input.value.length === 1 && index < inputs.length - 1){
            inputs[index + 1].focus();
        }
        collectOTP();
    });

    // backspace move backward
    input.addEventListener("keydown", (e) => {
        if(e.key === "Backspace" && index > 0 && !input.value){
            inputs[index - 1].focus();
        }
    });

    // paste support
    input.addEventListener("paste", (e) => {
        let data = e.clipboardData.getData("text").trim();
        if(data.length === 6){
            data.split("").forEach((num,i)=>{
                inputs[i].value = num;
            });
            inputs[5].focus();
            collectOTP();
        }
        e.preventDefault();
    });
});

// combine OTP
function collectOTP(){
    let otp = "";
    inputs.forEach(i => otp += i.value);
    otpInput.value = otp;
}



// TIMER + RESEND
let seconds = 60;
let timerText = document.getElementById("timer");
let resendBtn = document.getElementById("resendBtn");

let countdown = setInterval(() => {
    seconds--;
    timerText.innerText = `Resend in ${seconds}s`;

    if(seconds <= 0){
        clearInterval(countdown);
        timerText.style.display = "none";
        resendBtn.style.display = "inline-block";
    }

}, 1000);


// RESEND CLICK
resendBtn.addEventListener("click", function(){

    resendBtn.innerText = "Sending...";

    fetch("{{ route('register-user') }}", {
        method:"POST",
        headers:{
            "X-CSRF-TOKEN":"{{ csrf_token() }}",
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            email: "{{ Auth::user()->email }}"
        })
    });

    showToast('success', 'Success', 'OTP Resent!');

    location.reload();
});

</script>
@endsection
