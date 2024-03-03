@extends('layouts.app')
@section('content')
    <div id="tableHeadOptions" class="mb-5">
        <div class="d-flex align-items-center mb-2">
            <h1 class="page-header">Add New Operator</h1>
        </div>
        <div class="card">
            <div class="card-body pb-2">
                <x-validationErrors />
                <form action="{{ route('networks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="ntw_country_iso" class="form-label">Country</label>
                                <select class="form-control text-white bg-dark" name="ntw_country_iso" id="ntw_country_iso">
                                    <option class="option-lg" value="">SELECT COUNTRY</option>
                                    @foreach ($countries as $country)
                                        <option class="option-lg" value="{{ $country['iso_a3'] }}">
                                            {{ $country->name->common }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Operator</label>
                                <input type="text" name="ntw_name" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">General Commission</label>
                                <input type="number" step="0.1" name="ntw_rate" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Operator Logo</label><br>
                                <input type="file" name="ntw_logo" class="form-control"
                                    accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Min Value</label>
                                <input type="number" step="0.1" name="ntw_min_value" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Max Value</label>
                                <input type="number" step="0.1" name="ntw_max_value" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 d-flex w-100 justify-content-between">
                        <a href="{{ route('networks.index') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
                        <button type="Submit" class="submtting_pack btn btn-success btn-lg">Submit</button>
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
        var select = $('#ntw_country_iso').selectize({
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

        var selectInstance = select[0].selectize;

        selectInstance.on('change', function(values) {
            if (values.includes('all')) {
                var allIndex = values.indexOf('all');
                values.splice(0, values.length);
                values.push('all');
                selectInstance.setValue(values, true);
            }
        });
    </script>
@endsection
