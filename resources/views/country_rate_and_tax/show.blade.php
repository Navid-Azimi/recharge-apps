@extends('layouts.app')
@section('content')


    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Country Tax And Rate</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary submtting_pack" href="{{ route('country_rate_and_tax.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Country ID</th>
                <th>Default Rate</th>
                <th>Logo</th>
            </tr>
            <tr>
            </tr>
        </table>
    </div>
@endsection

