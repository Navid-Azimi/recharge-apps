@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="d-flex align-items-center mb-3">
            <h1 class="page-header">Registered Operators</h1>
            <div class="ms-auto">
                <a href="{{ route('networks.create') }}" class="submtting_pack btn btn-primary btn-sm form-control"><i
                        class="fa fa-plus-circle fa-fw me-1"></i> Add Operator</a>
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
            <form id="operator_filter" class="mb-2" action="{{ route('networks.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label for="operator_country" class="form-label">Country</label>
                            <select class="form-select" name="operator_country" id="operator_country">
                                <option class="option-lg" value="">SELECT COUNTRY</option>
                                <option class="option-lg" value="all"
                                    {{ Request::get('operator_country') == 'all' ? 'selected' : '' }}>All
                                </option>
                                @foreach ($allCountries as $country)
                                    <option class="option-lg" value="{{ $country['iso_a3'] }}"
                                        {{ Request::get('operator_country') == $country['iso_a3'] and (Request::get('operator_country') !== 'null' ? 'selected' : '') }}
                                        data-iso="{{ $country['iso_a3'] }}">
                                        {{ $country['name']['common'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="operator_name" class="form-label">Operator Name</label>
                            <select class="form-select" name="operator_name" id="operator_name">
                                <option class="option-lg" value="">SELECT OPERATOR</option>
                                <option class="option-lg" value="all"
                                    {{ Request::get('operator_name') === 'all' ? 'selected' : '' }}>All</option>
                                @foreach ($networks as $network)
                                    <option class="option-lg" value="{{ $network->ntw_name }}"
                                        {{ Request::get('operator_name') === $network->ntw_name ? 'selected' : '' }}>
                                        {{ $network->ntw_name }}</option>
                                @endforeach
                            </select>
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
    </div>

    <!-- BEGIN #modal -->
    <div id="exampleModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title">Delete Operator</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal-body">
                            <div class="panel">
                                <div class="panel-body text-center py-2">
                                    <h3> Are you sure you want to delete this Operator</h3>
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
    <div>
        <table class="table table-bordered">
            <tr class="text-center">
                <th>No</th>
                <th>Country</th>
                <th>Operator</th>
                <th>Max & Min values</th>
                <th>General Commission</th>
                <th>Logo</th>
                <th width="280px">Action</th>
            </tr>
            @if (count($networks) > 0)
                @foreach ($networks as $network)
                    <tr class="text-center ">
                        <td>{{ ($networks->currentPage() - 1) * $networks->perPage() + $loop->iteration }}</td>
                        <td>
                            @php
                                $countryObject = $allCountries->where('iso_a3', $network->ntw_country_iso)->first();
                                $commonName = $countryObject ? $countryObject['name']['common'] : '';
                            @endphp
                            {{ $commonName }}
                        </td>
                        <td>{{ $network->ntw_name }}</td>
                        <td class="text-green ">
                            @if ($network->ntw_min_value > 0)
                                {{ $network->ntw_min_value }} - {{ $network->ntw_max_value }}
                            @endif
                        <td>{{ $network->ntw_rate }}</td>

                        <td>
                            @if ($network->ntw_logo)
                                <img src="{{ asset('/storage/uploads/' . $network->ntw_logo) }}"
                                    onerror="this.src='{{ asset('assets/img/user/place.png') }}'" alt="Logo"
                                    width="70px"height="70px">
                            @else
                                <img src="{{ asset('assets/img/user/place.png') }}" alt="Logo" width="70px"
                                    height="70px">
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('networks.destroy', $network->id) }}" method="POST"
                                id="operator-delete-form-{{ $network->id }}">
                                <!-- <a class="btn btn-success btn-sm" href="{{ route('networks.show', $network->id) }}">Show</a> -->
                                <a class="submtting_pack btn btn-primary btn-sm"
                                    href="{{ route('networks.edit', $network->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-operator" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-operator-id="{{ $network->id }}">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7">No records yet!</td>
                </tr>
            @endif
        </table>
        {!! $networks->links() !!}
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
