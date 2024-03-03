@extends('layouts.app')
@section('content')
    <!-- BEGIN #tableHeadOptions -->
    <div id="tableHeadOptions" class="mb-5">
        <div class="d-flex align-items-center mb-2">
            <h1 class="page-header">Add New Promo Code</h1>
        </div>
        <div class="card">
            <div class="card-body pb-2">
                <x-validationErrors />
                <form action="{{ route('promocodes.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" value="{{ old('promo_code') }}" name="promo_code" class="form-control" id="code">
                                @error('promo_code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="min_amount" class="form-label">Min</label>
                                <input type="number" name="min_amount" value="{{ old('min_amount') }}" id="min_amount" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="max_amount" class="form-label">Max</label>
                                <input type="number" name="max_amount" value="{{ old('max_amount') }}" id="max_amount" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="discount" class="form-label">Discount (%)</label>
                                <input type="number" name="discount" value="{{ old('discount') }}" id="discount" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <span class="form-group-text border-end-0 bg-transparent" id="startIcon">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                <label for="end_date" class="form-label">Start Date</label>
                                <input type="text" value="{{ old('start_date') }}" name="start_date" id="startDate"
                                    class="form-control text-white border-start-0" data-toggle="flatpickr">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <span class="form-group-text border-end-0 bg-transparent" id="endIcon">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="text" name="end_date" value="{{ old('end_date') }}" id="endDate" 
                                class="form-control" data-toggle="flatpickr">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3 d-flex justify-content-between w-100">
                                <a href="{{ route('promocodes.index') }}"
                                    class="btn btn-danger btn-lg submtting_pack">Cancel</a>
                                <button type="submit" class="btn btn-success btn-lg submtting_pack">Submit</button>
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
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatPickerDate('startDate', 'startIcon');
        flatPickerDate('endDate', 'endIcon');
    });
</script>