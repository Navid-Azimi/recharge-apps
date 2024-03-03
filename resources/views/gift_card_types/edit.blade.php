@extends('layouts.app')
@section('content')
    <div class="card text-decoration-none p-4">
        <div class="align-items-center mb-3">
            <h1 class="page-header">Edit Gift Card Type</h1>
            <x-validationErrors />
            <form action="{{ route('giftcardtypes.update', $type->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group mb-2">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ $type->title }}">
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
                                <option class="option-lg" value="">SELECT Brand</option>
                                @foreach ($brands as $brand)
                                    <option class="option-lg" value="{{ $brand->id }}"
                                        {{ $brand->brand_name == $type->cardBrand->brand_name ? 'selected' : '' }}>
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
                            <textarea class="form-control" id="terms" name="terms" rows="3">{{ $type->terms }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $type->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-between w-100">
                    <a href="{{ route('giftcardtypes.index') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
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
@endsection
