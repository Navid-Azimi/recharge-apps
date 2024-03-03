@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="d-flex align-items-center mb-1">
            <h1 class="page-header">All Packages</h1>
            <div class="ms-auto">
                <a href="{{ route('packages.create') }}" class="submtting_pack btn btn-primary btn-sm form-control">
                    <i class="fa fa-plus-circle fa-fw me-1"></i>Add New Package</a>
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
            <form id="pck_filter" class="mb-2" action="{{ route('packages.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="package_country" class="form-label">Country</label>
                            <select class="form-select" name="package_country" id="package_country">
                                <option class="option-lg" value="">SELECT COUNTRY</option>
                                <option class="option-lg" value="all"
                                    {{ Request::get('package_country') == 'all' ? 'selected' : '' }}>All
                                </option>
                                @foreach ($countries as $country)
                                    @if (isset($country->name->common))
                                        <option class="option-lg" value="{{ $country->name->common }}"
                                            {{ Request::get('package_country') === $country->name->common ? 'selected' : '' }}
                                            data-iso="{{ $country['iso_a3'] }}">
                                            {{ $country->name->common }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="package_operator" class="form-label">Operator</label>
                            <select class="form-select" name="package_operator" id="package_operator">
                                <option class="option-lg" value="">SELECT OPERATOR</option>
                                <option class="option-lg" value="all"
                                    {{ Request::get('package_operator') == 'all' ? 'selected' : '' }}>ALL
                                </option>
                                @foreach ($operators as $operator)
                                    <option class="option-lg" value="{{ $operator->id }}"
                                        {{ Request::get('package_operator') == $operator->id ? 'selected' : '' }}>
                                        {{ $operator->ntw_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="pck_type" class="form-label">Packages</label>
                            <select class="form-select" id="pck_type" name="pck_type">
                                <option class="option-lg" value="">SELECT PACKAGE</option>
                                <option class="option-lg" value="all"
                                    {{ Request::get('pck_type') === 'all' ? 'selected' : '' }}>ALL
                                </option>
                                <option class="option-lg" value="Voice"
                                    {{ Request::get('pck_type') === 'Voice' ? 'selected' : '' }}>Voice
                                </option>
                                <option class="option-lg" value="SMS"
                                    {{ Request::get('pck_type') === 'SMS' ? 'selected' : '' }}>SMS
                                </option>
                                <option class="option-lg" value="Data"
                                    {{ Request::get('pck_type') === 'Data' ? 'selected' : '' }}>Data
                                </option>
                                <option class="option-lg" value="Credit"
                                    {{ Request::get('pck_type') === 'Credit' ? 'selected' : '' }}>Credit
                                </option>
                                <option class="option-lg" value="Mixed"
                                    {{ Request::get('pck_type') === 'Mixed' ? 'selected' : '' }}>Mixed
                                </option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="package_user_role" class="form-label">User Role</label>
                            <div class="typeahead__query input-group">
                                <span class="input-group-text bg-transparent"><i class="fa fa-laptop"></i></span>
                                <select class="form-select" id="package_user_role" name="package_user_role">
                                    <option class="option-lg" value=""
                                        {{ Request::get('package_user_role') === 'all' ? 'selected' : '' }}>SELECT ROLE
                                    </option>
                                    <option class="option-lg" value="all"
                                        {{ Request::get('package_user_role') === 'all' ? 'selected' : '' }}>All</option>
                                    <option value="admin"
                                        {{ Request::get('package_user_role') === 'admin' ? 'selected' : '' }}>ADMIN
                                    </option>
                                    <option value="reseller"
                                        {{ Request::get('package_user_role') === 'reseller' ? 'selected' : '' }}>RESELLER
                                    </option>
                                    <option value="customer"
                                        {{ Request::get('package_user_role') === 'customer' ? 'selected' : '' }}>CUSTOMER
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="package_user" class="form-label">User</label>
                            <select class="bg-dark text-white form-control" name="package_user[]" id="package_user"
                                multiple>
                                <option value="">SELECT USER</option>
                                <option value="all" {{ Request::get('package_user') == 'all' ? 'selected' : '' }}>ALL
                                </option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ Request::get('package_user') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label"></label>
                        <div class="form-group ps-2 mt-4 mb-2">
                            <button type="submit" value="Search" class="form-control  btn btn-success p-1"><i
                                    class="bi bi-search me-3"></i>Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive mb-3">
        <table class="table table-bordered">
            <tr style="text-align: center;">
                <th style="vertical-align: middle;" rowspan="2">No</th>
                <th colspan="8">Package</th>
                <th style="vertical-align: middle;" rowspan="2" width="280px">Action</th>
            </tr>
            <tr class="text-center">
                <th>Type</th>
                <th>Credit</th>
                <th>Data Amt</th>
                <th>Minutes Amt</th>
                <th>SMS Amt</th>
                <th>Price</th>
                <th>Currency</th>
                <th>Network</th>
             </tr>
            @if ($packages->count() > 0)
                @foreach ($packages as $package)
                    <tr class="text-center">
                        <td>{{ ($packages->currentPage() - 1) * $packages->perPage() + $loop->iteration }}</td>
                        <td>{{ $package->pck_type }}</td>
                        <td>{{ $package->pck_credit_amount ? $package->pck_credit_amount : '0.00' }}</td>
                        <td>{{ $package->pck_data_amount ? $package->pck_data_amount : '0.00' }}</td>
                        <td>{{ $package->pck_minutes_amount ? $package->pck_minutes_amount : '0.00' }}</td>
                        <td>{{ $package->pck_sms_amount ? $package->pck_sms_amount : '0.00' }}</td>
                        <td>{{ $package->pck_price ? $package->pck_price : '0' }}</td>
                        <td>{{ $package->pck_currency_id ? $package->pck_currency_id : 'Not Specified' }}</td>
                        <td>{{ $package->network ? $package->network->ntw_name : 'Not Specified' }}</td>
                        <td class="d-flex gap-1 justify-content-center">
                            <a class="submtting_pack btn btn-primary btn-sm" href="{{ route('packages.edit', $package->id) }}">Edit</a>
                            <form class="m-0" action="{{ route('packages.destroy', $package->id) }}"method="POST"
                                id="package-delete-form-{{ $package->id }}">
                                @csrf
                                @method('DELETE')
                                 <button type="button" class="btn btn-danger btn-sm delete-package"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    data-package-id="{{ $package->id }}">Delete</button>
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

    <!-- BEGIN #modal -->
    <div id="exampleModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title">Delete Package</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal-body">
                            <div class="panel">
                                <div class="panel-body text-center py-2">
                                    <h3> Are you sure you want to delete this Package?</h3>
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
    {!! $packages->links() !!}

    <script>
        const userRole = document.getElementById('package_user_role');
        const usersList = document.getElementById('package_user');
        const countriesDropdown = document.getElementById('package_country');
        const networksList = document.getElementById('package_operator');

        var select = $('#package_user').selectize({
            maxItems: null,
            valueField: 'id',
            labelField: 'title',
            searchField: 'title',
            create: false,
            render: {
                option: function(item, escape) {
                    return '<div class="option option-lg">' + escape(item.title) + '</div>';
                }
            },
        });

        var selectizeInstance = select[0].selectize;

        selectizeInstance.on('change', function(values) {
            if (values.includes('all')) {
                var allIndex = values.indexOf('all');
                values.splice(0, values.length);
                values.push('all');
                selectizeInstance.setValue(values, true);
            }
        });
    </script>
@endsection
 
<script>
    // Fetching Users
    document.addEventListener('DOMContentLoaded', function() {
        userRole.addEventListener('change', async function() {
            const selectedRole = userRole.value;
            try {
                let endpoint = `/users-by-role/${selectedRole}`;
                if (selectedRole === '' || selectedRole === 'all') {
                    endpoint = '/all-users';
                }
                const response = await fetch(endpoint);

                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }

                const data = await response.json();

                usersList.innerHTML = '';

                if (data.users.length > 0) {
                    updateUsersList(selectizeInstance, data.users);
                }
            } catch (error) {
                console.error('An error occurred:', error);
            }
        });

        getNetworksForSelectedCountry(countriesDropdown, networksList);

        // Package Deletion
        deleteWithModalConfirmation('delete-package', '#exampleModal', 'package_deletor', 'package-delete-form-', 'package');

    });
</script>