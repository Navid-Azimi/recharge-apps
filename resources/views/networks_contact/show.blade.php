@extends('layouts.app')
@section('content')
@inject('countries','PragmaRX\Countries\Package\Countries')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> {{ $network->ntw_name }} Network</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary submtting_pack" href="{{ route('networks.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Country ID</th>
                <th>Default Rate</th>
                <th>Logo</th>
            </tr>
            <tr>
                <td>{{ $network->ntw_name }}</td>
                <td>
                    @php
                        $countryObject = $countries->where('iso_a3', $network->ntw_country_iso)->first();
                        $commonName = $countryObject ? $countryObject->name->common : '';
                    @endphp
                    {{ $commonName }}
                </td>
                <td>{{ $network->ntw_rate }}</td>
                <td>
                    @if($network->ntw_logo)
                    <img src="{{ asset($network->ntw_logo) }}" onerror="this.src='{{ asset('images/placeholder.png') }}'" alt="Logo" width="70px" height="70px">
                    @else
                        No logo
                    @endif
                </td>
            </tr>
        </table>
    </div>
@endsection

