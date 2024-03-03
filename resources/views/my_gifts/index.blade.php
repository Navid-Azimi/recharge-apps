@extends('layouts.app')
@section('content')
    <!-------------------- gift box -------------------->
    <div id="app" class="app app-content-full-height app-without-sidebar app-without-header d-print-none">
        <div class="row">
            <div class="d-flex align-items-center mb-2">
                <h1 class="page-header">My Gift Cards</h1>
            </div>
        </div>
        <div id="content" class="app-content p-0 pt-xl-3 pb-xl-3">
            <div class="pos card" id="pos">
                <div class="pos pos-vertical card" id="pos">
                    <div class="pos-container card-body">
                        <div class="pos-content">
                            <div class="pos-content-container h-100 p-3" data-scrollbar="true" data-height="100%">
                                <div class="row gx-3">
                                    <div class="d-flex flex-wrap p-2" id="giftReseller-container">
                                        @if (count($giftReseller) > 0)
                                            @foreach ($giftReseller as $gift)
                                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 p-2">
                                                    <!-- Updated col classes for small devices -->
                                                    <div class="gift-card" style="cursor:pointer;"
                                                        data-gift="{{ json_encode($gift) }}" data-bs-toggle="modal"
                                                        data-bs-target="#giftcard">
                                                        <div class="card">
                                                            <div class="card-body h-100 p-1">
                                                                <div class="pos-product">
                                                                    <div class="img">
                                                                        <div>
                                                                            @if ($gift->image)
                                                                                <img src="{{ asset('/storage/uploads/' . $gift->image) }}"
                                                                                    width="100%" height="200px"
                                                                                    alt="gift card logo">
                                                                            @else
                                                                                <img src="{{ asset('assets/img/pos/gift-1.jpg') }}"
                                                                                    width="100%" height="200px"
                                                                                    alt="gift card type logo">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="info">
                                                                        <div class="title text-center">{{ $gift->product }}</div>
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
    <!-------------------- gift box -------------------->

    <div id="giftcard" class="mb-5 p-4 modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="bg-gray-600 bg-inverse w-600px m-auto rounded-2">
                    <div class="card-header bg-transparent d-print-none">
                        <div class="modal-header border-bottom-0">

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="text-center">
                            <h4>Buy Gift Cards</h4>
                            <h6>Pay from your Balance</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="hljs-container">
                            <pre><code class="xml" data-url="assets/data/ui-modal-notification/code-1.json"></code></pre>
                        </div>

                        <!--Carousel Wrapper-->
                        <div id="carousel-example-2" class="carousel slide carousel-fade px-50px pb-25px"
                            data-ride="carousel" data-interval="false">

                            <!--Slides-->
                            <form action="{{ route('resellers.gitcard.send') }}" method="POST">
                                @csrf
                                <div class="carousel-inner" role="listbox">
                                    <div class="carousel-item active">
                                        <b class="d-print-none">Confirm your Gift info to send:</b>
                                        <!-- table-sm -->
                                        <table class="table table-sm mt-3">
                                            <tr class="text-white border-bottom mb-2">
                                                <th scope="col">Gift Type</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Total Price</th>
                                                <th scope="col">Currency</th>
                                                <th scope="col">Value</th>
                                                <th scope="col">Bar Code</th>
                                            </tr>
                                            <tbody id="giftDetailsBody" class="carousel-item.active">

                                            </tbody>
                                        </table>
                                        <ul class="d-print-none">
                                            <li>Be careful to not share the gift card details to others. </li>
                                            <li>Look at the selected Gift info. </li>
                                        </ul>
                                        <div class="d-flex justify-content-around d-print-none">
                                            <a class="btn btn-dark btn-lg flex-1 py-2" role="button"
                                                style="margin-right:10px;" data-bs-dismiss="modal">Cancel</a>
                                            <a class="btn btn btn-theme btn-lg flex-1 py-2" href="#carousel-example-2"
                                                role="button" id="printButton" data-slide="next">Print</a>
                                        </div>
                                    </div>
                                    {{-- <div class="carousel-item px-2">

                                        <div class="text-center">
                                            <h4>Add Recipient and Sender information</h4>
                                            <h6 class="text-gray-200">Pay attention to email & phone</h6>
                                            <input type="hidden" name="gift_id" id="gift_id">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input type="text"
                                                class="form-control bg-gray-300 text-white bg-inverse p-2" id="name"
                                                name="name" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email"
                                                class="form-control bg-gray-300 text-white bg-inverse p-2" id="email"
                                                name="email" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="phone">Phone Number</label>
                                            <input type="phone"
                                                class="form-control bg-gray-300 text-white bg-inverse p-2" id="phone"
                                                name="phone">
                                        </div>

                                        <div class="d-flex justify-content-around">
                                            <a class="btn btn btn-dark btn-lg flex-1 py-2" href="#carousel-example-2"
                                                role="button" data-slide="prev" style="margin-right:10px;">Back</a>
                                            <button type="submit" class="btn btn btn-theme btn-lg flex-1 py-2"
                                                  role="button">Submit</button>
                                        </div>
                                    </div> --}}

                                    {{-- <div class="carousel-item text-center ">
                                        <h2>Congratulations!</h2>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="my-3" width="121" height="120"
                                            viewBox="0 0 121 120" fill="none">
                                            <path
                                                d="M60.5 0L70.3326 10.5684L83.461 4.56723L88.5007 18.0939L102.926 17.5736L102.406 31.9993L115.933 37.039L109.932 50.1674L120.5 60L109.932 69.8326L115.933 82.961L102.406 88.0007L102.926 102.426L88.5007 101.906L83.461 115.433L70.3326 109.432L60.5 120L50.6674 109.432L37.539 115.433L32.4993 101.906L18.0736 102.426L18.5939 88.0007L5.06723 82.961L11.0684 69.8326L0.5 60L11.0684 50.1674L5.06723 37.039L18.5939 31.9993L18.0736 17.5736L32.4993 18.0939L37.539 4.56723L50.6674 10.5684L60.5 0Z"
                                                fill="#63DBB7" />
                                            <path d="M89.3002 40.8L49.7002 80.4L31.7002 62.4" stroke="#173A30"
                                                stroke-width="8" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <h2 class="my-2 mb-25px">Your Gift card in on it’s way!Yay </h2>
                                        <div class="d-flex justify-content-around my-2">
                                            <a class="btn btn btn-dark btn-lg flex-1 py-2" role="button"
                                                data-bs-dismiss="modal" style="margin-right:10px;">Close</a>
                                            <a class="btn btn btn-theme btn-lg flex-1 py-2" role="button"
                                                data-bs-dismiss="modal">Ok, Thanks!</a>
                                        </div>
                                    </div> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END #modal -->
    </div>
    <script>
        $('.gift-card').on('click', function() {
            var gift = $(this).data('gift');
            $('#gift_id').val(gift.id);
            let html = `<tr class="mt-3">
            <th>${gift.product }</th>
            <td class="text-center">${gift.price}</td>
            <td class="text-center">${gift.total}</td>
            <td class="text-center">${gift.currency}</td>
            <td class="text-center">${gift.value}</td>
            <td class="text-center">${gift.bar_code}</td>
        </tr>`;
            $("#giftDetailsBody").html(html);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const printBtn = document.getElementById('printButton');
            if (printBtn) {
                printBtn.addEventListener('click', function (event) {
                    event.preventDefault();
                    window.print();
                });
            }
        });
    </script>
@endsection
