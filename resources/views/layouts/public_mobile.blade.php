
    <div class="col-md-7 col-md" style="background-color: white; padding-top: 13%; padding-bottom: 2.7%;">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="tim-title">
                    <a href="http://127.0.0.1:8000/" class="backTo">
                        <i class="fa fa-arrow-left"></i> Back 
                    </a>
                </div>
                <div class="tim-title">
                    <h3> <b>What’s your number?</b> </h3>
                    <p>We’ll text you a code to verify your number</p>
                </div>
                <form action="{{ route('login_with_phone') }}" method="POST">
                    @csrf
                    <div class="tim-title public_package_sending_cart">
                        <input type="tel" id="phone" class="form-control public_page_phone_Numner" name="phone" maxlength="9" minlength="9" placeholder="Enter Phone Number" required />
                        <input type="hidden" name="type" value="customer" />
                    </div>
                
                    <div class="tim-title">
                        <button class="table btn btn-block btn-md btn-fill btn-round sc-jqUVSM iHBits sc-iqcoie hTMjCv">Confirm phone number</button>
                    </div>
                </form>
            </div>

            <div class="col-md-2"></div>
        </div>
    </div>