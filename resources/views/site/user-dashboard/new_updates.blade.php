@extends('layouts.user-dashboard')

@section('title','Community Updates')

@section('style')
<style>

    /* Page Wrapper */
    .updates-wrapper{
        padding:40px 20px;
    }

    /* Page Title */
    .page-title{
        font-size:28px;
        font-weight:800;
        color:#ffd700;
        margin-bottom:30px;
    }

    /* Update Card */
    .update-card{
        /* background: linear-gradient(145deg,#1a1a1a,#111); */
        background: linear-gradient(145deg, #1a1a1a00, #1111119c);
        border-radius:18px;
        padding:25px;
        margin-bottom:25px;
        border:1px solid rgba(255,215,0,0.2);
        box-shadow:0 10px 25px rgba(0,0,0,0.4);
        transition:0.4s ease;
        position:relative;
        overflow:hidden;
    }

    .update-card:hover{
        transform:translateY(-6px);
        box-shadow:0 15px 40px rgba(255,215,0,0.2);
        border:1px solid rgba(255,215,0,0.5);
    }

    /* Glow Animation */
    .update-card::before{
        content:'';
        position:absolute;
        top:0;
        left:-100%;
        width:100%;
        height:100%;
        background:linear-gradient(120deg,transparent,rgba(255,215,0,0.12),transparent);
        transition:0.6s;
    }

    .update-card:hover::before{
        left:100%;
    }

    /* Description */
    .update-desc{
        color:#eee;
        font-size:16px;
        line-height:1.7;
    }

    /* Footer */
    .update-footer{
        margin-top:20px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
    }

    /* Author */
    .update-author{
        font-size:14px;
        color:#ccc;
    }

    /* Time */
    .update-time{
        font-size:13px;
        color:#ffd700;
        font-weight:600;
    }

    /* Badge */
    .update-badge{
        background:#ffd700;
        color:#000;
        font-size:11px;
        padding:5px 10px;
        border-radius:20px;
        font-weight:700;
        margin-bottom:12px;
        display:inline-block;
    }

    @media(max-width:768px){
        .page-title{
            font-size:22px;
        }
    }

    .update-desc a {
        color: #ffff;
    }

</style>
@endsection

@section('content')

<div class="updates-wrapper">

    <h2 class="page-title text-center">New Updates</h2>

    @forelse($updates as $update)

        <div class="update-card">

            <div class="update-desc">
                {!! $update->description !!}
            </div>

            <div class="update-footer">
                <div class="update-author">
                    {{-- 👤 {{ $update->user->name ?? 'Admin' }} --}}
                </div>

                <div class="update-time">
                    {{ $update->created_at->diffForHumans() }}
                </div>
            </div>

        </div>

    @empty
        <div class="text-center text-muted mt-5">
            No updates available yet
        </div>
    @endforelse

</div>

@endsection