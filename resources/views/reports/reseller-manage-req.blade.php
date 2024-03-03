@extends('layouts.app')
@section('content')
<div class="row">
    <div class="d-flex align-items-center mb-3">
        <h1 class="page-header">Requests</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr class="text-center">
                    <th>No</th>
                    <th>Name</th>
                    <th>Business Name</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Postal Code</th>
                    <th>Phone Number</th>
                    <th>Partner Type</th>
                    <th>Interests</th>
                </tr>
                @if (count($requestResel) > 0)
                    @foreach ($requestResel as $requestRes)
                        <tr class="text-center">
                            <td>{{ ($requestResel->currentPage() - 1) * $requestResel->perPage() + $loop->iteration }}
                            <td>{{ $requestRes->name }}</td>
                            <td>{{ $requestRes->business_name }}</td>
                            <td>{{ $requestRes->email }}</td>
                            <td>{{ $requestRes->country }}</td>
                            <td>{{ $requestRes->city }}</td>
                            <td>{{ $requestRes->postal_code }}</td>
                            <td>{{ $requestRes->phone_number }}</td>
                            <td>{{ $requestRes->partner_type }}</td>
                            <td>{{ $requestRes->interests }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">No records yet!</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
    {!! $requestResel->links() !!}
</div>
@endsection