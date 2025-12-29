@extends('layouts.web-app')

@section('title') Registration @endsection
@section('style')
<style>
    .regist_form input::placeholder {
        color: rgba(255, 255, 255, 0.6); /* Slightly white */
    }
</style>
@endsection
@section('content')

    <section style="display: flex; justify-content: center; align-items: center; margin: 140px 0;">
        <div class="container">
            <form  id="registerForm" class="regist_form p-5 rounded" style="background-color: #1a1a1a; color: white; max-width: 700px; margin: auto;">
                @csrf
                <fieldset>
                    <legend style="color: #ffcc00;">Basic Information</legend>

                    <div class="form-group row mb-3">
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Enter First name" style="background-color: #333; color: white; border: 1px solid #555;">
                        </div>
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Enter Last name" style="background-color: #333; color: white; border: 1px solid #555;">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email" style="background-color: #333; color: white; border: 1px solid #555;">
                        </div>
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label for="phone">Mobile Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+91" style="background-color: #333; color: white; border: 1px solid #555;">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" style="background-color: #333; color: white; border: 1px solid #555;">
                        </div>
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="password_confirmation" placeholder="Confirm Password" style="background-color: #333; color: white; border: 1px solid #555;">
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="form-group row justify-content-center mt-4">
                        <div class="col-lg-2 col-md-3 mb-2">
                            <button type="submit" class="buy-now w-100" id="submitBtn">Submit</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </section>


@endsection

@section('script')
<script>
    // $('#email').on('keyup',function(){
    //     $('#login-email').val($(this).val());
    // });
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
$(document).ready(function(){

    $('#submitBtn').click(function(e){
        e.preventDefault();

        let form = $('#registerForm')[0];
        let data = new FormData(form);

        $.ajax({
            url: "{{ route('register-user') }}",
            type: "POST",
            data: data,
            processData: false,
            contentType: false,
            success: function(response){
                console.log(response);

                // Hide the form
                $('#registerForm').hide();

                // Prepare Razorpay options
                var options = {
                    "key": response.razorpay_key, // from server
                    "amount": response.amount, // in paise
                    "currency": response.currency,
                    "name": "The Next Millionaire",
                    "description": "Payment for Subscription",
                    "order_id": response.order_id,
                    "handler": function (paymentResponse){
                        // send payment info to server
                        $.post("{{ route('course.payment.verify') }}", {
                            _token: "{{ csrf_token() }}",
                            razorpay_payment_id: paymentResponse.razorpay_payment_id,
                            razorpay_order_id: paymentResponse.razorpay_order_id,
                            razorpay_signature: paymentResponse.razorpay_signature,
                            course_id : response.cource_id
                        }, function(data){
                            alert('Payment Successful!');
                            window.location.href = "{{ route('dashboard') }}";
                        });
                    },
                    "prefill": {
                        "name": response.user.name,
                        "email": response.user.email,
                        "contact": response.user.phone
                    },
                    "theme": {
                        "color": "#ddc27d"
                    }
                };
                var rzp = new Razorpay(options);
                rzp.open();
            },
            error: function(err){
                if(err.status === 422){
                    let errors = err.responseJSON.errors;
                    let errorMsg = '';
                    $.each(errors, function(key,value){
                        errorMsg += value[0] + '\n';
                    });
                    alert(errorMsg);
                } else {
                    alert('Something went wrong!');
                }
            }
        });
    });

});
</script>

@endsection