<div class="table-responsive">
    <table class="table  table-bordered" style="text-align: center;">
        <tr style="text-align: center;">
            <th>No</th>
            <th>Confirmation</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Currency</th>
            <th>Created At</th>
        </tr>

        @if ($payments->count() > 0)
            @foreach ($payments as $payment)
                <tr style="text-align:center;">
                    <td>{{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->iteration }}</td>
                    <td>{{ $payment->payment_info_id }}</td>
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
    <div class="download">
        <a href="{{ route('payments_export') }}" class="btn btn-success d-inline-block mb-4">Download Report <i
                class="fa fa-download"></i></a>
    </div>
</div>
