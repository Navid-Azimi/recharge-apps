@extends('layouts.app')
@section('content')
    <div id="tableHeadOptions" class="mb-5">
        <div class="d-flex align-items-center mb-3">
            <h1 class="page-header">Add New Package</h1>
        </div>
        <div class="card">
            <div class="card-body pb-2">
                <x-validationErrors />
                <form action="{{ route('packages.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label for="pck_country" class="form-label">Package Country</label>
                                <select class="form-select" name="pck_country" id="pck_country">
                                    <option class="option-lg" value="">SELECT COUNTRY</option>
                                    <option class="option-lg" value="">All</option>
                                    @foreach ($allCountries as $country)
                                     @if (isset($country->name->common))
                                            <option   class="option-lg" value="{{ $country->name->common }}" data-iso="{{ $country['iso_a3'] }}">
                                                {{ $country->name->common }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Packages</label>
                                <select class="form-select" id="pck_type" name="pck_type">
                                    @if (!isset($packages))
                                        <option class="option-lg" value="">SELECT PACKAGE</option>
                                    @endif
                                    <option class="option-lg" value="">All</option>
                                    <option class="option-lg" value="Voice">Voice</option>
                                    <option class="option-lg" value="SMS">SMS</option>
                                    <option class="option-lg" value="Data">Data</option>
                                    <option class="option-lg" value="Credit">Credit</option>
                                    <option class="option-lg" value="Mixed">Mixed</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Currency</label>
                                <select class="form-select" name="pck_currency_id" id="pck_currency_id">
                                    @if (!isset($packages))
                                        <option class="option-lg" value="">SELECT CURRENCY</option>
                                    @endif
                                    @foreach ($allCountries as $currency)
                                        @if (isset($currency['currencies'][0]))
                                            <option class="option-lg" value="{{ $currency->currencies[0] }}" id="current_option"
                                                data-country="{{ $currency->name->common }}">
                                                {{ $currency['currencies'][0] }}
                                                -- {{ $currency->name->common }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Network Packages</label>
                                <select class="form-select" name="pck_ntw_id" id="pck_ntw_id">
                                    @if (!isset($pachages))
                                        <option class="option-lg" value="">SELECT OPERATOR</option>
                                        <option class="option-lg" value="">All</option>
                                        @foreach ($networks as $network)
                                            <option class="option-lg" value="{{ $network->id }}">{{ $network->ntw_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label for="pck_user_role" class="form-label">User Role</label>
                                <div class="typeahead__query input-group">
                                    <!-- <span class="input-group-text bg-transparent"><i class="fa fa-laptop"></i></span> -->
                                    <select class="form-select" id="pck_user_role" name="pck_user_role">
                                        <option class="option-lg" value="">SELECT ROLE</option>
                                        <option class="option-lg" value="">ALL ROLE</option>
                                        <option class="option-lg" value="admin">ADMIN</option>
                                        <option class="option-lg" value="reseller">RESELLER</option>
                                        <option class="option-lg" value="customer">CUSTOMER</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label for="pck_user_id" class="form-label">User</label>
                                <select class="form-select" name="pck_user_id" id="pck_user_id">
                                    <option class="option-lg" value="">SELECT USER</option>
                                    <option class="option-lg" value="">ALL</option>
                                    @foreach ($users as $user)
                                        <option class="option-lg" value="{{ $user->name }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="general_comm" class="form-label">Package Commission</label>
                                <input type="number" name="general_comm" id="general_comm" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3" id="pck_data_amount">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Package Data Amount</label>
                                <input type="text" name="pck_data_amount" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3" id="pck_price">
                                <label for="validationInvalidInputGroup" class="form-label">Package Price</label>
                                <input type="number" name="pck_price" class="form-control">
                            </div>
                        </div> 
                        
                        <div class="col-md-3" id="interior_charges">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Interior Fee</label>
                                <input type="text" name="interior_charges" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-3" id="outdoor_charges">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Outdoor Fee</label>
                                <input type="text" name="outdoor_charges" class="form-control">
                            </div>
                        </div> 

                        <div class="col-md-3" id="pck_minutes_amount">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Package Minutes Amount</label>
                                <input type="text" name="pck_minutes_amount" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3" id="pck_sms_amount">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Package SMS Amount</label>
                                <input type="text" name="pck_sms_amount" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3" id="pck_credit_amount">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Package Credit Amount</label>
                                <input type="number" name="pck_credit_amount" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3" id="pck_memo">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Description</label>
                                <textarea name="pck_memo" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mt-2 d-flex justify-content-between mb-3">
                                <a href="{{ route('packages.index') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
                                <button type="submit" class="submtting_pack btn btn-success btn-lg">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-arrow">
                <div class="card-arrow-top-left"></div>
                <div class="card-arrow-top-right"></div>
                <div class="card-arrow-bottom-left"></div>
                <div class="card-arrow-bottom-right"></div>
            </div>
        </div>
    </div>
    <!-- END #tableHeadOptions -->
@endsection

<!-- jQuery code -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        $('#pck_type').on('change', function() {
            switch ($(this).val()) {
                case 'Voice':
                    $('#pck_sms_amount, #pck_credit_amount, #pck_data_amount').hide();
                    break;

                case 'Data':
                    $('#pck_sms_amount, #pck_credit_amount, #pck_minutes_amount').hide();
                    $('#pck_data_amount').show();
                    break;

                case 'SMS':
                    $('#pck_data_amount, #pck_minutes_amount, #pck_credit_amount').hide();
                    $('#pck_sms_amount').show();
                    break;

                case 'Credit':
                    $('#pck_data_amount, #pck_minutes_amount, #pck_sms_amount, #pck_credit_amount')
                        .hide();
                    $('#pck_credit_amount').show();
                    break;

                case 'Mexed':
                default:
                    $('#pck_data_amount, #pck_minutes_amount, #pck_sms_amount, #pck_credit_amount')
                        .show();
                    break;
            }
        });

        $('#pck_type').trigger('change');
    });

    // Fetching Users
    document.addEventListener('DOMContentLoaded', function() {
        const userRole = document.getElementById('pck_user_role');
        const usersList = document.getElementById('pck_user_id');
        const countriesDropdown = document.getElementById('pck_country');
        const networksList = document.getElementById('pck_ntw_id');

        fetchUsersForPackages(userRole, usersList);
        // Fetching Operators of selected Country
        getNetworksForSelectedCountry(countriesDropdown, networksList);
    });
</script>

