@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="d-flex align-items-center mb-2">
            <h1 class="page-header">List of all payments</h1>
        </div>
    </div>

    <x-validationErrors />

    <table class="table table-bordered">
        <tr style="text-align: center;">
            <th style="vertical-align: middle;" rowspan="2">No</th>
            <th colspan="4">Payments</th>
        </tr>
        <tr class="text-center">
            <th>Type</th>
            <th>Amount</th>
            <th>Currency</th>
            <th>Created At</th>
        </tr>

        @if ($payments->count() > 0)
            @foreach ($payments as $payment)
                <tr class="text-center">
                    <td>{{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->iteration }}</td>
                    <td>{{ $payment->payment_method_types }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->currency }}</td>
                    <td>{{ $payment->created_at }}</td>

                </tr>
            @endforeach
        @else
            <tr>
                <td>No Payment Yet!</td>
            </tr>
        @endif
    </table>

    {!! $payments->links() !!}
@endsection
