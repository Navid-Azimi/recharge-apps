
@extends('layouts.app')
@section('content')
    <!-- BEGIN #tableHeadOptions -->
    <h4 class="header-title mb-3">Update Commissions</h4>
    <div class="card">
        <div class="card-body pb-2">
           <x-validationErrors />
            <form class="mb-0 mt-2" action="{{ route('commissions.update', $commission->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="com_ntw_id" class="form-label">Network</label>
                            <select class="form-select" name="com_ntw_id" id="com_ntw_id">
                                @foreach ($networks as $network)
                                    <option value="{{ $network->id }}" {{ $network->id == $commission->com_ntw_id ? 'selected' : '' }}>{{ $network->ntw_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="com_user_id" class="form-label">Reseller</label>
                            <select id="com_user_id" name="com_user_id" class="form-control" required>
                                @foreach ($users as $userOption)
                                    <option value="{{ $userOption->id }}" {{ $userOption->id == $commission->com_user_id ? 'selected' : '' }}>{{ $userOption->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="com_custom_rate" class="form-label">Custom Commission</label>
                            <input placeholder="Custom Rate" id="com_custom_rate" value="{{ $commission->com_custom_rate }}" type="number" name="com_custom_rate" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" style="margin-top: 30px;">
                       <div class="form-group">
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
    <!-- END #tableHeadOptions -->
@endsection
