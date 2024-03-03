
@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="d-flex align-items-center mb-3">
            <h2>Country rates and taxes</h2>
            <div class="ms-auto">
            <a class="submtting_pack btn btn-primary" href="{{ route('country_rate_and_tax.create') }}"> Create Tax</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-md-12">
            <x-messages />
        </div>
    </div>
    <!-- BEGIN #modal -->
    <div id="exampleModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title">Delete Country Tax & Rate</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal-body">
                            <div class="panel">
                                <div class="panel-body text-center py-2">
                                    <h3> Are you sure you want to delete this Country Tax & Rate?</h3>
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

    <div class="table-responsive mb-3">
        <table class="table table-bordered">
            <tr class="text-center">
                <th>No</th>
                <th>Country Name</th>
                <th>Country Code</th>
                <th>Product Type</th>
                <th>Tax</th>
                <th>Rate</th>
                <th>Description</th>
                <th width="280px">Action</th>
            </tr>
            @if (count($country_rates) > 0)
                @foreach ($country_rates as $country_rate)
                    <tr class="text-center">
                        <td>{{ ($country_rates->currentPage() - 1) * $country_rates->perPage() + $loop->iteration }}</td>
                        <td>{{ $country_rate->country_name }}</td>
                        <td>{{ $country_rate->country_code }}</td>
                        <td>{{ $country_rate->product_type }}</td>
                        <td>{{ $country_rate->tax }}</td>
                        <td>{{ $country_rate->rate }}</td>
                        <td>{{ $country_rate->description }}</td>
                        <td>
                            <form action="{{ route('country_rate_and_tax.destroy', $country_rate->id) }}" method="POST" id="countryrate-delete-form-{{ $country_rate->id }}">
                                @csrf
                                @method('DELETE')
                                <!-- <a class="btn btn-info" href="{{ route('country_rate_and_tax.show', $country_rate->id) }}">Show</a> -->
                                <a class="submtting_pack btn btn-primary" href="{{ route('country_rate_and_tax.edit', $country_rate->id) }}">Edit</a>
                                <button type="button" class=" btn btn-danger btn-sm delete-countryrate" data-bs-toggle="modal" data-bs-target="#exampleModal" data-countryrate-id="{{ $country_rate->id }}">Delete</button>
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
    </div>
    {!! $country_rates->links() !!}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        deleteWithModalConfirmation('delete-countryrate', '#exampleModal', 'countryrate_deletor','countryrate-delete-form-', 'countryrate');
     });
    </script>
@endsection