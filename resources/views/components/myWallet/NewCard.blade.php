<div class="col-lg-4 col-md-4 col-sm-12">
    <div class="card">
        <div class="card-body d-flex flex-column justify-conetent-between text-center py-5">
            <div class="images mb-1">
                @for ($var = 1; $var <= 5; $var++)
                    <img class="img-responsive mb-2" width="40px" src="{{ asset('assets/img/cards/Visa.png') }}"
                        alt="">
                @endfor
            </div>
            <div class="number mt-5">
                <h5>xxxxxxxxxxxxxxxxx</h5>
            </div>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newCardModal"><i
                    class="fa fa-plus me-1 fw-normal"></i> Add Card</button>
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

<div id="newCardModal" class="mb-5 p-4 modal fade" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card">
                <div class="card-header bg-transparent">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title">Add New Card</h5>
                        <div class="d-flex justify-content-end">
                            <div class="spinner-border" role="status" id="cardLoader" style="display: none;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <button type="button" class="btn-close" id="mydismisser" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="modal-body">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="panel panel-default credit-card-box p-5 pt-0">
                                    <div class="panel-heading display-table">
                                        <h4 class="panel-title text-center"><strong>Card Details</strong>
                                        </h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class='card-error alert-danger alert form-group d-none'>

                                        </div>
                                        <x-validationErrors />
                                        <form role="form" action="{{ route('reseller_card') }}" method="post"
                                            id="cardForm" data-key="{{ env('STRIPE_KEY') }}">
                                            @csrf

                                            <div class="form-row row cardRelated">
                                                <div class='col-xs-12 form-group required'>
                                                    <label class='control-label ' for="#name_on_card">Name on
                                                        Card</label>
                                                    <input class='form-control  ' name="name_on_card" id="name_on_card"
                                                        size='4' type='text'>
                                                </div>
                                            </div>

                                            <div class="form-row row cardRelated">
                                                <div class='col-xs-12 form-group card required'>
                                                    <label class='control-label' for="cardNumber">Card
                                                        Number</label>
                                                    <input autocomplete='off' name="card_number" id="cardNumber"
                                                        class='form-control cardFeild' size='20' type='text'>
                                                </div>
                                            </div>
                                            <div class="form-row row cardRelated">
                                                <div class='col-xs-12 col-md-4 form-group cvc required'>
                                                    <label class='control-label' for="cardCvc">CVC</label>
                                                    <input autocomplete='off' name="cvc" id="cardCvc"
                                                        class='form-control card-cvc cardFeild' placeholder='ex. 311'
                                                        size='4' type='text'>
                                                </div>
                                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                    <label class='control-label' for="expireMonth">Expiration
                                                        Month</label>
                                                    <input class='form-control card-expiry-month cardFeild'
                                                        name="expire_month" placeholder='MM' size='2'
                                                        type='text' id="expireMonth">
                                                </div>
                                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                    <label class='control-label' for="expireYear">Expiration
                                                        Year</label>
                                                    <input class='form-control card-expiry-year cardFeild'
                                                        name="expire_year" placeholder='YYYY' size='4'
                                                        type='text' id="expireYear">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <button class="btn mt-2 btn-primary btn-lg btn-block"
                                                        type="submit" name="formDefault">Add Card</button>

                                                </div>
                                            </div>

                                        </form>
                                    </div>
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
                <div class="hljs-container">
                    <pre><code class="xml" data-url="assets/data/ui-modal-notification/code-1.json"></code></pre>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function showPaymentLoader() {
            $('#cardLoader').show();
        }

        function hidePaymentLoader() {
            $('#cardLoader').hide();
        }

        const form = document.querySelector('#cardForm');
        var stripeToken;
        document.addEventListener('DOMContentLoaded', function() {

            form.addEventListener('submit', async function(event) {
                event.preventDefault();
                $('#mydismisser').hide();
                $('#cardLoader').show();

                Stripe.setPublishableKey(form.dataset.key);

                const card = {
                    number: $('#cardNumber').val(),
                    exp_month: $('#expireMonth').val(),
                    exp_year: $('#expireYear').val(),
                    cvc: $('#cardCvc').val()
                };

                const container = $('.card-error');

                Stripe.createToken(card, async (status, response) => {

                    if (response.error) {
                        document.getElementById('cardLoader').style.display = 'none';
                        document.getElementById('mydismisser').style.display = 'block';
                        const ul = document.createElement('ul');
                        let li = document.createElement('li');
                        li.textContent = response.error.message;
                        ul.appendChild(li);
                        container.empty().append(ul);
                        $('.card-error')
                            .removeClass('d-none')
                            .find('.alert');
                    } else {
                        stripeToken = response.id;
                        const formData = new FormData(form);
                        formData.append('stripeToken', stripeToken);
                        const ourResponse = await fetch('{{ route('reseller_card') }}', {
                            method: 'POST',
                            body: formData
                        });
                        const data = await ourResponse.json();
                        if (data.status === 200) {
                            location.href = data.redirectURL;
                        } else {
                            document.getElementById('cardLoader').style.display = 'none';
                            document.getElementById('mydismisser').style.display = 'block';
                            const ul = document.createElement('ul');
                            for (let i = 0; i < data.errors.length; i++) {
                                let li = document.createElement('li');
                                li.textContent = data.errors[i];
                                ul.appendChild(li);
                                container.empty().append(ul);
                            }
                            $('.card-error')
                                .removeClass('d-none')
                                .find('.alert');
                        }
                    }
                });
            });
        });
    </script>
@endpush
