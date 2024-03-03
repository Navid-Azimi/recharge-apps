@extends('layouts.app')
@section('content')

    <div id="tableHeadOptions" class="mb-5">
        <div class="d-flex align-items-center mb-2">
            <h1 class="page-header">Add New Tax</h1>
        </div>
        <div class="card">
            <div class="card-body pb-2">
                
                <x-validationErrors />
                <form action="{{ route('country_rate_and_tax.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Country Name</label>
                                <select onchange="myFunction()" class="form-select" name="country_name" id="country_name">
                                    @if(!isset($country_rate))
                                        <option class="option-lg" value="">SELECT COUNTRY NAME</option>
                                    @endif
                                    @foreach ($countries as $country)
                                        <option class="option-lg" value="{{ $country->name->common }}" data-code="{{ $country['iso_a3'] }}">{{ $country->name->common }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Country Code</label>
                                <select class="form-select" name="country_code" id="country_code">
                                    @if(!isset($country_rate))
                                        <option class="option-lg" value="">SELECT COUNTRY CODE</option>
                                    @endif
                                    @foreach ($countries as $country)
                                        <option class="option-lg" value="{{ $country['iso_a3'] }}">{{ $country['iso_a3'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Product Type</label>
                                <select class="form-select" name="product_type" id="product_type">
                                    <option value="">Select Product Type</option>
                                    <option value="All">All</option>
                                    <option value="Gift Card">Gift Card</option>
                                    <option value="Topup">Topup</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Tax</label>
                                <input type="number" step="0.1" name="tax" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Rate</label>
                                <input type="number" step="0.1" name="rate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Description</label>
                                 <textarea name="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-between">
                        <a href="{{ route('country_rate_and_tax.index') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
                        <button type="submit" class="submtting_pack btn btn-success btn-lg">Submit</button>
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
@endsection

<!-- The codes usage: selecting country name, country code set automaticlly   -->
<script>
    function myFunction() {
    var countryNameSelect = document.getElementById("country_name");
    var countryCodeSelect = document.getElementById("country_code");
    var selectedCountryName = countryNameSelect.value;
    var selectedCountryCode = countryNameSelect.options[countryNameSelect.selectedIndex].getAttribute("data-code");
    countryCodeSelect.value = selectedCountryCode; // Sets the country code as the selected value
    }
</script>
