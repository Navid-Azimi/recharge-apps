@extends('layouts.app')
@section('content')
    <h4 class="header-title mb-3">Update Announcement</h4>
    <div class="card">
        <div class="card-body pb-2">
            <x-validationErrors />
            <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="ann_country" class="form-label">Selected Country</label>
                            <select class="form-select" name="ann_country" id="ann_country">
                                <option class="option-lg" value="">SELECT COUNTRY</option>
                                <option class="option-lg" value="All"
                                    {{ $announcement->ann_country == 'All' ? 'selected' : '' }}>All</option>
                                @foreach ($countries as $country)
                                    <option class="option-lg" value="{{ $country->name->common }}"
                                        {{ $country->name->common == $announcement->ann_country ? 'selected' : '' }}>
                                        {{ $country->name->common }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3 mt-3">
                            <label for="current_logo" class="form-label">Current Logo: </label>
                            @if ($announcement->ann_logo)
                                <img src="{{ asset('/storage/uploads/' . $announcement->ann_logo) }}" width="50"
                                    height="50" alt="announcement logo">
                            @else
                                <img src="{{ asset('assets/img/user/place.png') }}" width="50" height="50"
                                    alt="announcement logo">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="ann_logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" name="ann_logo" id="ann_logo">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group border p-2 mb-3">
                            <textarea name="content" class="summernote" rows="5">{!! $announcement->text !!}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-4 d-flex w-100 justify-content-between">
                            <a href="{{ route('announcements.index') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
                            <button type="submit" class="submtting_pack btn btn-success btn-lg">Update</button>
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
@endsection
