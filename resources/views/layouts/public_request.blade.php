@include('layouts.dashboards.public_head')
@include('layouts.dashboards.nav') 
@inject('packages', 'App\Models\Package')
    <div class="container-fluite public_page_containers">
        <div class="space"></div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 summary_main_content"> 
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="summary_title">You’re sending top-up to</h4>
                        </div>
                        <div class="col-sm-12">
                            <div class="summary_left_cont">
                                <h4>{{ session('phoneNumber') }} </h4>
                                <h4><i class="fa fa-pencil"></i></h4>
                            </div>
                        </div>
                    </div>
                </div> 
                <hr>
                <div class="col-sm-12">
                    <h4 class="summary_title">Select amount to continue</h4>
                    <div class="row">
                        @foreach ($packages->all() as $package)
                        <div class="col-sm-6">
                            <!-- requesting credit amount section -->
                            <section class="mx-auto my-4">
                                <a  href="{{ route('summary', ['id' => $package->id]) }}">
                                    <div class="card-body rounded-top pink darken-4">
                                        <h3>{{ @$package->pck_credit_amount }} 
                                            <small>Creadit Amount</small>
                                        </h3>
                                        <p>incl. fees</p>
                                    </div>
                                    <div class="special_part">
                                        <div class="card-body">
                                            <div class="my_content">
                                                <p class="carts_content">
                                                    <small>They get</small><br>
                                                    <b class="package_price">{{ @$package->pck_price }}</b> <small>{{ @$package->pck_currency_id }}</small><br>
                                                    <small>before AIT</small><br>
                                                </p>
                                                <a href="{{ route('summary', ['id' => $package->id]) }}" 
                                                    class="btn btn-primary btn-md btn-rounded btn-fill" 
                                                    style="border-radius: 24px; background: #caf100; border-color: #caf100; color: #004a59;">
                                                    <b>Select</b>
                                                </a>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </a>
                            </section>

                            <!-- requesting credit amount section -->
                        </div>
                        @endforeach
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
        