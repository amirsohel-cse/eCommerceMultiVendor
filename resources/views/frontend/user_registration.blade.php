@extends('frontend.layouts.app')

@section('content')
    <section class="gry-bg py-4">
        <div class="profile">
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1">
                        <div class="card">
                            <div class="text-center px-35 pt-5">
                                <h3 class="heading heading-4 strong-500">
                                    {{__('Create an account.')}}
                                </h3>
                            </div>
                            <div class="px-5 py-3 py-lg-5">
                                <div class="row align-items-center">
                                    <div class="col-12 col-lg">
                                        <form class="form-default" role="form" action="{{ route('register') }}" method="POST">
                                            @csrf
                                            {{--mobile number verification--}}
                                            <div id="number_verification">
                                                <div class="row">                                                    
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                        <!-- <label>{{ __('name') }}</label> -->
                                                            <div class="input-group input-group--style-1">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">+966</span>
                                                                  </div>
                                                                <input type="text" class="form-control{{ $errors->has('mobile_number') ? ' is-invalid' : '' }}" value="{{ old('mobile_number') }}" placeholder="Mobile Number" name="mobile_number" id="mobile_number" required>
                                                                <span class="input-group-addon">
                                                                <i class="text-md la la-mobile-phone"></i>
                                                            </span>
                                                            @if ($errors->has('mobile_number'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('mobile_number') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <span class="phn_msg"></span>
                                                        </div>
                                                        <div class="col-md-12" id="recaptcha-container"></div>
                                                        <div class="col-md-12" style="padding-bottom: 10px; color:red;" id="mobile_verfication"></div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center">
                                                    <div class="col-12 text-right  mt-3">
                                                        <input onclick="smsLogin()" class="btn btn-styled btn-base-1 w-100 btn-md" value="Verify Mobile Number" type="button"></input>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--mobile number verification--}}

                                            <div id="verification_code" style="display: none;">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="input-group input-group--style-1">
                                                                <input type="text" class="form-control{{ $errors->has('verify_code') ? ' is-invalid' : '' }}" value="{{ old('verify_code') }}" placeholder="Verification Code" name="verify_code" id="verify_code">
                                                                <span class="input-group-addon">
                                                                <i class="text-md la la-user"></i>
                                                            </span>
                                                                @if ($errors->has('verify_code'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('verify_code') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                            <span class="ver_msg"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center">
                                                    <div class="col-12 text-right  mt-3">
                                                        <input onclick="codeverify()" class="btn btn-styled btn-base-1 w-100 btn-md" value="Verify Code" type="button"></input>
                                                    </div>
                                                </div>
                                            </div>
                                         <div id="registration_step" style="display: none;">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <!-- <label>{{ __('name') }}</label> -->
                                                        <div class="input-group input-group--style-1">
                                                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{ __('Name') }}" name="name">
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-user"></i>
                                                            </span>
                                                            @if ($errors->has('name'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('name') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <!-- <label>{{ __('email') }}</label> -->
                                                        <div class="input-group input-group--style-1">
                                                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ __('Email') }}" name="email">
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-envelope"></i>
                                                            </span>
                                                            @if ($errors->has('email'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('email') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <!-- <label>{{ __('password') }}</label> -->
                                                        <div class="input-group input-group--style-1">
                                                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" name="password">
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-lock"></i>
                                                            </span>
                                                            @if ($errors->has('password'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('password') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <!-- <label>{{ __('confirm_password') }}</label> -->
                                                        <div class="input-group input-group--style-1">
                                                            <input type="password" class="form-control" placeholder="{{ __('Confirm Password') }}" name="password_confirmation">
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-lock"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}">
                                                            @if ($errors->has('g-recaptcha-response'))
                                                                <span class="invalid-feedback" style="display:block">
                                                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="checkbox pad-btm text-left">
                                                        <input class="magic-checkbox" type="checkbox" name="checkbox_example_1" id="checkboxExample_1a">
                                                        <label for="checkboxExample_1a" class="text-sm">{{__('By signing up you agree to our')}} <a target="_blank" href="/terms" class="btn-link text-bold">{{__('Terms and Conditions')}}</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row align-items-center">
                                                <div class="col-12 text-right  mt-3">
                                                    <button type="submit" class="btn btn-styled btn-base-1 w-100 btn-md">{{ __('Create Account') }}</button>
                                                </div>
                                            </div>
                                         </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-1 text-center align-self-stretch">
                                        <div class="border-right h-100 mx-auto" style="width:1px;"></div>
                                    </div>
                                    <div class="col-12 col-lg">
                                        @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                            <a href="{{ route('social.login', ['provider' => 'google']) }}" class="btn btn-styled btn-block btn-google btn-icon--2 btn-icon-left px-4 my-4">
                                                <i class="icon fa fa-google"></i> {{__('Login with Google')}}
                                            </a>
                                        @endif
                                        @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                            <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="btn btn-styled btn-block btn-facebook btn-icon--2 btn-icon-left px-4 my-4">
                                                <i class="icon fa fa-facebook"></i> {{__('Login with Facebook')}}
                                            </a>
                                        @endif
                                        @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="btn btn-styled btn-block btn-twitter btn-icon--2 btn-icon-left px-4 my-4">
                                            <i class="icon fa fa-twitter"></i> {{__('Login with Twitter')}}
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-center px-35 pb-3">
                                <p class="text-md">
                                    {{__('Already have an account?')}}<a href="{{ route('user.login') }}" class="strong-600">{{__('Log In')}}</a>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')    
    <script type="text/javascript">
        function autoFillSeller(){
            $('#email').val('seller@example.com');
            $('#password').val('123456');
        }
        function autoFillCustomer(){
            $('#email').val('customer@example.com');
            $('#password').val('123456');
        }

        // phone form submission handler
        function smsLogin() {
            var countryCode = "+966";
            var phoneNumber = document.getElementById("mobile_number").value;
            // $('#mobile_verfication').html("");
            var number_verfication_form = document.getElementById("number_verification");
            var orphn = countryCode+phoneNumber;
            
            //  phoneAuth();
            $.post("{{route('user.verify_number')}}",{ _token: '{{csrf_token()}}', mobile :phoneNumber, country_code : countryCode })
            .done(function(data){
                if(data.status==1){
                    number_verfication_form.style="display:none";
                        phoneAuth(orphn);
                    }else{
                        number_verfication_form.style="display:block";
                        $('#phn_msg').html("<p class='helper'> "+" The given phone number is taken by another user. Please try using another number. "+" </p>");
                    }
                })
                .fail(function(xhr, status, error) {
                    $('#phn_msg').html("<p class='helper'> "+xhr.responseJSON.message+" </p>");
                });
        }

        function phoneAuth(phn) {
            $.get("{{route('phn.sendCode')}}",{ _token: '{{csrf_token()}}', mobile :phn })
            .done(function(data){
                if(data.status == "success"){
                    alert(data.message);
                    $('#verification_code').show();
                    $('.ver_msg').html("<p class='helper'>Verification Code Sent Successfully.</p>");
                }else{
                    $('#verification_code').hide();
                    $('#mobile_verfication').show();
                    $('.phn_msg').html("<p class='helper'> "+xhr.responseJSON.message+" </p>");
                }
            })
            .fail(function(xhr, status, error) {
                $('.phn_msg').html("<p class='helper'> "+xhr.responseJSON.message+" </p>");
            });  
        }
        function codeverify() {
            var code = $('#verify_code').val();
            $.get("{{route('phn.verifyCode')}}",{ _token: '{{csrf_token()}}', code :code })
            .done(function(data){
                if(data.status == "success"){
                    console.log(data);
                    $('#verification_code').hide();
                    $('#registration_step').show();
                }else{
                    $('#mobile_verfication').hide();
                    $('#verification_code').show();
                    $('.ver_msg').html("<p class='helper'>Verification Code Does not Match </p>");
                }
            })
            .fail(function(xhr, status, error) {
                $('.ver_msg').html("<p class='helper'> "+xhr.responseJSON.message+" </p>");
            });
        }
    </script>

    </script>
@endsection
