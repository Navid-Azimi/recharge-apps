
@extends('layouts.app')
@section('content')
    <!-- BEGIN #tableHeadOptions -->
    <h4 class="header-title">Update Configuration</h4>
    <div class="card">
        <div class="card-body pb-2">
            @include('layouts.messages')
            <form action="{{ route('configurations.update', $configuration->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <input placeholder="Custom Rate" value="{{ $configuration->name }}" type="text" name="name" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <input placeholder="Custom Rate" value="{{ $configuration->value }}" type="text" name="value" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="mb-4 d-flex justify-content-between">
                    <a href="{{ route('configurations.index') }}" class="btn btn-danger btn-lg">Cancel</a>
                    <button type="submit" class="btn btn-success btn-lg">Submit</button>
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
