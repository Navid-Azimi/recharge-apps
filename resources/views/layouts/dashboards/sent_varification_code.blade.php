
@include('layouts.dashboards.public_head')

        @include('layouts.dashboards.nav')
        <!-- sending verirfication code  ---------------------->

                
                <div class="row laptop-screen-height">
                    <div class="col-md-5 col-md" style="background-color: #ccfff6;  padding-bottom: 3%;">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8 text-center" style="margin-top: 18rem;">
                                <div class="tim-title">
                                    <h1 class="text-center"
                                    style="font-size: 8rem;
                                    font-weight: 600;
                                    color: #004A59;
                                    font-family: sans-serif;
                                    letter-spacing: 0px;">HELLO CIAO HOLA
                                </div>
                            
                                <div class="tim-title privacy_policy">
                                    <p style="color: rgb(112, 140, 140); font-size: 16px;">
                                        By continuing, you agree to our<a href="#">Terms and Conditions</a> and 
                                        acknowledge our use of your information in accordance with our
                                        <a href="#">Privacy  Notice.</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>

                    <div class="col-md-7 col-md" id="my-top-up" style="background-color: white; padding-bottom: 7.4%;">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8" style="margin-top: 18rem;">
                                <div class="tim-title">
                                    <a href="http://127.0.0.1:8000/" class="backTo">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
                                    <h3 class="text-center"><b>Please enter the verification code sent to:</b> </h3>
                                    <h4 class="text-center">
                                        <span>{{$phone}}</span>
                                        <i style="color: #2ca8ff; font-size: 17px;" class="fa fa-pencil"></i>
                                    </h4>
                                </div>

                                <div class="text-center" id="phone-login-section">
                                    <form action="{{ route('verify_code') }}" method="GET">
                                        @csrf
                                        <section class="text-center">
                                            <div class="form-group">
                                                <h3>
                                                    <input style="border: none; outline: none; font-size: 4rem;" 
                                                    class="borderless-input text-center"
                                                    type="text" name="verification_code" placeholder="__  __ __ __" />
                                                </h3>
                                                <br>
                                            </div>
                                            <div class="form-group">
                                                <button class="table btn btn-block btn-lg btn-info btn-fill btn-round">Verify Code</button>
                                            </div>
                                        </section>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>  

    <!-- sending verirfication code  ---------------------->