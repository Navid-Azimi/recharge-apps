@extends('layouts.app')
@section('content')
    <div class="card text-decoration-none p-4">
        <div class="align-items-center mb-3">
            <h1 class="page-header">Create New Gift Card Type</h1>
            <x-validationErrors />
            <form action="{{ route('giftcardtypes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group mb-2">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group mb-2">
                            <div class="form-group mb-2">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group mb-3">
                            <label for="brand_id" class="form-label">Select Brand</label>
                            <select class="form-select" name="brand_id" id="brand_id">
                                <option class="option-lg" value="">SELECT BRAND</option>
                                @foreach ($brands as $brand)
                                    <option class="option-lg" value="{{ $brand->id }}"
                                        {{ old('brand_id') ? 'selected' : '' }}>
                                        {{ $brand->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group mb-2">
                            <label for="terms" class="form-label">Terms</label>
                            <textarea class="form-control" id="terms" name="terms" rows="3">{{ old('terms') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-between w-100">
                    <a href="{{ route('giftcardtypes.index') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
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
