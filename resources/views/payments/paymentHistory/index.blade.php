@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="d-flex flex-column justify-content-center mb-1">
            <h3 class="page-header mb-2">Payment History</h3>
            <p class="mt-0">List of all the payment made by the resellers until now.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <x-messages />
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h3 class="mb-3">Search</h3>
            <form action="{{ route('reseller_list') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group mb-2">
                            <span class="input-group-text border-end-0 bg-transparent p-2" id="startIcon">
                                <i class="fas fa-calendar"></i>
                            </span>
                            <input type="text" placeholder="Start Date" value="{{ Request::get('start_date') }}"
                                name="start_date" id="startDate" class="form-control text-white border-start-0"
                                data-toggle="flatpickr">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-2">
                            <span class="input-group-text border-end-0 bg-transparent p-2" id="endIcon">
                                <i class="fas fa-calendar"></i>
                            </span>
                            <input type="text" placeholder="End Date" value="{{ Request::get('end_date') }}"
                                name="end_date" id="endDate" class="form-control text-white border-start-0 "
                                data-toggle="flatpickr">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <select class="form-select" name="currency" id="currency">
                                <option class="option-lg" value="">Select Currency</option>
                                @foreach ($countries as $currency)
                                    @if (isset($currency['currencies'][0]))
                                        <option class="option-lg" value="{{ $currency->currencies[0] }}"
                                            {{ Request::get('currency') === $currency->currencies[0] ? 'selected' : '' }}>
                                            {{ $currency['currencies'][0] }} -- {{ $currency->name->common }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group px-2">
                            <button type="submit" value="Search" class="form-control  btn btn-success p-1"><i
                                    class="bi bi-search me-3"></i>Search</button>
                        </div>
                    </div>
                </div>
            </form>
            @include('payments.paymentHistory.table', $payments)
            {!! $payments->links() !!}
        </div>
        <div class="card-arrow">
            <div class="card-arrow-top-left"></div>
            <div class="card-arrow-top-right"></div>
            <div class="card-arrow-bottom-left"></div>
            <div class="card-arrow-bottom-right"></div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatPickerDate('startDate', 'startIcon');
        flatPickerDate('endDate', 'endIcon');
    });
</script>
