@extends('layouts.app')
@section('content')
    @inject('countriesData', 'PragmaRX\Countries\Package\Countries')
    <!-- searching codes end  -->
    <div class="row">
        <div class="d-flex align-items-center mb-3">
            <h1 class="page-header">Operator Contacts</h1>
            <div class="ms-auto">
                <a href="{{ route('networks_contact.create') }}" class="btn btn-primary btn-sm form-control submtting_pack"><i
                        class="fa fa-plus-circle fa-fw me-1"></i>Add New Contact</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <x-messages />
        </div>
    </div>
    <div class="card mb-2 p-0">
        <div class="card-body p-0">
            <div class="search_countries_contact d-flex flex-column">
                <div class="flex-1">
                    <form action="{{ route('networks_contact.index') }}" method="GET" class="m-0">
                        <div class="input-group mb-12 d-flex gap-2">
                            <select class="form-select" name="country" id="search_base_on_country">
                                <option value="" class="bg-dark border-red-500">SELECT COUNTRY</option>
                                @foreach ($countriesData->all() as $country)
                                    <option id="search_country" value="{{ $country['iso_a3'] }}"
                                        {{ isset($search['country']) && $search['country'] == $country['iso_a3'] ? 'selected' : '' }}>
                                        {{ $country->name->common }}
                                    </option>
                                @endforeach
                            </select>
                            <input id="#search-input" type="text" class="form-control" name="name"
                                value="{{ $search['name'] ?? '' }}" placeholder="Search Name...">
                            <input type="text" class="form-control" name="operator"
                                value="{{ $search['operator'] ?? '' }}" placeholder="Search Phone...">

                            <div class="d-flex gap-1">
                                <button title="Search" class="btn btn-outline-theme" type="submit"><i
                                        class="fas fa-lg fa-fw  fa-search"></i></button>
                                <button title="Clear" class="btn btn-outline-theme" type="submit" name="reset"><i
                                        class="far fa-lg fa-fw fa-times-circle"></i></button>
                            </div>
                        </div>
                    </form>
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
    <!-- searching codes end  -->
    
         <!-- BEGIN #modal -->
         <div id="exampleModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="modal-header border-bottom-0">
                                <h5 class="modal-title">Delete Contact</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="modal-body">
                                <div class="panel">
                                    <div class="panel-body text-center py-2">
                                        <h3> Are you sure you want to delete this operator contact?</h3>
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
    <div class="row">
        <div class="table-responsive">
            @if ($noResults)
                <h4 style="text-align: center;">No records found.</h4>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center bg-dark" style="font-size: 18px;">
                            <th class="text-white" style="font-size: 13px;" data-sortable="true">No</th>
                            <th class="text-white" style="font-size: 13px;" data-sortable="true">Country</th>
                            <th class="text-white" style="font-size: 13px;" data-sortable="true">Name</th>
                            <th class="text-white" style="font-size: 13px;" data-sortable="true">Last Name</th>
                            <th class="text-white" style="font-size: 13px;" data-sortable="true">Phone Number</th>
                            <th class="text-white" style="font-size: 13px;" data-sortable="true">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr class="text-center">
                                <td>{{ ($contacts->currentPage() - 1) * $contacts->perPage() + $loop->iteration }}</td>
                                <td>{{ $contact->country }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->lastname }}</td>
                                <td>{{ $contact->operator }}</td>
                                <td>
                                    <form action="{{ route('networks_contact.destroy', $contact->id) }}" method="POST"
                                        class="d-flex justify-content-center gap-3" id="contact-delete-form-{{ $contact->id }}">
                                        <!-- <a class="btn btn-success btn-sm" href="{{ route('networks_contact.show', $contact->id) }}">Show</a> -->
                                        <a class="btn btn-primary btn-sm submtting_pack"
                                            href="{{ route('networks_contact.edit', $contact->id) }}">Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" class="btn btn-danger btn-sm delete-contact" data-contact-id="{{ $contact->id }}">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        {!! $contacts->links() !!}
    </div>
    <script>
         // Contact Deletion
         document.addEventListener('DOMContentLoaded', function() {
            deleteWithModalConfirmation('delete-contact', '#exampleModal', 'contact_deletor', 'contact-delete-form-', 'contact');
         });
    </script>
@endsection
