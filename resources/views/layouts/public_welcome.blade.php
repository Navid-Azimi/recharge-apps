
                <link href="css/main.pro.css" rel="stylesheet">
               

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

                        <div class="col-md-7 col-md" id="my-top-up" style="background-color: white; padding-bottom: 2.7%;">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8" style="margin-top: 18rem;">
                                    <div class="tim-title">
                                        <h1 class="text-center">Welcome back</h1>
                                    </div>

                                    <div class="tim-title">
                                        <a href="#" class="table btn btn-block btn-sm btn-fill btn-round sc-jqUVSM iHBits sc-iqcoie hTMjCv">Log in with email</a>
                                    </div>

                                    <div class="tim-title" id="phone-login-section">
                                        <a href="#" class="table btn btn-block btn-md btn-round" onclick="showPhoneLogin();">Log in with phone number</a>
                                    </div>
                                    <!-- social ocons divider  -------->
                                    <div class="tim-title row-text-center">
                                        <hr class="hr-line">
                                        <div class="or-text">OR</div>
                                        <hr class="hr-line">
                                    </div>
                                    <!-- social ocons divider  -------->
                                    <!-- social icon -->
                                    <div class="tim-title text-center">
                                        <div class="social-icons">
                                            <i style="font-size: 5rem; lue;" class="fa fa-facebook-square fa-fw"></i>
                                            
                                            <a href="{{ url('auth/google') }}">
                                                <i style="font-size: 5rem; lue;" class="fa fa-google-plus-square fa-fw"></i>
                                            </a> 
                                            <hr> 
                                        </div>
                                    </div>
                                    <!-- social icon -->
                                    <!-- Create account -->
                                    <div class="new-to-KikWek" style="text-align: center;">
                                        <a href="#" class="backTo">New to KikWek ? Create account
                                            <i class="fa fa-arrow-right"></i> 
                                        </a>
                                    </div>
                                    <!-- Create account -->
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>

                        <div class="col-md" id="public-mobile2-section" style="display: none;">
                            @include('layouts.public_mobile')
                        </div>

                        <script type="text/javascript">
                            function showPhoneLogin() {
                                document.getElementById("my-top-up").style.display = "none";
                                document.getElementById("phone-login-section").style.display = "none";
                                document.getElementById("public-mobile2-section").style.display = "block";
                            }
                        </script>
                    </div>  
                </div> 

            <!-- <div class="space-30"></div> -->