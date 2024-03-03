@extends('layouts.app')
@section('content')
    <!-------------------- gift box -------------------->
    <div id="app" class="app app-content-full-height app-without-sidebar app-without-header">
        <div class="row">
            <div class="d-flex align-items-center mb-2">
                <h1 class="page-header">List of Gift Types</h1>
            </div>
        </div>
        <div id="content" class="app-content p-0 pt-xl-3 pb-xl-3">
            <div class="pos card" id="pos">
                <div class="pos pos-vertical card" id="pos">
                    <div class="pos-container card-body">
                        <div class="pos-content">
                            <div class="pos-content-container h-100 p-3" data-scrollbar="true" data-height="100%">
                                <div class="row gx-3">
                                     <div class="d-flex flex-wrap p-2">
                                        @if (count($gTypeList) > 0)
                                            @foreach ($gTypeList as $gift)
                                                 <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 p-2">
                                                    <!-- Updated col classes for small devices -->
                                                    <div class="gift-card" style="cursor:pointer">
                                                        <div class="card">
                                                            <div class="card-body h-100 p-1">
                                                                <div class="pos-product">
                                                                    <div class="img">
                                                                        <div>
                                                                            @if (optional($gift->giftType)->image)
                                                                                <img src="{{ asset('/storage/uploads/' . $gift->giftType->image) }}"
                                                                                    width="100%" height="200px" alt="gift card logo">
                                                                            @else
                                                                                <img src="{{ asset('assets/img/pos/gift-1.jpg') }}"
                                                                                    width="100%" height="200px" alt="gift card type logo">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="info">
                                                                        <div class="title text-center">{{ optional($gift->giftType)->title }}</div>
                                                                        <div class="title">Price: {{ $gift->price }}</div>
                                                                        <div class="title">Currency: {{ $gift->currency }}</div>
                                                                        <div class="title">Value: {{ $gift->value }}</div>
                                                                        <div class="title">Bar Code: {{ $gift->bar_code }}</div>
                                                                        <div class="title">Status: {{ $gift->status }}</div>
                                                                        <div>Terms: {{ optional($gift->giftType)->terms }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-arrow">
                                                                <div class="card-arrow-top-left"></div>
                                                                <div class="card-arrow-top-right"></div>
                                                                <div class="card-arrow-bottom-left"></div>
                                                                <div class="card-arrow-bottom-right"></div>
                                                            </div>
                                                            @if ($gift->status != 'active')
                                                                <button class="buy-button mb-4 py-2" disabled>Purchased</button>
                                                            @else
                                                                <button class="buy-button mb-4 py-2 buy-card-button" data-giftType="{{ $gift->id }}">Buy</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div>
                                                <p>No gift yet!</p>
                                            </div>
                                        @endif
                                    </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buyButtons = document.querySelectorAll('.buy-card-button');
            buyButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    button.disabled = true;
                    button.innerHTML = 'Loading...';
                    const typeid = button.getAttribute('data-giftType');
                    $.ajax({
                        url: '{{ route("buy-gift") }}',
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'giftType_id': typeid,
                        },
                        success: function(response) {
                            button.innerHTML = 'Done';
                            alert('Gift card purchased successfully.');
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Error: ' + xhr.responseText);
                            button.disabled = false;
                            button.innerHTML = 'Buy';
                        }
                    });
                });
            });
        });
    </script>
@endsection