@extends('layouts.app')
@section('content')
    <div id="tableHeadOptions" class="mb-5">
        <div class="d-flex align-items-center mb-2">
            <h1 class="page-header">Add New Announcement</h1>
        </div>
        <div class="card">
            <div class="card-body pb-2">
                <x-validationErrors />
                <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data" id="delete-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                             <div class="form-group mb-2">
                                <label for="ann_country" class="form-label">Country</label>
                                <select class="form-select" name="ann_country" id="ann_country">
                                    <option class="option-lg" value="">SELECT COUNTRY</option>
                                    <option class="option-lg" value="All">All</option>
                                    @foreach ($countries as $country)
                                     @if (isset($country->name->common))
                                            <option   class="option-lg" value="{{ $country->name->common }}" data-iso="{{ $country['iso_a3'] }}">
                                                {{ $country->name->common }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="ann_logo" class="form-label">Logo</label>
                                <input type="file" class="form-control" name="ann_logo" id="ann_logo" >
                             </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group border p-2 mb-3">
                                <textarea name="content" class="summernote" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4 d-flex w-100 justify-content-between">
                                <a href="{{ route('announcements.index') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
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
@endsection
