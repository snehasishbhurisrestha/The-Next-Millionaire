@extends('layouts.app')

@section('title') Auditors Id Card @endsection

@section('style')
<style>
    .id-card-holder {
		width: 320px;
		padding: 4px;
		margin: 0 auto;
		/* background-color: #1f1f1f; */
		border-radius: 5px;
		position: relative;
		box-shadow: 0px 0px 5px 0px #00000047;
        margin: 5px;
        height: 414px;
	}

	.id-card {	
		background-color: #fff;
		padding: 10px;
		border-radius: 10px;
		text-align: center;
		/* box-shadow: 0 0 1.5px 0px #b9b9b9; */
	}
	.id-card img {
		margin: 0 auto;
	}
	.header img {
		width: 75px;
		margin-top: 15px;
	}
	.photo img {
		width: 120px;
		margin-top: 15px;
		height: 120px;
		border-radius: 100%;
		border: 2px solid #71cf2c;
		margin-bottom: 20px;
	}
	h2 {
		font-size: 14px;
		margin: 5px 0;
		color: black;
	}
	h3 {
		font-size: 12px;
		margin: 2.5px 0;
		font-weight: 300;
		color: black;
	}
	.qr-code img {
		width: 50px;
	}
	p {
		font-size: 5px;
		margin: 2px;
	}

	.id-card-tag{
		width: 0;
		height: 0;
		border-left: 100px solid transparent;
		border-right: 100px solid transparent;
		border-top: 100px solid #d9300f;
		margin: -10px auto -30px auto;
	}

	.id-card-tag:after {
		content: '';
		display: block;
		width: 0;
		height: 0;
		border-left: 50px solid transparent;
		border-right: 50px solid transparent;
		border-top: 100px solid white;
		margin: -10px auto -30px auto;
		position: relative;
		top: -130px;
		left: -50px;
	}

    .id-card h4 {
        font-size: 12px;
        color: black;
    }

    h3.id-back-address {
        padding: 69px 0;
    }
</style>
@endsection

@section('content')

<div class="section-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header-action">
                <h1 class="page-title">Auditors Id Card</h1>
                <ol class="breadcrumb page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('auditors.index') }}">Auditors</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Auditor Id Card</li>
                </ol>
            </div>
            <ul class="nav nav-tabs page-header-tab">
                {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}

                <li class="nav-item"><a class="btn btn-info" href="{{ route('auditors.index') }}"><i class="fa fa-arrow-left me-2"></i>Back</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="section-body mt-4">
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">ID Card</h6>
            </div>
            <div class="card-body">
            <a id="btn_print" type="button" value="print" class="btn btn-success mt-3 mb-3 text-light" onclick="">Print ID Card</a>
                <div id="printableArea" class="table-responsive">
                    <div class="d-flex align-items-center justify-content-center text-center" id="PrintMe">
                        <div class="id-card-holder">
                            <div class="id-card">
                                <div class="header">
                                    <P style="font-size: 10px;">SOLAR TATTOO</P>
                                    {{-- <P style="font-size: 10px;">(BSSA)</P>
                                    <P style="font-size: 10px;">Affiliated to DSA (Bankura)</P>
                                    <P style="font-size: 10px;">Estd. - 1948</P>
                                    <p style="font-size: 10px;">P.O. : Bishnupur, Dist.-Bankura, Pin-722122</p>
                                    <p style="font-size: 10px;">Ph. No. : 9932481642</p> --}}
                                </div>
                                <hr>
                                <h2>IDENTITY CARD</h2>
                                <div class="photo">
                                    <img src="{{ $auditor->getFirstMediaUrl('auditors-image') }}">
                                </div>
                                <h2>{{ $auditor->name }}</h2>
                                <h3><b>Auditor</b></h3>
                                @if(!empty($auditor->user_id))
                                <h3>({{ $auditor->user_id }})</h3>
                                @endif
                                <h3>Address: {{ $auditor->address }}</h3>
                                <!-- <div class="qr-code">
                                    
                                </div> -->
                                {{-- <h3>ID : {{ $student->roll_no }}</h3> --}}
                                <h3>Ph. No. : {{ $auditor->phone }}</h3>
                                <h3>DOB : {{ format_date($auditor->date_of_birth) }}</h3>
                                {{-- <hr>
                                <p><strong>BSSA</strong><p>
                                <p>Addess</p> --}}
                            </div>
                        </div>
                        {{-- <div class="id-card-holder">
                            <div class="id-card">
                                <div class="header">
                                    <img src="logo">
                                </div>
                                <!-- <div class="qr-code">
                                    
                                </div> -->
                                <h3 class="id-back-address">rhgfuy</h3>
                                <img src="https://codeofdolphins.com/backup/hospital/assets/images/cards/d89ec4041dc4180be6fdc3ba625b5994.png" alt="">
                                <hr>
                                <h4>Authorized Signature</h4>
                            </div>
                            
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#btn_print').click(function() {
            var printContents = $('#printableArea').html();
            var originalContents = $('body').html();

            $('body').html(printContents);
            window.print();
            $('body').html(originalContents);
        });
    });
</script>
@endsection
