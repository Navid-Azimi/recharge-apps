@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex align-items-center mb-3">
                <h1 class="page-header">All Gift Cards</h1>
                <div class="ms-auto">
                    <a href="{{ route('giftcards.create') }}" class="submtting_pack btn btn-primary btn-sm form-control"><i
                            class="fa fa-plus-circle fa-fw me-1"></i> Add Gift Card</a>
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
                    <form action="{{ route('giftcards.index') }}" method="GET" class="m-0">
                        <div class="input-group mb-12 d-flex gap-2">
                            <input type="text" class="form-control" name="title"
                                value="{{ $search['title'] ?? '' }}" placeholder="Search Gift Type...">

                            <input type="text" class="form-control" name="status"
                                value="{{ $search['status'] ?? '' }}" placeholder="Search Status...">

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
                        <th>Price</th>
                        <th>Currency</th>
                        <th>Discount</th>
                        <th>Total</th>
                        <th>Value</th>
                        <th>Bar Code</th>
                        <th>Type Image</th>
                        <th>Status</th>
                        <th width="280px">Action</th>
                    </tr>
                    @if (count($giftcards) > 0)
                        @foreach ($giftcards as $giftCard)
                            <tr class="text-center">
                                <td>{{ ($giftcards->currentPage() - 1) * $giftcards->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ optional($giftCard->giftType)->title }}</td>
                                <td>{{ $giftCard->price }}</td>
                                <td>{{ $giftCard->currency }}</td>
                                <td>{{ $giftCard->discount }}</td>
                                <td>{{ $giftCard->total }}</td>
                                <td>{{ $giftCard->value }}</td>
                                <td>{{ $giftCard->bar_code }}</td>
                                <td>
                                    @if (optional($giftCard->giftType)->image)
                                        <img src="{{ asset('/storage/uploads/' . $giftCard->giftType->image) }}"
                                            width="50" height="50" alt="gift card type logo">
                                    @else
                                        <img src="{{ asset('assets/img/pos/gift-1.jpg') }}" width="50" height="50"
                                            alt="gift card type logo">
                                    @endif
                                </td>
                                <td>{{ $giftCard->status }}</td>
                                <td class="d-flex gap-2 justify-content-center">
                                    <a class="submtting_pack btn btn-primary btn-sm"
                                        href="{{ route('giftcards.edit', $giftCard->id) }}">Edit</a>
                                    <form class="m-0" action="{{ route('giftcards.destroy', $giftCard->id) }}"
                                        method="POST" id="giftCard-delete-form-{{ $giftCard->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="  btn btn-danger btn-sm delete-giftCard"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal"
                                            data-giftCard-id="{{ $giftCard->id }}">Delete</button>
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
            {!! $giftcards->links() !!}
        </div>
    </div>
    <!-- BEGIN #modal -->
    <div id="exampleModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title">Delete Gift Card</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal-body">
                            <div class="panel">
                                <div class="panel-body text-center py-2">
                                    <h3> Are you sure you want to delete this gift card?</h3>
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
    <!-- BEGIN #modal -->
    <div id="exModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title text-center">THE NUMBER OF GIFT CARDS</h5>
                            <button type="button" class="btn-close modal-action-button" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal-body">
                            <div class="panel">
                                <div class="panel-body text-center py-2">
                                    <h3></h3>
                                </div>
                                <div class="form-group mybody mt-2 d-flex justify-content-center">
                                    <button type="button" class="btn btn-success btn-lg modal-action-button" data-bs-dismiss="modal">OK</button>
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
    <!-- BEGIN #modal -->
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        deleteWithModalConfirmation('delete-giftCard', '#exampleModal', 'giftcard_deletor',
            'giftCard-delete-form-', 'giftCard');

        // Gift Card Alert
        let activeGiftCards = @json($activeGiftCardsCount);
        let maxActiveGiftCards = 5;
        if (activeGiftCards <= maxActiveGiftCards && activeGiftCards > 0) {
            openGiftCardModal(activeGiftCards);
        }
        function openGiftCardModal(activeGiftCards) {
            let myModal = new bootstrap.Modal(document.getElementById('exModal'));
            $('#exModal .modal-body h3').text('Number of active gift cards: ' + activeGiftCards);
            myModal.show();
            document.querySelectorAll('.modal-action-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    myModal.hide();
                });
            });
        }
    });
</script>
