
            @include('layouts.dashboards.public_head')
            @include('layouts.dashboards.nav') 
            <link href="css/main.pro.css" rel="stylesheet">
            <div class="container-fluite public_page_containers">
                <div class="space"></div>
                <!-- requesting from ............  -->
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6"
                    style="background-color: white; border-radius: 24px;">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="text-center">
                                <p style="color: rgb(0, 74, 89);font-weight: 800;">
                                    Who are you sending pop-up to?
                                </p>
                            </div>
                            <form method="POST" action="{{ route('process_form') }}">
                                @csrf
                                <div class="tim-title ">
                                    <input type="tel" id="phone" class="form-control sending_credit_to " name="phone" maxlength="9" minlength="9" placeholder="Enter Phone Number" required />
                                    
                                    <!-- Hidden input field to pass the phone value -->
                                    <input type="hidden" id="hiddenPhone" name="hiddenPhone" />
                                </div>
                                <div class="tim-title">
                                    <button class="table btn btn-block btn-md btn-fill btn-round sc-jqUVSM iHBits sc-iqcoie hTMjCv"
                                    type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="space"></div>
            <!-- the faster way to ............  -->
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 the_tastest_way">
                <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="tim-title fastest-way">
                              <p>
                                <b>The fastest way to send mobile recharge worldwide</b> 
                                Ding delivers 99% of phone top-ups in under 3 seconds.
                                Keeping in touch has never been easier or more secure.
                              </p>
                              <h4><i class="fa fa-star"></i>Trust Poilot</h4>
                            </div>
                            <div class="tim-title trust-poilot">
                                <p>4.6 Rated Excellent based on 13,805 reviews</p>
                                <img style="max-width: 10rem;" src="{{ asset('assets/img/user/globe.png') }}" alt="">
                            </div>
                        </div>
                        <div class="col-md-1">
                        </div>
                    </div>

                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        
<script src="{{ asset('public_assets/jquery/jquery-1.10.2.js') }}"></script>
<script src="{{ asset('public_assets/assets/js/jquery-ui-1.10.4.custom.min.js') }}"></script>
<script src="{{ asset('public_assets/bootstrap3/js/bootstrap.js') }}"></script>
<script src="{{ asset('public_assets/assets/js/gsdk-checkbox.js') }}"></script>
<script src="{{ asset('public_assets/assets/js/gsdk-radio.js') }}"></script>
<script src="{{ asset('public_assets/assets/js/gsdk-bootstrapswitch.js') }}"></script>
<script src="{{ asset('public_assets/assets/js/get-shit-done.js') }}"></script>


<!--  country codes scripts -->
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            initialCountry: 'af',
            placeholderNumberType: 'FIXED_LINE',
            separateDialCode: true,
        });
    </script>
<!--  country codes scripts -->