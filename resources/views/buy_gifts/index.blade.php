@extends('layouts.app')
@section('content')
    <!-------------------- gift box -------------------->
    <div id="app" class="app app-content-full-height app-without-sidebar app-without-header">
        <div class="row">
            <div class="d-flex align-items-center mb-2">
                <h1 class="page-header">Buy Your Gift Cards</h1>
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
                                        @if (count($buyGift) > 0)
                                            @foreach ($buyGift as $gift)
                                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 p-2">
                                                    <!-- Updated col classes for small devices -->
                                                    <div class="gift-card" style="cursor:pointer"
                                                        onclick="redirectToGiftTypeList('{{ route('giftTypeList', ['brand_name' => $gift->brand_name]) }}')">
                                                        <div class="card">
                                                            <div class="card-body h-100 p-1">
                                                                <div class="pos-product">
                                                                    <div class="img">
                                                                        <div>
                                                                            @if($gift->brand_logo)
                                                                                <img src="{{ asset('/storage/uploads/' . $gift->brand_logo) }}" 
                                                                                    width="100%" height="200px" alt="gift card logo">
                                                                            @else
                                                                                <img src="{{ asset('assets/img/pos/gift-1.jpg') }}" 
                                                                                    width="100%" height="200px" alt="gift card type logo">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="info">
                                                                        <div class="title text-center">{{ $gift->brand_name }}</div>
                                                                        <div class="title text-center">{{ $gift->brand_country }}</div>
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
        function redirectToGiftTypeList(url) {
            window.location.href = url;
        }
    </script>
@endsection
