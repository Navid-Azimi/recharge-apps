@extends('layouts.app')
@section('content')

    <!-- BEGIN #tableHeadOptions -->
    <div id="tableHeadOptions" class="mb-5">
        <div class="d-flex align-items-center mb-3">
            <h4 class="header-title">Create New User</h4>
        </div>
        <div class="card">
            <div class="card-body pb-2">
                <x-validationErrors />
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">User Name</label>
                                <div class="typeahead__query input-group">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') ? old('name') : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="typeahead__query input-group">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    <input type="text" class="form-control" id="email" name="email"
                                        value="{{ old('email') ? old('email') : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="typeahead__query input-group">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div class="typeahead__query input-group">
                                    <span class="input-group-text"><i class="fa fa-thumbs-up"></i></span>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="user_avatar" class="form-label">Avatar</label>
                                <input type="file" class="form-control" name="avatar" id="user_avatar" >
                             </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="user_role" class="form-label">User Role</label>
                            <div class="typeahead__query input-group">
                                <span class="input-group-text"><i class="fa fa-laptop"></i></span>
                                <select class="form-select form-select-lg" id="user_role" name="user_role">
                                    <option>Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="reseller">Reseller</option>
                                    <option value="customer">Customer</option>
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                            <label for="user_country" class="form-label">Country</label>
                                <div class="typeahead__query input-group">
                                    <span class="input-group-text"><i class="fas fa-lg fa-fw me-2 fa-globe"></i></span>
                                    <select class="form-select" name="user_country" id="user_country">
                                        <option class="option-lg" value="">SELECT COUNTRY</option>
                                        @foreach ($countries as $country)
                                            @if (isset($country->name->common))
                                                <option class="option-lg" value="{{ $country->name->common }}" data-iso="{{ $country['iso_a3'] }}"> {{ $country->name->common }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">City/State</label>
                                <div class="typeahead__query input-group">
                                    <span class="input-group-text"><i class="fas fa-city"></i></span>
                                    <input type="text" class="form-control" id="city" name="city">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Business Type</label>
                                <div class="typeahead__query input-group">
                                    <span class="input-group-text"><i class="fas fa-business-time"></i></span>
                                    <input type="text" class="form-control" id="business_type" name="business_type">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">ID/Passport NU</label>
                                <div class="typeahead__query input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                                    <input type="number" class="form-control" id="passport_number" name="passport_number">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">License NU</label>
                                <div class="typeahead__query input-group">
                                    <span class="input-group-text"><i class="fa fa-drivers-license-o"></i></span>
                                    <input type="number" class="form-control" id="business_license_nu" name="business_license_nu">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mt-3 d-flex justify-content-between mb-3">
                                <a href="{{ route('users.index') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
                                <button type="submit" class="submtting_pack btn btn-success btn-lg">Submit</button>
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
