@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="d-flex align-items-center mb-3">
            <h1 class="page-header">Management</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <x-messages />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="filter" class="mb-2" action="{{ route('manage_resellers') }}" method="GET">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label for="name" class="form-label"> Name  </label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name..."
                                        value="{{ Request::get('name') ? Request::get('name') : '' }}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile..."
                                        value="{{ Request::get('mobile') ? Request::get('mobile') : '' }}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                        value="{{ Request::get('email') ? Request::get('email') : '' }}"  placeholder="Email..."/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="user_country" class="form-label">Country</label>
                                    <input type="text" class="form-control" name="user_country" id="user_country"
                                        value="{{ Request::get('user_country') ? Request::get('user_country') : '' }}"
                                        placeholder="Country...">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" name="city" id="city"
                                           value="{{ Request::get('city') ? Request::get('city') : '' }}"
                                           placeholder="City...">
                                </div>
                            </div>  

                            <div class="col-md-2">
                                <label for="" class="form-label"></label>
                                <div class="form-group ps-2 mt-4 mb-2">
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
    <div class="card mt-2" style="z-index: 1;">
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table" data-toggle="table" data-sort-class="table-active" data-sortable="true"
                        data-pagination="true" data-show-refresh="true" data-show-columns="true"
                        data-show-fullscreen="false">
                        <thead>
                            <tr class="text-center bg-dark" style="font-size: 18px;">
                                <th class="col text-white" style="font-size: 13px;" data-sortable="true">No</th>
                                <th class="col text-white" style="font-size: 13px;" data-sortable="true">Name</th>
                                <th class="col text-white" style="font-size: 13px;" data-sortable="true">Mobile</th>
                                <th class="col text-white" style="font-size: 13px;" data-sortable="true">Country</th>
                                <th class="col text-white" style="font-size: 13px;" data-sortable="true">City</th>
                                <th class="col text-white" style="font-size: 13px;" data-sortable="true">Date</th>
                                <th class="col text-white" style="font-size: 13px;" data-sortable="true">Time</th>
                                <th class="col text-white" style="font-size: 13px;" data-sortable="true">Old Balance</th>
                                <th class="col text-white" style="font-size: 13px;" data-sortable="true">New Balance</th>
                                <th class="col text-white" style="font-size: 13px;" data-sortable="true">Email</th>
                                <th class="col text-white" style="font-size: 13px;" data-sortable="true">Edit Profile</th>
                                <th class="col text-white" style="font-size: 13px;" data-sortable="true">Add Balance</th>
                                <th class="col text-white" style="font-size: 13px;" data-sortable="true">Revert Balance</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.875rem;">
                            @if (count($resellers) > 0)
                                @foreach ($resellers as $reseller)
                                    <tr class="text-start"
                                        data-status="{{ $reseller->top_status ? 'Success' : 'Failed' }}">
                                        <td>{{ ($resellers->currentPage() - 1) * $resellers->perPage() + $loop->iteration }}
                                        <td>{{ $reseller->name }}</td>
                                        <td>{{ $reseller->mobile_no }}</td>
                                        <td>{{ $reseller->user_country }}</td>
                                        <td>{{ $reseller->city }}</td>
                                        <td>{{ optional($reseller->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ optional($reseller->created_at)->diffForHumans(null, true) }}</td>

                                        <td>{{ $reseller->old_balance ? $reseller->old_balance : '0' }}</td>
                                        <td>{{ $reseller->balance ? $reseller->balance : '0' }}</td>
                                        <td>{{ $reseller->email }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning text-white btn-sm">
                                                <a href="{{ route('users.edit', $reseller->id) }}"
                                                    class="submtting_pack dropdown-item d-flex align-items-center">Edit
                                                    Profile</a>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('resellers_create_balance', $reseller->id) }}">
                                                <button class="btn btn-success btn-sm">
                                                    Add Balance
                                                </button>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('resellers_edit_balance', $reseller->id) }}">
                                                <button class="btn btn-primary btn-sm">
                                                    Revert Balance
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>No reseller yet!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                {!! $resellers->links() !!}
            </div>
            <div class="profits_and_sales mt-4" style="float: right;">
                <ul class="mainlist_styleship" style="list-style: none;">
                    <li>
                        @php
                            $totalTopAmount = 0;
                        @endphp

                        @foreach ($resellers as $reseller)
                            @php
                                $totalTopAmount += $reseller->balance;
                            @endphp
                        @endforeach
                    </li>
                    <li>
                        <span>Total Resellers Balance: {{ $totalTopAmount }}</span>
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

@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Operator Deletion
        deleteWithModalConfirmation('delete-operator', '#exampleModal', 'operator_deletor',
            'operator-delete-form-', 'operator');
        // Fetching Operators of selected Country
        const countriesDropdown = document.getElementById('operator_country');
        const networksList = document.getElementById('operator_name');
        getNetworksForSelectedCountry(countriesDropdown, networksList, true);
    });
</script>


