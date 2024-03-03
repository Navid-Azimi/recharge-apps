@extends('layouts.app')
@section('content')
    <!-- BEGIN #tableHeadOptions -->
    <div class="card text-decoration-none p-4">
        <div class="align-items-center mb-3">
            <h1 class="page-header">Create New GiftCard</h1>
            <x-validationErrors />
            <form action="{{ route('giftcard.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="form-group mb-2">
                            <label for="validationInvalidInputGroup" class="form-label">Country</label>
                            <select class="bg-dark text-white" id="select-tools" name="country_iso">
                                <option value="" class="bg-dark">SELECT COUNTRY</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country['iso_a3'] }}">{{ $country['name']['common'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group mb-2">
                            <label for="validationInvalidInputGroup" class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group mb-2">
                            <label for="validationInvalidInputGroup" class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-between w-100">
                    <a href="{{ route('giftcard.index') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
                    <button type="submit" class="submtting_pack btn btn-success btn-lg">Submit</button>
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

    <script>
        var $select = $('#select-tools').selectize({
            maxItems: 1,
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
    </script>
@endsection






