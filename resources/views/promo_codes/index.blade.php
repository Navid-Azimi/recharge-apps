@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="d-flex align-items-center mb-1">
            <h1 class="page-header">All Promo Codes</h1>
            <div class="ms-auto">
                <a href="{{ route('promocodes.create') }}" class="submtting_pack btn btn-primary btn-sm form-control">
                    <i class="fa fa-plus-circle fa-fw me-1"></i>Add New Promo Code</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <x-messages />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-1">
                <div class="card-body pb-0">
                    <form id="filter" class="m-0" action="{{ route('promocodes.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <input type="text" class="form-control" placeholder="Promo Code..." name="promo_code"
                                        value="{{ Request::get('promo_code') ? Request::get('promo_code') : '' }}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <input type="number" class="form-control" placeholder="Min..." name="min_amount"
                                        id="min_amount"
                                        value="{{ Request::get('min_amount') ? Request::get('min_amount') : '' }}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <input type="number" class="form-control" placeholder="Max..." name="max_amount"
                                        id="max_amount"
                                        value="{{ Request::get('max_amount') ? Request::get('max_amount') : '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <input type="number" class="form-control" placeholder="Discount..." name="discount"
                                        id="discount"
                                        value="{{ Request::get('discount') ? Request::get('discount') : '' }}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <span class="input-group-text border-end-0 bg-transparent p-2" id="startIcon">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="text" placeholder="Start Date"
                                        value="{{ Request::get('start_date') }}" name="start_date" id="startDate"
                                        class="form-control text-white border-start-0" data-toggle="flatpickr">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-transparent border-end-0 p-2" id="endIcon">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="text" placeholder="End Date"
                                        value="{{ Request::get('end_date') }}" name="end_date" id="endDate"
                                        class="form-control text-white border-start-0 " data-toggle="flatpickr">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ps-2 mb-2">
                                    <button type="submit" value="Search" class="form-control btn-lg  btn btn-success"><i
                                            class="bi bi-search me-3"></i>Search</button>
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
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">
                            <tr style="text-align: center;">
                                <th style="vertical-align: middle;" rowspan="2">No</th>
                                <th colspan="4">Promo Code</th>
                                <th style="vertical-align: middle" rowspan="2">Start Date</th>
                                <th style="vertical-align: middle" rowspan="2">End Date</th>
                                <th style="vertical-align: middle;" rowspan="2" width="280px">Actions</th>
                            </tr>
                            <tr class="text-center">
                                <th>Code</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>ِDiscount(%)</th>
                            </tr>
                            @if ($promoCodes->count() > 0)
                                @foreach ($promoCodes as $promoCode)
                                    <tr class="text-center">
                                        <td>{{ ($promoCodes->currentPage() - 1) * $promoCodes->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{ $promoCode->promo_code }}</td>
                                        <td>{{ $promoCode->min_amount ? $promoCode->min_amount : '0' }}</td>
                                        <td>{{ $promoCode->max_amount ? $promoCode->max_amount : '0' }}</td>
                                        <td>{{ $promoCode->discount ? $promoCode->discount . '%' : '0%' }}</td>
                                        <td>{{ $promoCode->start_date ? $promoCode->start_date : '' }}</td>
                                        <td>{{ $promoCode->end_date ? $promoCode->end_date : '' }}</td>
                                        <td class="d-flex gap-1 justify-content-center">
                                            <a class="submtting_pack btn btn-primary btn-sm"
                                                href="{{ route('promocodes.edit', $promoCode->id) }}">Edit</a>
                                            <form class="m-0"
                                                action="{{ route('promocodes.destroy', $promoCode->id) }}"method="POST"
                                                id="promoCode-delete-form-{{ $promoCode->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm delete-promoCode"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                    data-promoCode-id="{{ $promoCode->id }}">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12">No records yet! </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div> {{-- card body ended --}}
                <div class="card-arrow">
                    <div class="card-arrow-top-left"></div>
                    <div class="card-arrow-top-right"></div>
                    <div class="card-arrow-bottom-left"></div>
                    <div class="card-arrow-bottom-right"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN #modal -->
    <div id="exampleModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title">Delete Promo Code</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal-body">
                            <div class="panel">
                                <div class="panel-body text-center py-2">
                                    <h3> Are you sure you want to delete this promo code?</h3>
                                </div>
                                <div class="form-group mybody mt-2 d-flex justify-content-between mb-3">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END #modal -->
    <br>
    {!! $promoCodes->links() !!}
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // promoCode Deletion
        deleteWithModalConfirmation('delete-promoCode', '#exampleModal', 'promoCode_deletor',
            'promoCode-delete-form-', 'promoCode');
        
        flatPickerDate('startDate', 'startIcon');
        flatPickerDate('endDate', 'endIcon');

        // Promo Code Alert
        let promoCodes = @json($promoCodes);
        let promoCodesArray = promoCodes?.data || [];
        promoCodesArray.forEach(function (promoCode) {
            let endDate = new Date(promoCode.end_date);
            let currentDate = new Date();
            let remainingDays = Math.floor((endDate - currentDate) / (24 * 60 * 60 * 1000));
            if (remainingDays <= 5 && remainingDays > 0) {
                alert('Promo code ' + promoCode.promo_code + ' has only ' + remainingDays + ' days remaining.');
            }
        });
    });
</script>
