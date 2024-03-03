@extends('layouts.app')
@section('content')

    <!-- BEGIN #tableHeadOptions -->
    <h3 class="header-title mb-3">Edit User: {{ $user->name }}</h3>
    <div class="card">
        <div class="card-body pb-2">
            <x-validationErrors />
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">User Name</label>
                            <div class="typeahead__query input-group">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="typeahead__query input-group">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
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
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
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
                                <select class="form-select" id="user_role" name="user_role">
                                    <option>Select Role</option>
                                    <option value="admin" {{ $user->user_role == "admin"  ? 'selected' : '' }}>Admin</option>
                                    <option value="reseller" {{ $user->user_role == "reseller"  ? 'selected' : '' }}>Reseller</option>
                                    <option value="customer" {{ $user->user_role == "customer"  ? 'selected' : '' }}>Customer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="user_country" class="form-label">Selected Country</label>
                                <div class="typeahead__query input-group">
                                    <span class="input-group-text"><i class="fas fa-lg fa-fw me-2 fa-globe"></i></span>
                                    <select class="form-select" name="user_country" id="user_country">
                                        <option class="option-lg" value="">SELECT COUNTRY</option>
                                        @foreach ($countries as $country)
                                            <option class="option-lg" value="{{ $country->name->common }}"
                                                {{ $country->name->common == $user->user_country ? 'selected' : '' }}>
                                                {{ $country->name->common }}</option>
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
                                <input type="text" class="form-control" id="city" name="city" value="{{ $user->city }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Business Type</label>
                            <div class="typeahead__query input-group">
                                <span class="input-group-text"><i class="fas fa-business-time"></i></span>
                                <input type="text" class="form-control" id="business_type" name="business_type" value="{{ $user->business_type }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">ID/Passport NU</label>
                            <div class="typeahead__query input-group">
                                <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                                <input type="number" class="form-control" id="passport_number" name="passport_number" value="{{ $user->passport_number }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">License NU</label>
                            <div class="typeahead__query input-group">
                                <span class="input-group-text"><i class="fa fa-drivers-license-o"></i></span>
                                <input type="number" class="form-control" id="business_license_nu" name="business_license_nu" value="{{ $user->business_license_nu }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="validationInvalidInputGroup" class="form-label">Status</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="status_{{ $user->id }}" name="status" value="1" {{ $user->status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_{{ $user->id }}">
                                    {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="typeahead__query input-group mt-3">
                            <div class="d-flex justify-content-between w-100">
                                <a href="{{ url('/users') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
                                <button type="submit" class="submtting_pack btn btn-success btn-lg">Update</button>
                            </div>
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


