@extends('layouts.app')
@section('content')
    <div id="basicUsage" class="mb-5">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-xl-12">
                <div id="bootstrapTable" class="mb-5">
                    <h5 class="flex-grow-1 d-inline-block mb-3">Gift Cards Reports</h5>
                    <div class="card" style="z-index: 1;">
                        <div class="card-body">
                            <form id="filter" class="mb-0" action="{{ route('giftcards_reports') }}" method="GET">
                                <div class="row">
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
                                    <!-- Add the "Sent" option -->
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
                                    <div class="col-md-4">
                                        <div class="input-group mb-3">
                                            <input type="text" placeholder="Recipient Email"
                                                value="{{ Request::get('email') }}" name="email" id="email"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group mb-3">
                                            <input type="number" placeholder="Transaction ID"
                                                value="{{ Request::get('trans_id') }}" min="0" name="trans_id"
                                                id="trans_id" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3" id="types_input">
                                            <select id="status" name="status" class="form-select">
                                                <option class="text-white bg-black option-lg" value="">Select Status
                                                </option>
                                                <option class="text-white bg-black option-lg" value="1"
                                                    {{ Request::get('status') == '1' ? 'selected' : '' }}>
                                                    Successful</option>
                                                <option class="text-white bg-black option-lg" value="0"
                                                    {{ Request::get('status') == '0' ? 'selected' : '' }}>Failed
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group ps-2 mt-1 mb-3">
                                            <button type="submit" value="Search"
                                                class="form-control  btn btn-success p-1"><i
                                                    class="bi bi-search me-3"></i>Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hovered">
                                        <thead>
                                            <tr class="text-center">
                                                <th class="col text-white">#
                                                </th>
                                                <th class="col text-white">
                                                    Trans</th>
                                                <th class="col text-white">
                                                    Product</th>
                                                <th class="col text-white">
                                                    Currency</th>
                                                <th class="col text-white">
                                                    Country</th>
                                                <th class="col text-white">
                                                    Date</th>
                                                <th class="col text-white">
                                                    Price</th>
                                                <th class="col text-white">
                                                    Discount</th>
                                                <th class="col text-white">
                                                    Total</th>
                                                <th class="col text-white">
                                                    Commission</th>
                                                <th class="col text-white">
                                                    Recipient</th>
                                                <th class="col text-white">Recipient Phone</th>
                                                <th class="col text-white">
                                                    Status</th>
                                                <th class="col text-white">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 0.875rem;">
                                            @php
                                                $profit_total = 0;
                                            @endphp
                                            @if (count($transactions) > 0)
                                                @foreach ($transactions as $item)
                                                    <tr class="text-center">
                                                        <td>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}
                                                        <td>{{ $item->id }}</td>
                                                        <td>{{ $item->product }}</td>
                                                        <td>{{ $item->currency }}</td>
                                                        <td>{{ $item->country }}</td>
                                                        <td>{{ $item->created_at ? $item->created_at->format('d-m-Y') : '' }}
                                                        </td>
                                                        <td>{{ $item->price }}</td>
                                                        <td>{{ $item->discount }}</td>
                                                        <td>{{ $item->price - $item->discount + $item->commission }}</td>
                                                        <td>{{ $item->commission }}</td>
                                                        <td>{{ $item->recipient_email }}</td>
                                                        <td>{{ $item->recipient_phone }}</td>
                                                        <td class="{{ $item->status ? 'text-success' : 'text-danger' }}">
                                                            {{ $item->status ? 'Success' : 'Failed' }}
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-light">Download</button>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $profit_total += (float) $item->commission;
                                                    @endphp
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="12">No transaction yet! </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="profits_and_sales mt-4" style="float: right;">
                                <ul class="mainlist_styleship" style="list-style: none;">
                                    <li>
                                        @php
                                            $myTotalSale = 0;
                                        @endphp

                                        @foreach ($transactions as $item)
                                            @php
                                                $myTotalSale += $item->price - $item->discount + $item->commission;
                                            @endphp
                                        @endforeach
                                        <span class="text-theme fw-bold">Sales Total: {{ $myTotalSale }}</span>
                                    </li>
                                    <li>
                                        <span>My Profit Total: {{ $profit_total }}</span>
                                    </li>
                                    <li>
                                        <span>Transaction Count: {{ count($transactions) }}</span>
                                    </li>
                                </ul>
                            </div>
                            {!! $transactions->links() !!}
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
            <!-- END col-6 -->
        </div>
        <!-- END row -->
    </div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatPickerDate('startDate', 'startIcon');
        flatPickerDate('endDate', 'endIcon');
    });
</script>
