@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Packages</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary submtting_pack" href="{{ route('packages.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>pck_type:</strong>
                {{ $package->pck_type }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>pck_type:</strong>
                {{ $package->pck_credit_amount }}
            </div>
        </div>
    </div>
@endsection