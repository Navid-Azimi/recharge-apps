@extends('layouts.app')
@section('content')
    <!-- BEGIN #tableHeadOptions -->

    <div id="tableHeadOptions" class="mb-5">
        <div class="d-flex align-items-center mb-2">
            <h1 class="page-header">Add New Commissions</h1>
        </div>
        <div class="card">
            <div class="card-body pb-2">
                <x-validationErrors />
                <form action="{{ route('commissions.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Network</label>
                                <select class="form-select" name="com_ntw_id">
                                    @if(!isset($commissions))
                                        <option value="">SELECT NETWORK</option>
                                    @endif
                                    @foreach ($networks as $network)
                                        <option value="{{ $network->id }}">{{ $network->ntw_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">Reseller</label>
                                <select class="form-select" name="com_user_id">
                                    @if(!isset($commissions))
                                        <option value="">SELECT USER</option>
                                    @endif
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="validationInvalidInputGroup" class="form-label">Custom Commission</label>
                                <input type="number" name="com_custom_rate" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3 d-flex align-items-center">
                            <div class="form-group mb-3"><br>
                                <a href="{{ route('commissions.index') }}" class="btn btn-danger btn-lg">Cancel</a>
                            <button type="submit" class="btn btn-success btn-lg">Submit</button>
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

    <!-- END #tableHeadOptions -->
@endsection



