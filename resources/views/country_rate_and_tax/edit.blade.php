
@extends('layouts.app')
@section('content')

    <!-- BEGIN #tableHeadOptions -->
    <h3 class="header-title mb-3">Update Tax</h3>

    <div class="card">
        <div class="card-body pb-2">

            <x-validationErrors />
            <form action="{{ route('country_rate_and_tax.update', ['country_rate_and_tax' => $country_rate_and_tax->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">Slected Country</label>
                            <select onchange="myFunction()" class="form-select" name="country_name" id="country_name">
                                @if(count($countries) === 0)
                                    <option class="option-lg" value="">SELECT COUNTRY NAME</option>
                                @endif
                                @foreach ($countries as $country)
                                    <option class="option-lg" value="{{ $country->name->common }}" data-code="{{ $country['iso_a3'] }}"  {{ $country->name->common == $country_rate_and_tax->country_name ? 'selected' : '' }}>{{ $country->name->common }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">COUNTRY CODE</label>
                            <select class="form-select" name="country_code" id="country_code">
                                @if(count($countries) === 0)
                                    <option class="option-lg" value="">SELECT COUNTRY CODE</option>
                                @endif
                                @foreach ($countries as $country)
                                    <option class="option-lg" value="{{ $country['iso_a3'] }}" {{ $country['iso_a3'] == $country_rate_and_tax->country_code ? 'selected' : '' }}>{{ $country['iso_a3'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">Product Type</label>
                            <select class="form-select" name="product_type" id="product_type">
                                <option value="All" {{ $country_rate_and_tax->product_type == 'All' ? 'selected' : '' }}>All</option>
                                <option value="Gift Card" {{ $country_rate_and_tax->product_type == 'Gift Card' ? 'selected' : '' }}>Gift Card</option>
                                <option value="Topup" {{ $country_rate_and_tax->product_type == 'Topup' ? 'selected' : '' }}>Topup</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">Tax</label>
                            <input type="number" step="0.1" name="tax" value="{{ $country_rate_and_tax->tax }}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">Rate</label>
                            <input type="number" step="0.1" name="rate" value="{{ $country_rate_and_tax->rate }}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">Tax</label>
                             <textarea name="description" class="form-control">{{ $country_rate_and_tax->description }}</textarea>
                        </div>
                    </div>

                </div>
                <div class="mb-4 d-flex justify-content-between">
                    <a href="{{ route('country_rate_and_tax.index') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
                    <button type="submit" class="submtting_pack btn btn-success btn-lg">Update</button>
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
    <!-- END #tableHeadOptions -->
@endsection

<script>
    function myFunction() {
    var countryNameSelect = document.getElementById("country_name");
    var countryCodeSelect = document.getElementById("country_code");
    var selectedCountryName = countryNameSelect.value;
    var selectedCountryCode = countryNameSelect.options[countryNameSelect.selectedIndex].getAttribute("data-code");
    countryCodeSelect.value = selectedCountryCode;
    }
</script>