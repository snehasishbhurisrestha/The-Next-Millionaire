@extends('layouts.user-dashboard')

@section('title','Support')

@section('style')
<style>

    .support-wrapper{
        padding:40px 20px;
    }

    .support-banner{
        position:relative;
        width:100%;
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 15px 40px rgba(0,0,0,0.4);
    }

    .support-banner img{
        width:100%;
        height:auto; /* Important */
        display:block;
    }

    /* Dark overlay */
    .support-overlay{
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8));
        display:flex;
        align-items:flex-end;
        justify-content:center;
        padding-bottom:40px;
    }

    .support-btn{
        background:#ffd700;
        color:#000;
        padding:14px 35px;
        border-radius:50px;
        font-weight:700;
        font-size:16px;
        text-decoration:none;
        transition:0.3s ease;
        box-shadow:0 8px 25px rgba(255,215,0,0.3);
    }

    .support-btn:hover{
        background:#fff;
        transform:translateY(-3px);
        box-shadow:0 12px 30px rgba(255,215,0,0.5);
    }

    @media(max-width:768px){
        .support-banner img{
            height:350px;
        }

        .support-btn{
            padding:12px 28px;
            font-size:14px;
        }
    }

    .special-btn{
        display:inline-block;
        padding:14px 28px;
        border-radius:50px;
        font-weight:700;
        color:#000;
        background: linear-gradient(145deg,#ffd700,#ffb400,#000000);
        text-decoration:none;
        border:2px solid #ffea00;
        transition:.3s;
        margin: 10px 5px;
    }

    .special-btn:hover{
        transform:scale(1.05);
        background: linear-gradient(145deg,#000000,#ffb400,#ffd700);
        color:#fff;
    }

</style>
@endsection

@section('content')

<div class="support-wrapper">

    <div class="support-banner">
        <img src="{{ asset('assets/site-assets/images/Community & Support.png') }}" alt="Support Banner">

        <div class="support-overlay">
            <a href="https://wa.me/+917980395623" class="special-btn">
                Contact Support
            </a>
        </div>
    </div>

</div>

@endsection