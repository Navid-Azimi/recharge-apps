@extends('layouts.app')
@section('content')
    <!-- Loader -->
    @include('layouts.submit_loader')
    <!-- Loader -->

    <!-- BEGIN #tableHeadOptions -->
    <h4 class="header-title mb-3">Update Network</h4>

    <div class="card">

        <div class="card-body pb-2">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('networks.update', $network->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">Selected Country</label>
                            <select class="form-select" name="ntw_country_iso">
                                @foreach ($countries as $country)
                                    <option class="option-lg" value="{{ $country['iso_a3'] }}"
                                        {{ $country['iso_a3'] == $network->ntw_country_iso ? 'selected' : '' }}>
                                        {{ $country->name->common }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">Network</label>
                            <input type="text" name="ntw_name" value="{{ $network->ntw_name }}" class="form-control">
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">General Commission</label>
                            <input type="text" name="ntw_rate" value="{{ $network->ntw_rate }}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">Network Logo</label><br>
                            <input type="file" name="ntw_logo" class="form-control-file"
                                accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">Min Value</label>
                            <input type="number" step="0.1" name="ntw_min_value" value="{{ $network->ntw_min_value }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">Max Value</label>
                            <input type="number" step="0.1" name="ntw_max_value" value="{{ $network->ntw_max_value }}"
                                class="form-control">
                        </div>
                    </div>

                </div>
                <div class="mb-4 d-flex justify-content-between w-100">
                    <a href="{{ route('networks.index') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
                    <button type="submit" class="submtting_pack btn btn-success btn-lg">Update</button>
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
    <!-- END #tableHeadOptions -->
@endsection