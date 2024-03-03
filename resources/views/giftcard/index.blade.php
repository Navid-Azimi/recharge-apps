@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-messages />
        </div>
        <!-- BEGIN #modal -->
        <div id="exampleModal" class=" mt-5 modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <h3> Are you sure you want to delete Gift Card?</h3>
                                    </div>
                                    <div class="form-group mt-2 d-flex justify-content-between mb-3">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger"
                                            id="gift-confirm-delete">Delete</button>
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
    </div>

    <div class="card mb-2">
        <div class="card-header bg-none fw-bold d-flex justify-content-between align-items-center">
            <h4>Gift Card</h4>
            <a href="{{ route('giftcard.create') }}" class="submtting_pack btn btn-primary p-2">Create New GiftCard</a>
        </div>
        <div class="my-2 p-3">
            <form action="{{ route('giftcard.index') }}">
                <div class="row">
                    @csrf
                    <div class="col-md-5 col-sm-6">
                        <div class="form-group">
                            <label class="form-label" for="" class="my-2">Choose recipient’s country to select
                                gift cards</label>
                            <select class="bg-dark text-white form-control mt-2" id="giftcard-country" name="country_iso">
                                <option value="" class="bg-dark border-red-500">SELECT COUNTRY</option>
                                <option value="all" class="bg-dark border-red-500">ALL COUNTRIES</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country['iso_a3'] }}" class="w-full zindex-tooltip"
                                        style="background-color: #your_color; z-index: 100;">{{ $country->name->common }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label class="form-label" for="giftCard-name" class="my-2"> Choose your favorite
                                product</label>
                            <input type="text" class="form-control py-2 mt-2 d-inline-block" name="giftCard_name"
                                id="giftCard-name">
                        </div>
                    </div>
                    <div class="col-md-1 justify-content-end d-flex flex-column">
                        <div class="form-group">
                            <button type="submit" class="btn form-control btn-success d-inline-block "
                                style="padding: 12px 0 12px 0;"><i class="fa fa-search"></i></button>
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

    <!-------------------- gift box -------------------->
    <div id="app" class="app app-content-full-height app-without-sidebar app-without-header">
        <div id="content" class="app-content p-0 pt-xl-3 pb-xl-3">
            <div class="pos card" id="pos">
                <div class="pos pos-vertical card" id="pos">
                    <div class="pos-container card-body">
                        <div class="pos-content">
                            <div class="pos-content-container h-100 p-3" data-scrollbar="true" data-height="100%">
                                <div class="row gx-3">
                                    <div class="d-flex flex-wrap p-2" id="giftcard-container">
                                        @if (count($giftcard) > 0)
                                            @foreach ($giftcard as $gift)
                                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 pb-3 ">
                                                    <!-- Updated col classes for small devices -->
                                                    <div class="gift-card" data-country="{{ $gift->country_iso }}"
                                                        data-name="{{ $gift->name }}" style="cursor:pointer;"
                                                        onclick="showModal({{ json_encode($gift) }})" data-bs-toggle="modal"
                                                        data-bs-target="#giftcard">
                                                        <div class="card">
                                                            <div class="card-body h-100 p-1">
                                                                <div class="pos-product">
                                                                    <div class="img"
                                                                        style="background-image: url(assets/img/pos/gift-1.jpg)">
                                                                    </div>
                                                                    <div class="info">
                                                                        <div class="title text-truncate">
                                                                            {{ $gift->name }}</div>
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
                                            <p>No record yet!</p>
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

    <div id="giftcard" class="mb-5 p-4 modal fade" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="bg-gray-600 bg-inverse w-600px m-auto rounded-2">
                    <div class="card-header bg-transparent">
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
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active">
                                    <b>Provide your quantity of choice for item:</b>
                                    <!-- table-sm -->
                                    <table class="table table-sm mt-3">

                                        <tr class="text-white border-bottom mb-2">
                                            <th scope="col">Product</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">UnitFee</th>
                                            <th scope="col">Total Price</th>
                                        </tr>

                                        <tbody>
                                            <tr class="mt-3">
                                                <th scope="row" id="gc_name">Gift Card for you</th>
                                                <td>Usd 29.9</td>
                                                <td>1</td>
                                                <td>SEK309.51</td>
                                                <td>SEK14.68</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <ul>
                                        <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </li>
                                        <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </li>
                                        <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </li>
                                        <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </li>
                                    </ul>
                                    <div class="d-flex justify-content-around">
                                        <a class="btn btn-dark btn-lg flex-1 py-2" role="button"
                                            style="margin-right:10px;" data-bs-dismiss="modal">Cancel</a>
                                        <a class="btn btn btn-theme btn-lg flex-1 py-2" href="#carousel-example-2"
                                            role="button" data-slide="next">Add Recipient</a>
                                    </div>

                                    <div class="border-top mt-4">
                                        <form method="POST" id="deleteGiftCardForm" action="#">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="submtting_pack btn btn-danger btn-sm mt-2"
                                                id="delBtn" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">Delete This Gift Card</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="carousel-item px-2">
                                    <div class="text-center">
                                        <h4>Add Recipient and Sender information</h4>
                                        <h6 class="text-gray-200">Pay from you Balance</h6>
                                    </div>
                                    <form>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="exampleFormControlInput1">Name</label>
                                            <input type="text"
                                                class="form-control bg-gray-300 text-white bg-inverse p-2"
                                                id="exampleFormControlInput1" placeholder="" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="exampleFormControlInput1">Email</label>
                                            <input type="email"
                                                class="form-control bg-gray-300 text-white bg-inverse p-2"
                                                id="exampleFormControlInput1" placeholder="" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="exampleFormControlInput1">Phone Number</label>
                                            <input type="phone"
                                                class="form-control bg-gray-300 text-white bg-inverse p-2"
                                                id="exampleFormControlInput1" placeholder="">
                                        </div>
                                    </form>
                                    <div>
                                        <div class="form-check text-white">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">Send the Gift Card Via
                                                Email</label>
                                        </div>
                                        <div class="form-check text-white mt-1">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="defaultCheck2">
                                            <label class="form-check-label" for="defaultCheck2">Send the Gift Card Via
                                                SMS</label>
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <span>SMS service is only available in live mode, please switch the environment to
                                            enable it.</span>
                                    </div>
                                    <div class="d-flex justify-content-around">
                                        <a class="btn btn btn-dark btn-lg flex-1 py-2" href="#carousel-example-2"
                                            role="button" data-slide="prev" style="margin-right:10px;">Back</a>
                                        <button type="submit" class="btn btn btn-theme btn-lg flex-1 py-2"
                                            href="#carousel-example-2" role="button" data-slide="next">Next</button>
                                    </div>
                                </div>

                                <div class="carousel-item text-center ">
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
                                            data-bs-dismiss="modal" style="margin-right:10px;">Print receipt</a>
                                        <a class="btn btn btn-theme btn-lg flex-1 py-2" role="button"
                                            data-bs-dismiss="modal">Ok, Thanks!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END #modal -->
    </div>

    <script>
        const gc_name = document.getElementById("gc_name");
        const delBtn = document.getElementById('delBtn');
        const deleteForm = document.getElementById('deleteGiftCardForm');
        let gc_id = null;
        const showModal = (gift_card) => {
            gc_name.innerHTML = gift_card.name
            gc_id = gift_card.id
        }
        deleteForm.addEventListener("submit", (e) => deleteForm.setAttribute('action',
            `{{ route('giftcard.destroy', ':id') }}`.replace(':id', gc_id)))
    </script>

    <script>
        var $select = $('#giftcard-country').selectize({
            maxItems: 1,
            create: false,
            dropdownParent: 'body',
            render: {
                option: function(data, escape) {
                    return '<div class="option option-lg' + (data.class ? data.class : '') + '">' +
                        escape(data.text) +
                        '</div>';
                }
            }
        });
    </script>

    <!-- Script for deleting base on modal  -->
    <script>
        document.getElementById("gift-confirm-delete").addEventListener("click", function() {
            document.getElementById("delBtn").submit();
        });
    </script>

@endsection
