@extends('layouts.app')
@section('content')
<!-- BEGIN #tableHeadOptions -->
<div id="tableHeadOptions" class="mb-5">
    <div class="d-flex align-items-center mb-3">
        <h1 class="page-header">Add New Operator Contact</h1>
    </div>
    <div class="card">
        <div class="card-body pb-2">
            <x-validationErrors />
            <form action="{{ route('networks_contact.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="operator" class="form-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="operator" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="operator" class="form-label">Phone</label>
                            <input type="tel" name="operator" class="form-control" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="operator" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="operator" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="operator" class="form-label">Town/City</label>
                            <input type="text" name="town_city" class="form-control" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="country" class="form-label">Country</label>
                        <select name="country" id="country">
                            @if(!isset($network))
                                <option value="">SELECT COUNTRY</option>
                            @endif
                            @foreach ($countries as $country)
                                <option value="{{ $country->name->common }}">{{ $country->name->common }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="operator" class="form-label">Zip Code</label>
                            <input type="text" name="zipcode" class="form-control" >
                        </div>
                    </div>

                    <!-- <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="operator" class="form-label">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3 d-flex justify-content-between w-100">
                            <a href="{{ route('networks_contact.index') }}" class="btn btn-danger btn-lg submtting_pack">Cancel</a>
                            <button type="submit" class="btn btn-success btn-lg submtting_pack">Submit</button>
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

<script>
    var $select = $('#country').selectize({
        maxItems: 1,
        create: false,
        dropdownParent: 'body',
        render: {
            option: function (data, escape) {
                 return '<div class="option option-lg' + (data.class ? data.class : '') + '">' +
                    escape(data.text) +
                    '</div>';
            }
        }
    });
</script>

<!-- END #tableHeadOptions -->
@endsection
