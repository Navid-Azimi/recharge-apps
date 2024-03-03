@extends('layouts.app')
@section('content')

<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Commissions</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('commissions.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Commission Commission_id:</strong>
                {{ $commission->com_ntw_id }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Commission User_id:</strong>
                {{ $commission->com_user_id }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Commission Customer Rrate:</strong>
                {{ $commission->com_custom_rate }}
            </div>
        </div>
    </div>
@endsection