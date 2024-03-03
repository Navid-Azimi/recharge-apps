@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex align-items-center mb-3">
                <h1 class="page-header">All Gift Card Types</h1>
                <div class="ms-auto">
                    <a href="{{ route('giftcardtypes.create') }}"
                        class="submtting_pack btn btn-primary btn-sm form-control"><i
                            class="fa fa-plus-circle fa-fw me-1"></i> Add Gift Card Type</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <x-messages />
        </div>
    </div>
    <!-- searching codes start  -->
    <div class="card mb-2 p-0">
        <div class="card-body p-0">
            <div class="search_countries_contact d-flex flex-column">
                <div class="flex-1">
                    <form action="{{ route('giftcardtypes.index') }}" method="GET" class="m-0">
                        <div class="input-group mb-12 d-flex gap-2">
                            <input type="text" class="form-control" name="title"
                                value="{{ $search['title'] ?? '' }}" placeholder="Search Gift Type...">

                            <input type="text" class="form-control" name="brand_name"
                                value="{{ $search['brand_name'] ?? '' }}" placeholder="Search Gift Brand...">

                            <div class="d-flex gap-1">
                                <button title="Search" class="btn btn-outline-theme" type="submit"><i
                                        class="fas fa-lg fa-fw  fa-search"></i></button>
                                <button title="Clear" class="btn btn-outline-theme" type="submit" name="reset"><i
                                        class="far fa-lg fa-fw fa-times-circle"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-arrow">
            <div class="card-arrow-top-left"></div>
            <div class="card-arrow-top-right"></div>
            <div class="card-arrow-bottom-left"></div>
            <div class="card-arrow-bottom-right"></div>
        </div>
    </div>
    <!-- searching codes end  -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Gift Type</th>
                        <th>Gift Brand</th>
                        <th>Terms</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th width="280px">Action</th>
                    </tr>
                    @if (count($giftcardtypes) > 0)
                        @foreach ($giftcardtypes as $giftcardtype)
                            <tr class="text-center">
                                <td>{{ ($giftcardtypes->currentPage() - 1) * $giftcardtypes->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $giftcardtype->title }}</td>
                                <td>{{ optional($giftcardtype->cardBrand)->brand_name }}</td>
                                <td class="text-start">{{ $giftcardtype->terms }}</td>
                                <td>
                                    @if ($giftcardtype->image)
                                        <img src="{{ asset('/storage/uploads/' . $giftcardtype->image) }}" width="50"
                                            height="50" alt="gift card type image">
                                    @else
                                        <img src="{{ asset('assets/img/pos/gift-1.jpg') }}" width="50" height="50"
                                            alt="gift card type image">
                                    @endif
                                </td>
                                <td class="text-start">{{ $giftcardtype->description }}</td>
                                <td class="d-flex gap-2 justify-content-center">
                                    <a class="submtting_pack btn btn-primary btn-sm"
                                        href="{{ route('giftcardtypes.edit', $giftcardtype->id) }}">Edit</a>
                                    <form class="m-0" action="{{ route('giftcardtypes.destroy', $giftcardtype->id) }}"
                                        method="POST" id="giftcardtype-delete-form-{{ $giftcardtype->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="  btn btn-danger btn-sm delete-giftcardtype"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal"
                                            data-giftcardtype-id="{{ $giftcardtype->id }}">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">No records yet!</td>
                        </tr>
                    @endif
                </table>
            </div>
            {!! $giftcardtypes->links() !!}
        </div>
    </div>
    <!-- BEGIN #modal -->
    <div id="exampleModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title">Delete giftcardtype</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal-body">
                            <div class="panel">
                                <div class="panel-body text-center py-2">
                                    <h3> Are you sure you want to delete this gift card type?</h3>
                                </div>
                                <div class="form-group mybody mt-2 d-flex justify-content-between mb-3">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END #modal -->
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        deleteWithModalConfirmation('delete-giftcardtype', '#exampleModal', 'giftcardtype_deletor',
            'giftcardtype-delete-form-', 'giftcardtype');
    });
</script>
