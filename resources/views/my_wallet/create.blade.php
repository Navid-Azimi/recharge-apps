@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-messages />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header bg-transparent fw-bold small d-flex justify-content-center align-items-center">
                    <h4 class="flex-grow-1 text-center mt-2">Add New Payment</h4>
                </div>
                <div class="card-body text-center d-flex justify-content-between flex-column  pt-5 pb-3">
                    <div class="content pb-4">
                        <h2 id="balanceDisplayer" data-balance="{{ $balance }}">${{ $balance }}</h2>
                        <button class="btn mt-2 btn-success btn-lg btn-block" data-bs-toggle="modal"
                            data-bs-target="#paymentModal">Add Balance</button>
                    </div>
                    <div class="notify text-start">
                        {{-- <input type="checkbox"> Notify me via email when my payment added --}}
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
        <div class="col-lg-4 col-md-4 col-sm-12">
            @php
                $user = auth()->user();
            @endphp
            <div class="card">
                <div class="card-header bg-transparent fw-bold small d-flex justify-content-center align-items-center">
                    <h4 class="flex-grow-1 text-center mt-2">Auto Recharge <span id="autoRechargeFlag"
                            class="{{ $user->is_auto_recharge_enabled ? 'text-success' : 'text-danger' }}">{{ $user->is_auto_recharge_enabled ? 'On' : 'Off' }}</span>
                    </h4>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="isAutoRechargeEnabled"
                            {{ $user->is_auto_recharge_enabled ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="card-body py-4">
                    <label for="#rechargeRange" class="form-label">Recharge my account</label>
                    <div class="wrapper d-flex justify-content-between gap-3">
                        <span class="text-white fs-5" id="selectedRange">$0</span>
                        <div class="range w-75">
                            <input type="range" class="form-range" id="rechargeRange" value="{{ $user->recharge_amount }}"
                                name="rechargeRange" min="100" max="5000" step="1">
                            <div class="numbers d-flex justify-content-between">
                                <span>$100</span>
                                <span>$5000</span>
                            </div>
                        </div>

                    </div>
                    <br>
                    <label for="#balanceRange" class="form-label">When my balance reaches</label>
                    <div class="wrapper d-flex justify-content-between gap-3">
                        <span class="text-white fs-5" id="selectedBalance">$0</span>
                        <div class="range w-75">
                            <input type="range" class="form-range" id="balanceRange"
                                value="{{ $user->threshould_amount }}" min="10" max="1000" step="1">
                            <div class="numbers d-flex justify-content-between">
                                <span>$10</span>
                                <span>$1000</span>
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
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card mb-4">
                <div class="card-header bg-transparent fw-bold small d-flex justify-content-between align-items-center">
                    <h5 class="text-center mt-2">Default Payment Method</h5>
                    <i class="fa fa-star fw-bold"></i>
                </div>
                <div class="card-body d-flex py-5">
                    @empty(!$card)
                        <div class="left w-75">
                            <p class="text-white fw-bold">{{ $card->card_number }}</p>
                            <div class="d-flex justify-content-start flex-column">
                                <span class="text-gray fw-sm">Cardholder Name</span>
                                <p class="my-2 text-white fw-bold">{{ $card->name_on_card }}</p>
                            </div>
                            <div class="verification">
                                @if ($card->cvc)
                                    <span class="d-flex justify-content-start align-items-center"><img
                                            src="{{ asset('assets/img/check.png') }}" width="15px" class="img-responsive me-1"
                                            alt="">Verified</span>
                                @endif
                            </div>
                        </div>
                        <div class="right text-right">
                            <img class="img-responsive mb-2" width="50px"
                                src="{{ asset('assets/img/cards/' . $card->brand_name . '.png') }}" alt="">
                            <div class="">
                                <span class="text-gray fw-sm">Valid Till</span>
                                <p class="my-2 text-white fw-bold">
                                    {{ $card->expiration_month }}/{{ $card->expiration_year }}</p>
                            </div>
                        </div>
                    @endempty
                    @empty($card)
                        <div class="py-4 text-center w-100">
                            <p>No Default Method Yet!</p>
                        </div>
                    @endempty
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
    <!-- BEGIN #modal -->
    <div id="paymentModal" class="mb-5 p-4 modal fade" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title">Make A Payment</h5>
                            <div class="d-flex justify-content-end">
                                <div class="spinner-border" role="status" style="display: none;" id="paymentLoader">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <button type="button" id="dismisser" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal-body">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="panel panel-default credit-card-box p-5 pt-0">
                                        <div class="panel-heading display-table">
                                            <h4 class="panel-title text-center"><strong>Payment Details</strong>
                                            </h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class='error form-group d-none'>
                                                <div class='alert-danger alert'>Please correct the errors and try again.
                                                </div>
                                            </div>
                                            <x-validationErrors />
                                            <form role="form" action="{{ route('reseller_payment') }}" method="post"
                                                class="require-validation" data-cc-on-file="false"
                                                data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                                                @csrf

                                                <div class="form-row row cardRelated">
                                                    <div class='col-xs-12 form-group required'>
                                                        <label class='control-label ' for="#name_on_card">Name on
                                                            Card</label>
                                                        <input class='form-control cardFeild'
                                                            value="{{ $card ? $card->name_on_card : '' }}"
                                                            name="name_on_card" id="name_on_card" size='4'
                                                            type='text'>
                                                    </div>
                                                </div>

                                                <div class="form-row row cardRelated">
                                                    <div class='col-xs-12 form-group card required'>
                                                        <label class='control-label' for="#card_number">Card
                                                            Number</label>
                                                        <input autocomplete='off'
                                                            value="{{ $card ? $card->card_number : '' }}"
                                                            name="card_number" id="card-number"
                                                            class='form-control cardFeild' size='20' type='text'>
                                                    </div>
                                                </div>

                                                <div class='form-row row'>
                                                    <div class='col-xs-12 form-group card required'>
                                                        <label class='control-label' for="#amount">Amount</label>
                                                        <input autocomplete='off' id="amount" name="amount"
                                                            class='form-control' size='20' type='text' required>
                                                    </div>
                                                </div>
                                                <div class="form-row row cardRelated">
                                                    <div class='col-xs-12 col-md-4 form-group cvc required'>
                                                        <label class='control-label' for="#cvc">CVC</label>
                                                        <input autocomplete='off' value="{{ $card ? $card->cvc : '' }}"
                                                            name="cvc" id="cvc"
                                                            class='form-control card-cvc cardFeild' placeholder='ex. 311'
                                                            size='4' type='text'>
                                                    </div>
                                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                        <label class='control-label' for="#expire_month">Expiration
                                                            Month</label>
                                                        <input class='form-control card-expiry-month cardFeild'
                                                            value="{{ $card ? $card->expiration_month : '' }}"
                                                            name="expire_month" placeholder='MM' size='2'
                                                            type='text' id="expire_month">
                                                    </div>
                                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                        <label class='control-label' for="#expire_year">Expiration
                                                            Year</label>
                                                        <input class='form-control card-expiry-year cardFeild'
                                                            value="{{ $card ? $card->expiration_year : '' }}"
                                                            name="expire_year" placeholder='YYYY' size='4'
                                                            type='text' id="expire_year">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <button class="btn mt-2 btn-primary btn-lg btn-block"
                                                            type="submit" name="formDefault">Pay Now </button>
                                                        @empty(!$card)
                                                            <button type="button" id="anotherCard"
                                                                class="btn mt-2 btn-outline-info btn-lg">Payment
                                                                With New Card</button>
                                                            <button onclick="defaultPaymentor(this,'{{ $card }}')"
                                                                type="button" id="defaultCard"
                                                                class="btn mt-2 btn-outline-primary btn-lg payDefault"
                                                                style="display: none;">Payment
                                                                With Default Card</button>
                                                        @endempty
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>

                                    {{-- <center>
                                        <a href="{{ route('make.payment') }}">
                                            <button class="btn btn-block btn-lg btn-info btn-fill btn-round">
                                                <span class="paypal-button-text true" optional=""
                                                    data-v-44bf4aee="">Pay
                                                    with </span>
                                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAxcHgiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAxMDEgMzIiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaW5ZTWluIG1lZXQiIHhtbG5zPSJodHRwOiYjeDJGOyYjeDJGO3d3dy53My5vcmcmI3gyRjsyMDAwJiN4MkY7c3ZnIj48cGF0aCBmaWxsPSIjZmZmZmZmIiBkPSJNIDEyLjIzNyAyLjggTCA0LjQzNyAyLjggQyAzLjkzNyAyLjggMy40MzcgMy4yIDMuMzM3IDMuNyBMIDAuMjM3IDIzLjcgQyAwLjEzNyAyNC4xIDAuNDM3IDI0LjQgMC44MzcgMjQuNCBMIDQuNTM3IDI0LjQgQyA1LjAzNyAyNC40IDUuNTM3IDI0IDUuNjM3IDIzLjUgTCA2LjQzNyAxOC4xIEMgNi41MzcgMTcuNiA2LjkzNyAxNy4yIDcuNTM3IDE3LjIgTCAxMC4wMzcgMTcuMiBDIDE1LjEzNyAxNy4yIDE4LjEzNyAxNC43IDE4LjkzNyA5LjggQyAxOS4yMzcgNy43IDE4LjkzNyA2IDE3LjkzNyA0LjggQyAxNi44MzcgMy41IDE0LjgzNyAyLjggMTIuMjM3IDIuOCBaIE0gMTMuMTM3IDEwLjEgQyAxMi43MzcgMTIuOSAxMC41MzcgMTIuOSA4LjUzNyAxMi45IEwgNy4zMzcgMTIuOSBMIDguMTM3IDcuNyBDIDguMTM3IDcuNCA4LjQzNyA3LjIgOC43MzcgNy4yIEwgOS4yMzcgNy4yIEMgMTAuNjM3IDcuMiAxMS45MzcgNy4yIDEyLjYzNyA4IEMgMTMuMTM3IDguNCAxMy4zMzcgOS4xIDEzLjEzNyAxMC4xIFoiPjwvcGF0aD48cGF0aCBmaWxsPSIjZmZmZmZmIiBkPSJNIDM1LjQzNyAxMCBMIDMxLjczNyAxMCBDIDMxLjQzNyAxMCAzMS4xMzcgMTAuMiAzMS4xMzcgMTAuNSBMIDMwLjkzNyAxMS41IEwgMzAuNjM3IDExLjEgQyAyOS44MzcgOS45IDI4LjAzNyA5LjUgMjYuMjM3IDkuNSBDIDIyLjEzNyA5LjUgMTguNjM3IDEyLjYgMTcuOTM3IDE3IEMgMTcuNTM3IDE5LjIgMTguMDM3IDIxLjMgMTkuMzM3IDIyLjcgQyAyMC40MzcgMjQgMjIuMTM3IDI0LjYgMjQuMDM3IDI0LjYgQyAyNy4zMzcgMjQuNiAyOS4yMzcgMjIuNSAyOS4yMzcgMjIuNSBMIDI5LjAzNyAyMy41IEMgMjguOTM3IDIzLjkgMjkuMjM3IDI0LjMgMjkuNjM3IDI0LjMgTCAzMy4wMzcgMjQuMyBDIDMzLjUzNyAyNC4zIDM0LjAzNyAyMy45IDM0LjEzNyAyMy40IEwgMzYuMTM3IDEwLjYgQyAzNi4yMzcgMTAuNCAzNS44MzcgMTAgMzUuNDM3IDEwIFogTSAzMC4zMzcgMTcuMiBDIDI5LjkzNyAxOS4zIDI4LjMzNyAyMC44IDI2LjEzNyAyMC44IEMgMjUuMDM3IDIwLjggMjQuMjM3IDIwLjUgMjMuNjM3IDE5LjggQyAyMy4wMzcgMTkuMSAyMi44MzcgMTguMiAyMy4wMzcgMTcuMiBDIDIzLjMzNyAxNS4xIDI1LjEzNyAxMy42IDI3LjIzNyAxMy42IEMgMjguMzM3IDEzLjYgMjkuMTM3IDE0IDI5LjczNyAxNC42IEMgMzAuMjM3IDE1LjMgMzAuNDM3IDE2LjIgMzAuMzM3IDE3LjIgWiI+PC9wYXRoPjxwYXRoIGZpbGw9IiNmZmZmZmYiIGQ9Ik0gNTUuMzM3IDEwIEwgNTEuNjM3IDEwIEMgNTEuMjM3IDEwIDUwLjkzNyAxMC4yIDUwLjczNyAxMC41IEwgNDUuNTM3IDE4LjEgTCA0My4zMzcgMTAuOCBDIDQzLjIzNyAxMC4zIDQyLjczNyAxMCA0Mi4zMzcgMTAgTCAzOC42MzcgMTAgQyAzOC4yMzcgMTAgMzcuODM3IDEwLjQgMzguMDM3IDEwLjkgTCA0Mi4xMzcgMjMgTCAzOC4yMzcgMjguNCBDIDM3LjkzNyAyOC44IDM4LjIzNyAyOS40IDM4LjczNyAyOS40IEwgNDIuNDM3IDI5LjQgQyA0Mi44MzcgMjkuNCA0My4xMzcgMjkuMiA0My4zMzcgMjguOSBMIDU1LjgzNyAxMC45IEMgNTYuMTM3IDEwLjYgNTUuODM3IDEwIDU1LjMzNyAxMCBaIj48L3BhdGg+PHBhdGggZmlsbD0iI2ZmZmZmZiIgZD0iTSA2Ny43MzcgMi44IEwgNTkuOTM3IDIuOCBDIDU5LjQzNyAyLjggNTguOTM3IDMuMiA1OC44MzcgMy43IEwgNTUuNzM3IDIzLjYgQyA1NS42MzcgMjQgNTUuOTM3IDI0LjMgNTYuMzM3IDI0LjMgTCA2MC4zMzcgMjQuMyBDIDYwLjczNyAyNC4zIDYxLjAzNyAyNCA2MS4wMzcgMjMuNyBMIDYxLjkzNyAxOCBDIDYyLjAzNyAxNy41IDYyLjQzNyAxNy4xIDYzLjAzNyAxNy4xIEwgNjUuNTM3IDE3LjEgQyA3MC42MzcgMTcuMSA3My42MzcgMTQuNiA3NC40MzcgOS43IEMgNzQuNzM3IDcuNiA3NC40MzcgNS45IDczLjQzNyA0LjcgQyA3Mi4yMzcgMy41IDcwLjMzNyAyLjggNjcuNzM3IDIuOCBaIE0gNjguNjM3IDEwLjEgQyA2OC4yMzcgMTIuOSA2Ni4wMzcgMTIuOSA2NC4wMzcgMTIuOSBMIDYyLjgzNyAxMi45IEwgNjMuNjM3IDcuNyBDIDYzLjYzNyA3LjQgNjMuOTM3IDcuMiA2NC4yMzcgNy4yIEwgNjQuNzM3IDcuMiBDIDY2LjEzNyA3LjIgNjcuNDM3IDcuMiA2OC4xMzcgOCBDIDY4LjYzNyA4LjQgNjguNzM3IDkuMSA2OC42MzcgMTAuMSBaIj48L3BhdGg+PHBhdGggZmlsbD0iI2ZmZmZmZiIgZD0iTSA5MC45MzcgMTAgTCA4Ny4yMzcgMTAgQyA4Ni45MzcgMTAgODYuNjM3IDEwLjIgODYuNjM3IDEwLjUgTCA4Ni40MzcgMTEuNSBMIDg2LjEzNyAxMS4xIEMgODUuMzM3IDkuOSA4My41MzcgOS41IDgxLjczNyA5LjUgQyA3Ny42MzcgOS41IDc0LjEzNyAxMi42IDczLjQzNyAxNyBDIDczLjAzNyAxOS4yIDczLjUzNyAyMS4zIDc0LjgzNyAyMi43IEMgNzUuOTM3IDI0IDc3LjYzNyAyNC42IDc5LjUzNyAyNC42IEMgODIuODM3IDI0LjYgODQuNzM3IDIyLjUgODQuNzM3IDIyLjUgTCA4NC41MzcgMjMuNSBDIDg0LjQzNyAyMy45IDg0LjczNyAyNC4zIDg1LjEzNyAyNC4zIEwgODguNTM3IDI0LjMgQyA4OS4wMzcgMjQuMyA4OS41MzcgMjMuOSA4OS42MzcgMjMuNCBMIDkxLjYzNyAxMC42IEMgOTEuNjM3IDEwLjQgOTEuMzM3IDEwIDkwLjkzNyAxMCBaIE0gODUuNzM3IDE3LjIgQyA4NS4zMzcgMTkuMyA4My43MzcgMjAuOCA4MS41MzcgMjAuOCBDIDgwLjQzNyAyMC44IDc5LjYzNyAyMC41IDc5LjAzNyAxOS44IEMgNzguNDM3IDE5LjEgNzguMjM3IDE4LjIgNzguNDM3IDE3LjIgQyA3OC43MzcgMTUuMSA4MC41MzcgMTMuNiA4Mi42MzcgMTMuNiBDIDgzLjczNyAxMy42IDg0LjUzNyAxNCA4NS4xMzcgMTQuNiBDIDg1LjczNyAxNS4zIDg1LjkzNyAxNi4yIDg1LjczNyAxNy4yIFoiPjwvcGF0aD48cGF0aCBmaWxsPSIjZmZmZmZmIiBkPSJNIDk1LjMzNyAzLjMgTCA5Mi4xMzcgMjMuNiBDIDkyLjAzNyAyNCA5Mi4zMzcgMjQuMyA5Mi43MzcgMjQuMyBMIDk1LjkzNyAyNC4zIEMgOTYuNDM3IDI0LjMgOTYuOTM3IDIzLjkgOTcuMDM3IDIzLjQgTCAxMDAuMjM3IDMuNSBDIDEwMC4zMzcgMy4xIDEwMC4wMzcgMi44IDk5LjYzNyAyLjggTCA5Ni4wMzcgMi44IEMgOTUuNjM3IDIuOCA5NS40MzcgMyA5NS4zMzcgMy4zIFoiPjwvcGF0aD48L3N2Zz4"
                                                    data-v-b01da731="" alt="" role="presentation"
                                                    class="paypal-logo paypal-logo-paypal paypal-logo-color-white">
                                            </button>
                                        </a>
                                    </center> --}}

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
                    <div class="hljs-container">
                        <pre><code class="xml" data-url="assets/data/ui-modal-notification/code-1.json"></code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END #modal -->
    <div class="row">
        <div class="separator d-flex  my-4 col-md-12">
            <div style="width: 200px;">
                <h5>My Bank Cards</h5>
            </div>
            <div class="border-top w-100" style="margin-top: 12px;"></div>
        </div>
    </div>
    <div class="row">
        @if (count($otherCards) > 0)
            @foreach ($otherCards as $currentCard)
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-body d-flex py-5">
                            <div class="left w-75">
                                <p class="text-white fw-bold">{{ $currentCard->card_number }}</p>
                                <div class="d-flex just ify-content-start flex-column">
                                    <span class="text-gray fw-sm">Cardholder Name</span>
                                    <p class="my-2 text-white fw-bold">{{ $currentCard->name_on_card }}</p>
                                </div>
                                <div class="verification">
                                    @if ($currentCard->cvc)
                                        <span class="d-flex justify-content-start align-items-center"><img
                                                src="{{ asset('assets/img/check.png') }}" width="15px"
                                                class="img-responsive me-1" alt="">Verified</span>
                                    @endif
                                </div>
                            </div>
                            <div class="right text-right">
                                <img class="img-responsive mb-2" width="50px"
                                    src="{{ asset('assets/img/cards/' . $currentCard->brand_name . '.png') }}"
                                    alt="">
                                <div class="">
                                    <span class="text-gray fw-sm">Valid Till</span>
                                    <p class="my-2 text-white fw-bold">
                                        {{ $currentCard->expiration_month }}/{{ $currentCard->expiration_year }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                onclick="eachCardPayment('{{ $currentCard }}')" data-bs-target="#paymentModal"
                                id="eachCardPay"><i class="fa fa-plus me-1 fw-normal"></i>
                                Pay</button>
                        </div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        <x-myWallet.NewCard />
        @push('scripts')
            <script type="text/javascript">
                // Payment with another card
                const anotherCardBtn = document.querySelector('#anotherCard');
                const feilds = document.querySelectorAll('.cardFeild');
                const nameOnCard = document.querySelector('#name_on_card');
                const cardNumber = document.querySelector('#card-number');
                const cvc = document.querySelector('#cvc');
                const expireMonth = document.querySelector('#expire_month');
                const expireYear = document.querySelector('#expire_year');
                const amount = document.querySelector('#amount');
                const customErrorDiv = document.getElementById('custom-alert');
                const defaultBtn = document.querySelector('#defaultCard');

                const defaultPaymentor = (e, data) => {
                    const allData = JSON.parse(data);
                    e.style.display = 'none';
                    anotherCardBtn.style.display = 'inline-block';
                    nameOnCard.value = allData.name_on_card;
                    cardNumber.value = allData.card_number;
                    cvc.value = allData.cvc;
                    expireMonth.value = allData.expiration_month;
                    expireYear.value = allData.expiration_year;
                }

                anotherCardBtn.addEventListener('click', (e) => {
                    e.target.style.display = 'none';
                    defaultBtn.style.display = 'inline-block';
                    feilds.forEach(element => {
                        element.value = '';
                    });
                });


                const eachCardPayment = (data) => {
                    const realData = JSON.parse(data);
                    nameOnCard.value = realData.name_on_card;
                    cardNumber.value = realData.card_number;
                    cvc.value = realData.cvc;
                    expireMonth.value = realData.expiration_month;
                    expireYear.value = realData.expiration_year;
                }

                //  Auto Recharge Status
                const autoRechargeInput = document.getElementById('isAutoRechargeEnabled');
                const flag = document.getElementById('autoRechargeFlag');
                const userId = {{ auth()->id() }};
                const token = '{{ csrf_token() }}';

                autoRechargeInput.addEventListener('change', () => {
                    const newValue = autoRechargeInput.checked ? 1 : 0;
                    flag.textContent = newValue ? 'On' : 'Off';
                    if (newValue) {
                        flag.classList.remove('text-danger');
                        flag.classList.add('text-success');
                    } else {
                        flag.classList.remove('text-success');
                        flag.classList.add('text-danger');
                    }
                    sendRequest('auto-recharge-status', userId, newValue, token);
                });

                // auto recharge amount
                const rechargeRange = document.querySelector('#rechargeRange');
                const currentValue = document.querySelector('#selectedRange');
                currentValue.textContent = "$" + rechargeRange.value;
                rechargeRange.addEventListener('input', (e) => {
                    currentValue.textContent = '$' + e.target.value;
                });
                rechargeRange.addEventListener('change', () => {
                    sendRequest('auto-recharge-amount', userId, rechargeRange.value, token);
                });

                // Auto recharge balance level
                const selectedRangedisplayer = document.getElementById('selectedBalance');
                const autoRechargeBalance = document.getElementById('balanceRange');
                selectedRangedisplayer.textContent = "$" + autoRechargeBalance.value;
                autoRechargeBalance.addEventListener('input', (e) => {
                    selectedRangedisplayer.textContent = "$" + e.target.value;
                });
                autoRechargeBalance.addEventListener('change', () => {
                    sendRequest('auto-recharge-balance', userId, autoRechargeBalance.value, token);
                });

                // Actually Auto-recharge handling
                const selectedBalanceBorder = '{{ auth()->user()->threshould_amount }}';
                const balanceDisplayer = document.getElementById('balanceDisplayer');
                const currentBalance = $(balanceDisplayer).data('balance');
                const user = @json(auth()->user());
                const defaultCard = {!! $card ? $card->toJson() : '' !!};

                document.addEventListener("DOMContentLoaded", function() {
                    if (+currentBalance <= +selectedBalanceBorder && user.is_auto_recharge_enabled && defaultCard) {
                        fetch('/reseller-payment', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': token
                                },
                                body: JSON.stringify({
                                    card_number: defaultCard.card_number,
                                    amount: rechargeRange.value,
                                    user_id: defaultCard.user_id,
                                    auto_recharge: true,
                                })
                            }).then(response => response.json())
                            .then(data => {
                                customErrorDiv.textContent = data.message;
                                customErrorDiv.classList.remove('d-none');
                                data.success ? customErrorDiv.classList.add('alert-success') : customErrorDiv.classList
                                    .add('alert-danger');
                                if (data.success) {
                                    const total = +rechargeRange.value + currentBalance;
                                    balanceDisplayer.textContent = "$" + total;
                                }
                            })
                            .catch(error => {
                                customErrorDiv.textContent = error;
                                customErrorDiv.classList.remove('d-none');
                                customErrorDiv.classList.add('alert-danger');
                            });
                    }

                    $('#payment-form').submit(function(event) {
                        event.preventDefault();
                        $('#dismisser').hide();
                        showPaymentLoader();
                    });
                });

                function showPaymentLoader() {
                    $('#paymentLoader').show();
                }

                function hidePaymentLoader() {
                    $('#paymentLoader').hide();
                }
            </script>
        @endpush
    @endsection
