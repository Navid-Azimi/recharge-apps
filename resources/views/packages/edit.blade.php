@extends('layouts.app')
@section('content')
    <!-- BEGIN #tableHeadOptions -->
    <div id="tableHeadOptions" class="mb-5">
        <div class="d-flex align-items-center mb-2">
            <h2 class="page-header">Update Package</h2>
        </div>
        <div class="card">
            <div class="card-body pb-2">
            <x-validationErrors />
                <form action="{{ route('packages.update', $package->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label for="pck_country" class="form-label">Package Country</label>
                                <select class="form-select" name="pck_country" id="pck_country">
                                    <option class="option-lg" value="">SELECT COUNTRY</option>
                                    <option class="option-lg" value="" {{ $package->pck_country == '' ? 'selected' : '' }}>All</option>
                                    @foreach ($allCountries as $country)
                                        @if (isset($country->name->common))
                                            <option class="option-lg" value="{{ $country->name->common }}"
                                                {{ $country->name->common == $package->pck_country ? 'selected' : '' }} data-iso="{{ $country['iso_a3'] }}">
                                                {{ ucfirst(strtolower($country->name->common)) }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Selected Package</label>
                                <select class="form-select form-select-lg" id="pck_type" name="pck_type" required>
                                    @if (!isset($packages))
                                        <option class="option-lg" value="">SELECT PACKAGE</option>
                                    @endif
                                    <option class="option-lg" value="" {{ $package->pck_type == '' ? 'selected' : '' }}>All</option>
                                    @foreach (['Voice', 'SMS', 'Data', 'Credit', 'Mixed'] as $pck_type)
                                        <option class="option-lg" value="{{ $pck_type }}"
                                            {{ $pck_type == $package->pck_type ? 'selected' : '' }}>
                                            {{ ucfirst(strtolower($pck_type)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Selected Currency</label>
                                <select class="form-select" name="pck_currency_id">
                                    @foreach ($allCountries as $currency)
                                        @if (isset($currency['currencies'][0]))
                                            <option class="option-lg" value="{{ $currency->currencies[0] }}"
                                                {{ $package->pck_currency_id == $currency->currencies[0] ? 'selected' : '' }}>
                                                {{ $currency['currencies'][0] }} -- {{ $currency->name->common }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="pck_ntw_id" class="form-label">Selected Operator</label>
                                <select class="form-select" name="pck_ntw_id" id="pck_ntw_id">
                                    <option class="option-lg" value="" {{ $package->pck_ntw_id == '' ? 'selected' : '' }}>All</option>
                                    @foreach ($networks as $network)
                                        <option class="option-lg" value="{{ $network->id }}"
                                            {{ $network->id == $package->pck_ntw_id ? 'selected' : '' }}>
                                            {{ $network->ntw_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label for="pck_edit_user_role" class="form-label">User Role</label>
                                <div class="typeahead__query input-group">
                                    <span class="input-group-text bg-transparent"><i class="fa fa-laptop"></i></span>
                                    <select class="form-select" id="pck_edit_user_role" name="pck_user_role">
                                        <option class="option-lg" value="">SELECT ROLE</option>
                                        <option class="option-lg" value="">ALL ROLE</option>
                                        <option class="option-lg" value="admin">ADMIN</option>
                                        <option class="option-lg" value="reseller">RESELLER</option>
                                        <option class="option-lg" value="customer">CUSTOMER</option>
                                        <option class="option-lg" value="" {{ $package->pck_user_role == '' ? 'selected' : '' }}>All
                                        </option>
                                        @foreach (['admin', 'reseller', 'customer'] as $pck_user_role)
                                            <option class="option-lg" value="{{ $pck_user_role }}"
                                                {{ $pck_user_role == $package->pck_user_role ? 'selected' : '' }}>
                                                {{ ucfirst(strtolower($pck_user_role)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label for="pck_edit_user_id" class="form-label">User</label>
                                <select class="form-select" name="pck_user_id" id="pck_edit_user_id">
                                    <option class="option-lg" value="">SELECT USER</option>
                                    <option class="option-lg" value="" {{ $package->pck_user_id == '' ? 'selected' : '' }}>All</option>
                                    @foreach ($users as $user)
                                        <option class="option-lg" value="{{ $user->id }}"
                                            {{ $user->id == $package->pck_user_id ? 'selected' : '' }}>{{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3" id="pck_exp_date">
                                <label for="general_comm" class="form-label">Package Commission</label>
                                <input type="number" name="general_comm" id="general_comm"
                                    value="{{ $package->general_comm }}" class="form-control" required>
                            </div>
                        </div>
                         
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Package Credit Amount</label>
                                <input type="number" name="pck_credit_amount" value="{{ $package->pck_credit_amount }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Package Data Amount</label>
                                <input type="text" name="pck_data_amount" value="{{ $package->pck_data_amount }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Package Minutes Amount</label>
                                <input type="text" name="pck_minutes_amount"
                                    value="{{ $package->pck_minutes_amount }}" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Package SMS Amount</label>
                                <input type="text" name="pck_sms_amount" value="{{ $package->pck_sms_amount }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3" id="package_price">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Package Price</label>
                                <input type="text" name="pck_price" value="{{ $package->pck_price }}" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3" id="interior_charges">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Interior Charges</label>
                                <input type="text" name="interior_charges" class="form-control" value="{{ $package->interior_charges }}">
                            </div>
                        </div>

                        <div class="col-md-3" id="outdoor_charges">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Outdoor Charges</label>
                                <input type="text" name="outdoor_charges" class="form-control" value="{{ $package->outdoor_charges }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Package Memo</label>
                                <textarea name="pck_memo" class="form-control">{{ $package->pck_memo }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3 d-flex w-100 justify-content-between">
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
        const userRole = document.getElementById('pck_edit_user_role');
        const usersList = document.getElementById('pck_edit_user_id');
        const countriesDropdown = document.getElementById('pck_country');
        const networksList = document.getElementById('pck_ntw_id');
        fetchUsersForPackages(userRole, usersList);

        flatPickerDate('pck_edit_exp_date', 'dateIcon', 'today');
        // Fetching Operators of selected Country
        getNetworksForSelectedCountry(countriesDropdown, networksList);
    });
</script>
