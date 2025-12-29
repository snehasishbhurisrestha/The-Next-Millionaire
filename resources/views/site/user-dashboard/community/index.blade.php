@extends('layouts.user-dashboard')

@section('title','Community')

@section('style')
@endsection
<style>
    .coming-wrapper{
    min-height: calc(100vh - 120px); /* adjusts for header */
    display:flex;
    justify-content:center;
    align-items:center;
}

.coming-card{
    width:100%;
    max-width:700px;
    border-radius:18px;
}

.coming-title{
    color:#ffd700;
    font-weight:800;
}

.coming-sub{
    color:#ddd;
}

.dev-gif{
    width:220px;
    margin:20px 0;
    border-radius:15px;
}

/* Countdown */
.countdown{
    display:flex;
    justify-content:center;
    gap:20px;
    margin-top:10px;
}

.time-box{
    background:#111;
    padding:18px 25px;
    border-radius:12px;
    color:#fff;
    text-align:center;
    border:2px solid #ffd700;
    box-shadow:0 0 15px rgba(255,215,0,0.3);
}

.time-box span{
    font-size:34px;
    font-weight:800;
    display:block;
}

.time-box small{
    font-size:14px;
    opacity:.8;
}
.countdown{
    display:flex;
    justify-content:center;
    gap:20px;
    margin-top:10px;
    flex-wrap:wrap;
}

.time-box{
    background:#111;
    padding:18px 25px;
    border-radius:12px;
    color:#fff;
    text-align:center;
    border:2px solid #ffd700;
    box-shadow:0 0 15px rgba(255,215,0,0.3);
    min-width:120px;
}

@media(max-width:768px){
    .time-box{
        min-width:90px;
        padding:12px 10px;
    }
    .time-box span{
        font-size:26px;
    }
}

@media(max-width:480px){
    .countdown{
        gap:10px;
    }
    .time-box{
        min-width:70px;
    }
}

</style>
@section('content')

{{-- <h1 class="h3 mb-2" style="color: white !important;">Community</h1> --}}
<div class="coming-wrapper">
    <div class=" shadow mb-4 coming-card">
        <div class=" text-center">

            <h2 class="coming-title">🚀 Our Community is Coming Soon!</h2>
            <p class="coming-sub">
                Something exciting is on the way… Stay tuned!
            </p>

            <!-- Developer GIF -->
            <img src="{{ asset('assets/site-assets/dev.gif') }}" class="dev-gif" alt="Developer Working">

            <!-- Countdown -->
            <div id="countdown" class="countdown">
                <div class="time-box">
                    <span id="days"></span>
                    <small>Days</small>
                </div>
                <div class="time-box">
                    <span id="hours"></span>
                    <small>Hours</small>
                </div>
                <div class="time-box">
                    <span id="minutes"></span>
                    <small>Minutes</small>
                </div>
                <div class="time-box">
                    <span id="seconds"></span>
                    <small>Seconds</small>
                </div>
            </div>

            <p class="mt-3 text-warning">
                ⭐ Thank you for your patience. We are building something amazing for you.
            </p>

        </div>
    </div>
</div>

@endsection

@section('script')
@section('script')
<script>
document.addEventListener("DOMContentLoaded", function () {

    let launchDate = Date.UTC(2026, 0, 5, 23, 59, 59);

    function updateTimer(){
        let now = new Date().getTime();
        let diff = launchDate - now;

        if(diff <= 0){
            days.innerText = hours.innerText = minutes.innerText = seconds.innerText = "0";
            return;
        }

        let day = 1000 * 60 * 60 * 24;
        let hour = 1000 * 60 * 60;
        let minute = 1000 * 60;
        let second = 1000;

        let daysLeft = Math.floor(diff / day);
        let hoursLeft = Math.floor((diff % day) / hour);
        let minutesLeft = Math.floor((diff % hour) / minute);
        let secondsLeft = Math.floor((diff % minute) / second);

        document.getElementById("days").innerText = daysLeft;
        document.getElementById("hours").innerText = hoursLeft;
        document.getElementById("minutes").innerText = minutesLeft;
        document.getElementById("seconds").innerText = secondsLeft;
    }

    updateTimer();
    setInterval(updateTimer, 1000);
});

</script>
@endsection




@endsection
