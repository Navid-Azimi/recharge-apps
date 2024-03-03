@extends('layouts.app')
@section('content')
    <div class="card text-decoration-none p-4">
        <div class="align-items-center mb-3">
            <h2 class="page-header">Create New Gift Card Brand</h2>
            <x-validationErrors />
            <form action="{{ route('giftcardbrands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group mb-2">
                            <label for="brand_name" class="form-label">Brand Name</label>
                            <input type="text" name="brand_name" id="brand_name" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group mb-2">
                            <label for="brand_logo" class="form-label">Brand Logo</label>
                            <input type="file" name="brand_logo" id="brand_logo" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group mb-2">
                            <label for="brand_country" class="form-label">Brand Country</label>
                            <select class="form-select" name="brand_country" id="brand_country">
                                <option class="option-lg" value="">SELECT COUNTRY</option>
                                <option class="option-lg" value="Worldwide">Worldwide</option>
                                @foreach ($allCountries as $country)
                                    @if (isset($country->name->common))
                                        <option class="option-lg" value="{{ $country->name->common }}">
                                            {{ $country->name->common }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6  col-12">
                        <div class="form-group mb-2">
                            <label for="brand_description" class="form-label">Description</label>
                            <textarea class="form-control" name="brand_description" id="brand_description" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mt-4 form-group d-flex justify-content-between w-100">
                            <a href="{{ route('giftcardbrands.index') }}"
                                class="submtting_pack btn btn-danger btn-lg">Cancel</a>
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
@endsection
