@extends('layouts.app')
@section('content')
    <!-- BEGIN #tableHeadOptions -->
    <div id="tableHeadOptions" class="mb-5">
        <div class="d-flex align-items-center mb-2">
            <h2 class="page-header">Update Promo Code</h2>
        </div>
        <div class="card">
            <div class="card-body pb-2">
                <x-validationErrors />
                <form action="{{ route('promocodes.update', $promoCode->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" name="promo_code" value="{{ $promoCode->promo_code }}" class="form-control"
                                    id="code">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="min_amount" class="form-label">Min</label>
                                <input type="number" name="min_amount" value="{{ $promoCode->min_amount }}" id="min_amount"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="max_amount" class="form-label">Max</label>
                                <input type="number" name="max_amount" value="{{ $promoCode->max_amount }}" id="max_amount"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="discount" class="form-label">Discount (%)</label>
                                <input type="number" name="discount" value="{{ $promoCode->discount }}" id="discount"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <span class="form-group-text border-end-0 bg-transparent" id="startIcon">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                <label for="end_date" class="form-label">Start Date</label>
                                <input type="text" name="start_date" value="{{ $promoCode->start_date }}" id="startDate"
                                data-toggle="flatpickr" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <span class="form-group-text border-end-0 bg-transparent" id="endIcon">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="text" name="end_date" value="{{ $promoCode->end_date }}" id="endDate"
                                data-toggle="flatpickr" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3 d-flex w-100 justify-content-between">
                                <a href="{{ route('promocodes.index') }}"
                                    class="submtting_pack btn btn-danger btn-lg">Cancel</a>
                                <button type="submit" class="submtting_pack btn btn-success btn-lg">Update</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatPickerDate('startDate', 'startIcon');
        flatPickerDate('endDate', 'endIcon');
    });
</script>