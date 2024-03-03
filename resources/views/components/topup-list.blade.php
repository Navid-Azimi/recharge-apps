@props(['route', 'topups', 'operators', 'countries', 'resellers' => null])

<div class="card" style="z-index: 1;">
    <div class="card-body">
        <form id="filter" class="mb-0" action="{{ route($route) }}" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <select id="countries" name="country_name" class="form-select">
                            <option class="option-lg" value="">Select Country</option>
                            <option class="option-lg" value="all"
                                {{ Request::get('country_name') == 'all' ? 'selected' : '' }}>All
                            </option>
                            @foreach ($countries as $country)
                                @if (isset($country->name->common))
                                    <option class="option-lg" value="{{ $country->name->common }}"
                                        {{ Request::get('country_name') === $country->name->common ? 'selected' : '' }}>
                                        {{ $country->name->common }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <select class="form-select" name="currency" id="currency">
                            @if (!isset($packages))
                                <option class="option-lg" value="">Select Currency</option>
                            @endif
                            @foreach ($countries as $currency)
                                @if (isset($currency['currencies'][0]))
                                    <option class="option-lg" value="{{ $currency->currencies[0] }}" id="current_option"
                                        data-country="{{ $currency->name->common }}" {{ Request::get('currency') === $currency->currencies[0] ? 'selected' : '' }}>
                                        {{ $currency['currencies'][0] }}
                                        -- {{ $currency->name->common }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text border-end-0 bg-transparent p-2" id="startIcon">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <input type="text" placeholder="Start Date" value="{{ Request::get('start_date') }}"
                            name="start_date" id="startDate" class="form-control text-white border-start-0"
                            data-toggle="flatpickr">
                    </div>
                </div>
                <!-- Add the "Sent" option -->
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-end-0 p-2" id="endIcon">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <input type="text" placeholder="End Date" value="{{ Request::get('end_date') }}"
                            name="end_date" id="endDate" class="form-control text-white border-start-0 "
                            data-toggle="flatpickr">
                    </div>
                </div>
            </div>
            <div class="row">
                @if (Route::currentRouteName() == 'reseller_reports')
                    <div class="col-md-3">
                        <select id="resellers" name="reseller_id" class="form-select">
                            <option class="text-white bg-black option-lg" value="">Select Reseller</option>
                            <option class="text-white bg-black option-lg" value="all" {{ Request::get('reseller_id') == 'all' ? 'selected' : '' }}>All</option>
                            @foreach ($resellers as $reseller)
                                <option class="text-white bg-black option-lg" value="{{ $reseller->id }}" {{ Request::get('reseller_id') == $reseller->id ? 'selected' : '' }} >
                                    {{ $reseller->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <select id="filter_type" onchange="changeHandler()" class="form-select text-white">
                            <option class="text-white bg-black option-lg">Filter By</option>
                            <option class="text-white bg-black option-lg" value="trans">Trans Id</option>
                            <option class="text-white bg-black option-lg" value="top_amount">Requested Amount</option>
                            <option class="text-white bg-black option-lg" value="operators">Operator Name</option>
                            <option class="text-white bg-black option-lg" value="phone">Phone</option>
                            <option class="text-white bg-black option-lg" value="status">Status</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3" id="types_input">
                        <select id="status" name="top_status" class="form-select text-white" style="display: none;">
                            <option class="text-white bg-black option-lg" value="">Select Status</option>
                            <option class="text-white bg-black option-lg" value="1"
                                {{ Request::get('top_status') == '1' ? 'selected' : '' }}>
                                Successful</option>
                            <option class="text-white bg-black option-lg" value="0"
                                {{ Request::get('top_status') == '0' ? 'selected' : '' }}>Failed
                            </option>
                        </select>
                        <select id="operators" name="operator_name" class="form-select" style="display: none;">
                            <option class="text-white bg-black option-lg" value="">Select Operator</option>
                            <option class="text-white bg-black option-lg" value="Unknown">UNKNOWN</option>
                            @foreach ($operators as $operator)
                                <option class="text-white bg-black option-lg" value="{{ $operator->ntw_name }}">
                                    {{ $operator->ntw_name }}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control" style="height: 35px; font-size: 14px;"id="shared">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group ps-2 mt-1 mb-3">
                        <button type="submit" value="Search" class="form-control  btn btn-success p-1"><i
                                class="bi bi-search me-3"></i>Search</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="table-responsive">
                <table class="table" data-toggle="table" data-sort-class="table-active" data-sortable="true"
                    data-pagination="true" data-show-refresh="true" data-show-columns="true"
                    data-show-fullscreen="false">
                    <thead>
                        <tr class="text-center bg-dark" style="font-size: 18px;">
                            <th class="col text-white" style="font-size: 13px;" data-sortable="true">No</th>
                            <th class="col text-white" style="font-size: 13px;" data-sortable="true">Trans</th>
                            <th class="col text-white" style="font-size: 13px;" data-sortable="true">Date</th>
                            <th class="col text-white" style="font-size: 13px;" data-sortable="true">Operators</th>
                            <th class="col text-white" style="font-size: 13px;" data-sortable="true">Country</th>
                            <th class="col text-white" style="font-size: 13px;" data-sortable="true">Phone</th>
                            <th class="col text-white" style="font-size: 13px;" data-sortable="true">Amount</th>
                            <th class="col text-white" style="font-size: 13px;" data-sortable="true">Exc-amount</th>
                            <th class="col text-white" style="font-size: 13px;" data-sortable="true">My Profit</th>
                            <th class="col text-white" style="font-size: 13px;" data-sortable="true">Status</th>
                            <th class="col text-white" style="font-size: 13px;" data-sortable="true">Action</th>
                        </tr>
                    </thead>

                    <tbody style="font-size: 0.875rem;">
                        @php
                            $profit_total = 0;
                        @endphp
                        @if (count($topups) > 0)
                            @foreach ($topups as $topup)
                                <tr class="text-center  {{ $topup->top_status == 0 ? 'text-danger border-danger border-bottom ' : 'text-white' }}"
                                    data-status="{{ $topup->top_status ? 'Success' : 'Failed' }}">
                                    <td>{{ ($topups->currentPage() - 1) * $topups->perPage() + $loop->iteration }}
                                    <td>{{ $topup->id }}</td>
                                    <td>{{ $topup->created_at ? $topup->created_at->format('d-m-Y') : '' }}</td>
                                    <td>{{ $topup->top_ntw_name }}</td>
                                    <td>{{ $topup->top_country }}</td>
                                    <td>{{ $topup->top_phone_number }}</td>
                                    <td>{{ $topup->top_amount ? $topup->top_currency . ' ' . $topup->top_amount : '0' }}</td>
                                   
                                    @php
                                        // top_amount2 (EXC-AMOUNT) currecy base on it counry.
                                        $currencyList = [];
                                        $countryCurrency = '';
                                        $topAmount = $topup->top_amount2 ?? 0;
                                    
                                        foreach ($countries as $currency) {
                                            if (isset($currency['currencies'][0])) {
                                                $currencyList[] = $currency['currencies'][0];
                                                if ($topup->top_country === $currency->name->common) {
                                                    $countryCurrency = $currency['currencies'][0];
                                                }
                                            }
                                        }
                                    
                                        $currencyString = implode(', ', $currencyList);
                                    @endphp
                               
                                    <td>
                                        {{ $countryCurrency !== '' ? $topAmount . ' ' . $countryCurrency : $topAmount }}
                                    </td>

                                    <td>{{ $topup->top_profit ? $topup->top_profit : '0' }}</td>
                                    <td class="{{ $topup->top_status == 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $topup->top_status ? 'Success' : 'Failed' }}
                                    </td>
                                    <td class="text-white cursor-pointer text-sm" role="button"
                                        onclick="window.location.href = '{{ route('topup.details', ['id' => $topup->id]) }}';">
                                        Details
                                    </td>
                                </tr>
                                @php
                                    $profit_total += (int) $topup->top_profit;
                                @endphp
                            @endforeach
                        @else
                            <tr>
                                <td>No topup yet!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        {!! $topups->links() !!}
        </div>
        <div class="profits_and_sales mt-4" style="float: right;">
            <ul class="mainlist_styleship" style="list-style: none;">
                <li>
                    @php
                        $totalTopAmount = 0;
                    @endphp

                    @foreach ($topups as $topup)
                        @php
                            $totalTopAmount += $topup->top_amount;
                        @endphp
                    @endforeach
                    <span class="text-theme fw-bold">Sales Total: {{ $totalTopAmount }}</span>
                </li>
                <li>
                    <span>My Profit Total: {{ $profit_total }}</span>
                </li>
                <li>
                    <span>Transaction Count: {{ count($topups) }}</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="card-arrow">
        <div class="card-arrow-top-left"></div>
        <div class="card-arrow-top-right"></div>
        <div class="card-arrow-bottom-left"></div>
        <div class="card-arrow-bottom-right"></div>
    </div>
</div>

<script>
    const changeHandler = (e) => {
        const types = document.getElementById('types_input');
        const filterType = $('#filter_type').val();
        const shared = document.getElementById('shared');
        const status = document.getElementById('status');
        const operators = document.getElementById('operators');
        const children = types.children;

        if (filterType === 'status') {
            status.style.display = 'block';
            shared.style.display = 'none';
            operators.style.display = 'none';
            shared.removeAttribute('name');
        } else if (filterType === 'operators') {
            operators.style.display = 'block';
            status.style.display = 'none';
            shared.style.display = 'none';
            shared.removeAttribute('name');
        } else {
            shared.setAttribute('name', filterType);
            shared.style.display = 'block';
            status.style.display = 'none';
            operators.style.display = 'none';
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        flatPickerDate('startDate', 'startIcon');
        flatPickerDate('endDate', 'endIcon');
    });
</script>

<style>
    #row:hover {
        background: none;
    }
</style>
