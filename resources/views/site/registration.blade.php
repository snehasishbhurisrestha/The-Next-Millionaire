@extends('layouts.web-app')

@section('title') Registration @endsection

@section('style')
<style>
    .regist_form input::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }
    .legend-with-close{
        /* display: flex;
        justify-content: space-between;
        align-items: center;
        color:#ffcc00; */
        position: relative;
    }

    .legend-close {
        color: #fff;
        text-decoration: none;
        font-size: 22px;
        /* background: #ff0000; */
        width: 28px;
        height: 28px;
        border-radius: 50%;
        text-align: center;
        line-height: 30px;
        font-weight: bold;
        position: absolute;
        right: 10px;
        top: 10px;
    }

    .legend-close:hover{
        background:#ff4d4d;
    }

    .toggle-eye{
        position:absolute;
        right:18px;
        top:31px;
        cursor:pointer;
        font-size:18px;
    }


</style>
@endsection

@section('content')

<section style="display: flex; justify-content: center; align-items: center; margin: 140px 0;">
    <div class="container position-relative">
        <form id="registerForm" class="regist_form p-5 rounded legend-with-close" style="background-color: #1a1a1a; color: white; max-width: 700px; margin: auto;">
            @csrf
            <a href="{{ url('/') }}" class="legend-close">×</a>

            <fieldset>
                <legend style="color: #ffcc00;"  class="">Basic Information</legend>

                <div class="form-group row mb-1">
                    <div class="col-lg-6 col-md-6">
                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control"
                               id="first_name"
                               name="first_name"
                               value="{{ old('first_name') }}"
                               placeholder="Enter First name"
                               style="background-color: #333; color: white; border: 1px solid #555;" required>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control"
                               id="last_name"
                               name="last_name"
                               value="{{ old('last_name') }}"
                               placeholder="Enter Last name"
                               style="background-color: #333; color: white; border: 1px solid #555;" required>
                    </div>
                </div>

                <div class="form-group row mb-1">
                    <div class="col-lg-6 col-md-6">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email"
                               class="form-control"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="Email"
                               style="background-color: #333; color: white; border: 1px solid #555;" required>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <label for="phone">Mobile Number <span class="text-danger">*</span></label>
                        <input type="tel"
                               class="form-control"
                               id="phone"
                               name="phone"
                               value="{{ old('phone') }}"
                               placeholder="+91"
                               style="background-color: #333; color: white; border: 1px solid #555;" required>
                    </div>
                </div>

                <div class="form-group row mb-1">
                    <div class="col-lg-6 col-md-6 position-relative">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" required
                            name="password" placeholder="Password"
                            style="background-color:#333;color:white;border:1px solid #555;">

                        <span class="toggle-eye" onclick="togglePassword('password', this)"><i class="fa-solid fa-eye-slash"></i></span>
                    </div>

                    <div class="col-lg-6 col-md-6 position-relative">
                        <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="confirm_password" required
                            name="password_confirmation" placeholder="Confirm Password"
                            style="background-color:#333;color:white;border:1px solid #555;">

                        <span class="toggle-eye" onclick="togglePassword('confirm_password', this)"><i class="fa-solid fa-eye-slash"></i></span>
                    </div>

                </div>
            </fieldset>

            <fieldset>
                <div class="form-group row justify-content-center mt-4">
                    <div class="col-lg-2 col-md-3 mb-2">
                        <button type="submit" class="buy-now w-100" id="submitBtn">
                            Submit
                        </button>
                    </div>
                </div>
            </fieldset>

        </form>
    </div>
</section>

@endsection


@section('script')
<script>
function togglePassword(fieldId, el){
    const input = document.getElementById(fieldId);
    const icon = el.querySelector("i");

    if(input.type === "password"){
        input.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}
</script>


<script>
$(document).ready(function(){
let submitBtn = document.getElementById("submitBtn");
    $('#submitBtn').click(function(e){
        e.preventDefault();

        submitBtn.innerText = "Loading...";

        let form = $('#registerForm')[0];
        let data = new FormData(form);

        $.ajax({
            url: "{{ route('register-user') }}",
            type: "POST",
            data: data,
            processData: false,
            contentType: false,

            success:function(response){
                // console.log(response);

                if(response.status === 'otp_required'){
                    // alert(response.message);
                    window.location.href = response.redirect;
                }
                else if(response.status === 'payment_required'){
                    window.location.href = response.redirect;
                }
                else if(response.status === 'enrolled'){
                    window.location.href = response.redirect;
                }
                else if(response.redirect){
                    window.location.href = response.redirect;
                }
                else{
                    showToast('success', 'Success', 'Success');
                }
            },

            error:function(err){
                submitBtn.innerText = "Submit";
                if(err.status === 422){
                    let errors = err.responseJSON.errors;
                    let msg = '';
                    $.each(errors,function(k,v){
                        msg += v[0] + '\n';
                    });
      
                    showToast('error', 'Error', msg);
                }else{
                    showToast('error', 'Error', 'Something went wrong!');
                }
            }

        });

    });

});
</script>

@endsection
