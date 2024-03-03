@include('layouts.dashboards.public_head')
@include('layouts.dashboards.nav') 
<!-- requesting from ............  -->
        <div class="container-fluite public_page_containers">
            <div class="space"></div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 summary_main_content">                        
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="summary_title">You're sending 
                                    <b>174 AFN (before AIT)</b>
                                </h4>
                            </div>
                            <div class="col-sm-12 summarry_main_class" >
                                <div class="summary_left_cont">
                                    <span><b>To:</b></span>
                                    <P><i class="fa fa-pencil"></i></P>
                                </div>
                                <div class="summary_left_cont">
                                    <span><b>{{ session('phoneNumber') }}</b></span>
                                    <P><i class="fa fa-pencil"></i></P>
                                </div>
                                <hr>
                                <div class="summary_left_cont">
                                    <summary><b>Package Amount:</b></summary>
                                    <summary><b>{{ $package->pck_credit_amount }} </b></summary>
                                </div>
                                <div class="summary_left_cont">
                                    <summary><b>Fee:</b></summary>
                                    <summary><b>{{ $package->pck_price }}</b></summary>
                                </div>
                                <div class="summary_left_cont">
                                    <summary><b>You pay:</b></summary>
                                    <summary><b>{{ $package->pck_minutes_amount }}</b></summary>
                                </div>
                                <div class="summary_left_cont">
                                    <summary><b>Receiver gets (after AIT):</b></summary>
                                    <button class="my-collapsed-datat" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="fa fa-caret-down"></i>
                                    </button>
                                </div>
                                <div class="collapse" id="collapseExample">
                                    <div class="summary_left_cont">
                                        <summary><b>Amount sent:</b></summary>
                                        <summary><b>{{ @$package->pck_minutes_amount }}</b> <small>{{ @$package->pck_currency_id }}</small> </summary>
                                    </div>
                                    <div class="summary_left_cont">
                                        <summary><b>AIT:</b></summary>
                                        <summary><b>{{ @$package->pck_minutes_amount }} </b><small>{{ @$package->pck_currency_id }}</small> </summary>
                                    </div>
                                    <div class="summary_left_cont">
                                        <summary><b>Total received:</b></summary>
                                        <summary><b>156.60 AFN</b></summary>
                                    </div>
                                </div>
                                <div class="summary_left_cont">
                                    <summary><b>Transfer Time:</b></summary>
                                    <summary style="color: #708C8C;">⚡ within seconds</summary>
                                </div>
                            </div>

                            <hr>

                            <h2 class="text-center"><strong>Payment Details</strong></h2>

                            <br>

                            <div class="col-sm-12">
                                <div class="row">
                                        <div class='form-row row'>
                                            <div class='col-xs-12 form-group required'>
                                                <center><img src="{{ asset('assets/img/payments.png') }}" alt="Logo" height="70px" width="100%"></center>
                                            </div>
                                        </div>
                                    
                                    <form 
                                        role="form" 
                                        action="{{ route('stripe.post') }}" 
                                        method="post" 
                                        class="require-validation"
                                        data-cc-on-file="false"
                                        data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                        id="payment-form">
                                        @csrf
                
                                        <div class='form-row row'>
                                            <div class='col-xs-12 form-group required'>
                                                <label class='control-label'>Card Number</label> 
                                                <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                                            </div>
                                        </div>
                    
                                        <div class='form-row row'>
                                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                                <label class='control-label'>CVC</label> 
                                                <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                                            </div>
                                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                <label class='control-label'>Expiration Month</label> <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                                            </div>
                                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                <label class='control-label'>Expiration Year</label> 
                                                <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                                            </div>
                                        </div>

                                        <div class='form-row row'>
                                            <div class='col-xs-12 form-group required'>
                                                <label class='control-label'>Name on Card</label> 
                                                <input class='form-control' size='4' type='text'>
                                            </div>
                                        </div>
                    
                                        <div class="row">
                                            <div class="col-xs-12 form-group">
                                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now ($100)</button>
                                            </div>
                                        </div>
                                        
                                    </form>
                                
                                    <center>
                                        <a href="{{ route('make.payment') }}" >
                                            <button class="btn btn-block btn-lg btn-info btn-fill btn-round">
                                                <span class="paypal-button-text true" optional="" data-v-44bf4aee="">Pay with </span>
                                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAxcHgiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAxMDEgMzIiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaW5ZTWluIG1lZXQiIHhtbG5zPSJodHRwOiYjeDJGOyYjeDJGO3d3dy53My5vcmcmI3gyRjsyMDAwJiN4MkY7c3ZnIj48cGF0aCBmaWxsPSIjZmZmZmZmIiBkPSJNIDEyLjIzNyAyLjggTCA0LjQzNyAyLjggQyAzLjkzNyAyLjggMy40MzcgMy4yIDMuMzM3IDMuNyBMIDAuMjM3IDIzLjcgQyAwLjEzNyAyNC4xIDAuNDM3IDI0LjQgMC44MzcgMjQuNCBMIDQuNTM3IDI0LjQgQyA1LjAzNyAyNC40IDUuNTM3IDI0IDUuNjM3IDIzLjUgTCA2LjQzNyAxOC4xIEMgNi41MzcgMTcuNiA2LjkzNyAxNy4yIDcuNTM3IDE3LjIgTCAxMC4wMzcgMTcuMiBDIDE1LjEzNyAxNy4yIDE4LjEzNyAxNC43IDE4LjkzNyA5LjggQyAxOS4yMzcgNy43IDE4LjkzNyA2IDE3LjkzNyA0LjggQyAxNi44MzcgMy41IDE0LjgzNyAyLjggMTIuMjM3IDIuOCBaIE0gMTMuMTM3IDEwLjEgQyAxMi43MzcgMTIuOSAxMC41MzcgMTIuOSA4LjUzNyAxMi45IEwgNy4zMzcgMTIuOSBMIDguMTM3IDcuNyBDIDguMTM3IDcuNCA4LjQzNyA3LjIgOC43MzcgNy4yIEwgOS4yMzcgNy4yIEMgMTAuNjM3IDcuMiAxMS45MzcgNy4yIDEyLjYzNyA4IEMgMTMuMTM3IDguNCAxMy4zMzcgOS4xIDEzLjEzNyAxMC4xIFoiPjwvcGF0aD48cGF0aCBmaWxsPSIjZmZmZmZmIiBkPSJNIDM1LjQzNyAxMCBMIDMxLjczNyAxMCBDIDMxLjQzNyAxMCAzMS4xMzcgMTAuMiAzMS4xMzcgMTAuNSBMIDMwLjkzNyAxMS41IEwgMzAuNjM3IDExLjEgQyAyOS44MzcgOS45IDI4LjAzNyA5LjUgMjYuMjM3IDkuNSBDIDIyLjEzNyA5LjUgMTguNjM3IDEyLjYgMTcuOTM3IDE3IEMgMTcuNTM3IDE5LjIgMTguMDM3IDIxLjMgMTkuMzM3IDIyLjcgQyAyMC40MzcgMjQgMjIuMTM3IDI0LjYgMjQuMDM3IDI0LjYgQyAyNy4zMzcgMjQuNiAyOS4yMzcgMjIuNSAyOS4yMzcgMjIuNSBMIDI5LjAzNyAyMy41IEMgMjguOTM3IDIzLjkgMjkuMjM3IDI0LjMgMjkuNjM3IDI0LjMgTCAzMy4wMzcgMjQuMyBDIDMzLjUzNyAyNC4zIDM0LjAzNyAyMy45IDM0LjEzNyAyMy40IEwgMzYuMTM3IDEwLjYgQyAzNi4yMzcgMTAuNCAzNS44MzcgMTAgMzUuNDM3IDEwIFogTSAzMC4zMzcgMTcuMiBDIDI5LjkzNyAxOS4zIDI4LjMzNyAyMC44IDI2LjEzNyAyMC44IEMgMjUuMDM3IDIwLjggMjQuMjM3IDIwLjUgMjMuNjM3IDE5LjggQyAyMy4wMzcgMTkuMSAyMi44MzcgMTguMiAyMy4wMzcgMTcuMiBDIDIzLjMzNyAxNS4xIDI1LjEzNyAxMy42IDI3LjIzNyAxMy42IEMgMjguMzM3IDEzLjYgMjkuMTM3IDE0IDI5LjczNyAxNC42IEMgMzAuMjM3IDE1LjMgMzAuNDM3IDE2LjIgMzAuMzM3IDE3LjIgWiI+PC9wYXRoPjxwYXRoIGZpbGw9IiNmZmZmZmYiIGQ9Ik0gNTUuMzM3IDEwIEwgNTEuNjM3IDEwIEMgNTEuMjM3IDEwIDUwLjkzNyAxMC4yIDUwLjczNyAxMC41IEwgNDUuNTM3IDE4LjEgTCA0My4zMzcgMTAuOCBDIDQzLjIzNyAxMC4zIDQyLjczNyAxMCA0Mi4zMzcgMTAgTCAzOC42MzcgMTAgQyAzOC4yMzcgMTAgMzcuODM3IDEwLjQgMzguMDM3IDEwLjkgTCA0Mi4xMzcgMjMgTCAzOC4yMzcgMjguNCBDIDM3LjkzNyAyOC44IDM4LjIzNyAyOS40IDM4LjczNyAyOS40IEwgNDIuNDM3IDI5LjQgQyA0Mi44MzcgMjkuNCA0My4xMzcgMjkuMiA0My4zMzcgMjguOSBMIDU1LjgzNyAxMC45IEMgNTYuMTM3IDEwLjYgNTUuODM3IDEwIDU1LjMzNyAxMCBaIj48L3BhdGg+PHBhdGggZmlsbD0iI2ZmZmZmZiIgZD0iTSA2Ny43MzcgMi44IEwgNTkuOTM3IDIuOCBDIDU5LjQzNyAyLjggNTguOTM3IDMuMiA1OC44MzcgMy43IEwgNTUuNzM3IDIzLjYgQyA1NS42MzcgMjQgNTUuOTM3IDI0LjMgNTYuMzM3IDI0LjMgTCA2MC4zMzcgMjQuMyBDIDYwLjczNyAyNC4zIDYxLjAzNyAyNCA2MS4wMzcgMjMuNyBMIDYxLjkzNyAxOCBDIDYyLjAzNyAxNy41IDYyLjQzNyAxNy4xIDYzLjAzNyAxNy4xIEwgNjUuNTM3IDE3LjEgQyA3MC42MzcgMTcuMSA3My42MzcgMTQuNiA3NC40MzcgOS43IEMgNzQuNzM3IDcuNiA3NC40MzcgNS45IDczLjQzNyA0LjcgQyA3Mi4yMzcgMy41IDcwLjMzNyAyLjggNjcuNzM3IDIuOCBaIE0gNjguNjM3IDEwLjEgQyA2OC4yMzcgMTIuOSA2Ni4wMzcgMTIuOSA2NC4wMzcgMTIuOSBMIDYyLjgzNyAxMi45IEwgNjMuNjM3IDcuNyBDIDYzLjYzNyA3LjQgNjMuOTM3IDcuMiA2NC4yMzcgNy4yIEwgNjQuNzM3IDcuMiBDIDY2LjEzNyA3LjIgNjcuNDM3IDcuMiA2OC4xMzcgOCBDIDY4LjYzNyA4LjQgNjguNzM3IDkuMSA2OC42MzcgMTAuMSBaIj48L3BhdGg+PHBhdGggZmlsbD0iI2ZmZmZmZiIgZD0iTSA5MC45MzcgMTAgTCA4Ny4yMzcgMTAgQyA4Ni45MzcgMTAgODYuNjM3IDEwLjIgODYuNjM3IDEwLjUgTCA4Ni40MzcgMTEuNSBMIDg2LjEzNyAxMS4xIEMgODUuMzM3IDkuOSA4My41MzcgOS41IDgxLjczNyA5LjUgQyA3Ny42MzcgOS41IDc0LjEzNyAxMi42IDczLjQzNyAxNyBDIDczLjAzNyAxOS4yIDczLjUzNyAyMS4zIDc0LjgzNyAyMi43IEMgNzUuOTM3IDI0IDc3LjYzNyAyNC42IDc5LjUzNyAyNC42IEMgODIuODM3IDI0LjYgODQuNzM3IDIyLjUgODQuNzM3IDIyLjUgTCA4NC41MzcgMjMuNSBDIDg0LjQzNyAyMy45IDg0LjczNyAyNC4zIDg1LjEzNyAyNC4zIEwgODguNTM3IDI0LjMgQyA4OS4wMzcgMjQuMyA4OS41MzcgMjMuOSA4OS42MzcgMjMuNCBMIDkxLjYzNyAxMC42IEMgOTEuNjM3IDEwLjQgOTEuMzM3IDEwIDkwLjkzNyAxMCBaIE0gODUuNzM3IDE3LjIgQyA4NS4zMzcgMTkuMyA4My43MzcgMjAuOCA4MS41MzcgMjAuOCBDIDgwLjQzNyAyMC44IDc5LjYzNyAyMC41IDc5LjAzNyAxOS44IEMgNzguNDM3IDE5LjEgNzguMjM3IDE4LjIgNzguNDM3IDE3LjIgQyA3OC43MzcgMTUuMSA4MC41MzcgMTMuNiA4Mi42MzcgMTMuNiBDIDgzLjczNyAxMy42IDg0LjUzNyAxNCA4NS4xMzcgMTQuNiBDIDg1LjczNyAxNS4zIDg1LjkzNyAxNi4yIDg1LjczNyAxNy4yIFoiPjwvcGF0aD48cGF0aCBmaWxsPSIjZmZmZmZmIiBkPSJNIDk1LjMzNyAzLjMgTCA5Mi4xMzcgMjMuNiBDIDkyLjAzNyAyNCA5Mi4zMzcgMjQuMyA5Mi43MzcgMjQuMyBMIDk1LjkzNyAyNC4zIEMgOTYuNDM3IDI0LjMgOTYuOTM3IDIzLjkgOTcuMDM3IDIzLjQgTCAxMDAuMjM3IDMuNSBDIDEwMC4zMzcgMy4xIDEwMC4wMzcgMi44IDk5LjYzNyAyLjggTCA5Ni4wMzcgMi44IEMgOTUuNjM3IDIuOCA5NS40MzcgMyA5NS4zMzcgMy4zIFoiPjwvcGF0aD48L3N2Zz4" data-v-b01da731="" alt="" role="presentation" class="paypal-logo paypal-logo-paypal paypal-logo-color-white">
                                        </button>
                                        </a>
                                    </center>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <div class="space"></div>

<script src="{{ asset('public_assets/jquery/jquery-1.10.2.js') }}"></script>
<script src="{{ asset('public_assets/assets/js/jquery-ui-1.10.4.custom.min.js') }}"></script>
<script src="{{ asset('public_assets/bootstrap3/js/bootstrap.js') }}"></script>
<script src="{{ asset('public_assets/assets/js/gsdk-checkbox.js') }}"></script>
<script src="{{ asset('public_assets/assets/js/gsdk-radio.js') }}"></script>
<script src="{{ asset('public_assets/assets/js/gsdk-bootstrapswitch.js') }}"></script>
<script src="{{ asset('public_assets/assets/js/get-shit-done.js') }}"></script>