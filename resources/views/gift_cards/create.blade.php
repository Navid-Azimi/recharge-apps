@extends('layouts.app')
@section('content')
    <div class="card text-decoration-none p-4">
        <div class="align-items-center mb-3">
            <h1 class="page-header">Create New Gift Card</h1>
            <x-validationErrors />
            <form action="{{ route('giftcards.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group mb-3">
                            <label for="gift_type_id" class="form-label">Select Type</label>
                            <select class="form-select" name="gift_type_id" id="gift_type_id">
                                <option class="option-lg" value="">SELECT TYPE</option>
                                @foreach ($types as $type)
                                    <option class="option-lg" value="{{ $type->id }}"
                                        {{ old('gift_type_id') ? 'selected' : '' }}>
                                        {{ $type->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group mb-2">
                            <label for="value" class="form-label">Value</label>
                            <input type="text" name="value" value="{{ old('value') }}" id="value" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group mb-2">
                            <div class="form-group mb-2">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" name="price" id="price" value="{{ old('price') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4  col-12">
                        <div class="form-group mb-2">
                            <label for="discount" class="form-label">Discount</label>
                            <input type="number" class="form-control" value="{{ old('discount') }}" id="discount" name="discount">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group mb-2">
                            <label for="currency" class="form-label">Currency</label>
                            <select class="form-select" name="currency" id="currency">
                                <option class="option-lg" value="">SELECT CURRENCY</option>
                                @foreach ($allCountries as $currency)
                                    @if (isset($currency['currencies'][0]))
                                        <option class="option-lg" value="{{ $currency->currencies[0] }}"
                                            {{  old('currency') ? 'selected' : '' }}>
                                            {{ $currency['currencies'][0] }}
                                            -- {{ $currency->name->common }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group mb-2">
                            <label for="bar_code" class="form-label">Bar Code</label>
                            <input type="text" class="form-control" id="bar_code" value="{{ old('bar_code' )}}" name="bar_code">
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-between w-100">
                    <a href="{{ route('giftcards.index') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
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
@endsection
