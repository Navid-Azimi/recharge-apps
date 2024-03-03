function set_network_packages(networkID, selector, logoPath) {
    $.ajax({
        url: "/get_network_packages",
        method: 'GET',
        data: {
            ntw_id: networkID,
        },
        dataType: 'json',
        success: function (response) {
            data = response.packages;
            const network = response.relatedNetwork;
            var selectElement = $('#' + selector);
            selectElement.empty();
            if (data && data.length > 0) {
                for (var i = 0; i < data.length; i++) {

                    const package = `<div class="col-md-4 col-sm-12 col-12 my-2" style="cursor: pointer;">
                    <div class="card px-2 modalOpener" data-bs-toggle="modal" data-bs-target="#formHandlerModal" data-package-amount="${data[i].pck_price}" data-pck-country="${data[i].pck_country}" data-pck-currency="${data[i].pck_currency_id}"  data-package-id="${data[i].id}"  data-operator="${network.ntw_name}" data-iso="${network.ntw_country_iso}" data-interior="${data[i].interior_charges}" data-outdoor="${data[i].outdoor_charges}">
                <div class="card-header bg-transparent fw-bold small d-flex gap-2 justify-content-start align-items-center">
                    <img  class="me-2" width="70" height="auto" id="networkLogo" src="${logoPath}/${network.ntw_logo}" alt="${network.ntw_name} logo" />
                    <div class="d-flex flex-wrap gap-3"><span>${network.ntw_name}</span><p class="m-0" >${data[i].pck_price} ${data[i].pck_currency_id}</p></div>
                </div>
                <div class="card-body text-center d-flex justify-content-between flex-column  pt-3 pb-2">
                    <p class="text-start">Instant delivery to email</p>
                    <ul class="content text-start mb-0 ms-1 ps-1 ">
                    <li>${data[i].pck_data_amount ? data[i].pck_data_amount : '0'} data</li>
                        <li>${data[i].pck_sms_amount ? data[i].pck_sms_amount : '0'} SMS</li>
                        <li>${data[i].pck_minutes_amount ? data[i].pck_minutes_amount : '0'} Minutes</li>
                     <li>${data[i].pck_credit_amount ? data[i].pck_credit_amount : '0'} Credit</li>
                         <li>${data[i].general_comm ? data[i].general_comm : '0'} Commissions</li>
                    </ul>
                    <hr>
                    <div class="text-start">
                        <p>${data[i].pck_price} ${data[i].pck_currency_id}</p>
                     </div>
                </div>
                <div class="card-arrow">
                    <div class="card-arrow-top-left"></div>
                    <div class="card-arrow-top-right"></div>
                    <div class="card-arrow-bottom-left"></div>
                    <div class="card-arrow-bottom-right"></div>
                </div>
            </div>
                    </div>`;
                    selectElement.append(package);
                }
            } else {
                selectElement.append('<h4 class="text-center w-100">No package available</h4>');
            }

        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}


$(function () {
    var $form = $(".require-validation");

    $('form.require-validation').bind('submit', function (e) {
        var $form = $(".require-validation"),
            inputSelector = ['input[type=email]', 'input[type=password]',
                'input[type=text]', 'input[type=file]',
                'textarea'
            ].join(', '),
            $inputs = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid = true;
        $errorMessage.addClass('d-none');

        $('.has-error').removeClass('has-error');
        $inputs.each(function (i, el) {
            var $input = $(el);

            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('d-none');
                e.preventDefault();
            }
        });

        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('#card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }

    });

    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('d-none')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];

            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
});

const sendRequest = (path, userId, data, token) => {
    fetch(`/${path}/${userId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            value: data
        })
    });
}
async function getUserCountryByIP() {
    try {
        const response = await fetch('https://ipapi.co/json/');
        const data = await response.json();
        return data.country_name;
    } catch (error) {
        console.error('Error fetching IP information:', error);
    }
}

function getTaxRate(countryCode) {
    return fetch(`/get-tax/${countryCode}`)
        .then(response => response.json())
        .then(data => {
            return data;
        })
        .catch(error => {
            console.error('Error fetching tax rate:', error);
            return { tax: 0, rate: 1 };
        });
}

function getExchangeRates() {
    return fetch("/get-exchange-rates")
        .then(response => response.json())
        .then(data => {
            return data;
        })
        .catch(error => {
            console.error('Error fetching tax rate:', error);
            return { tax: 0, rate: 1 };
        });
}

// selected package calculatoin scripts
$(document).ready(function () {

    function showLoader() {
        $('#modalLoader').show();
        $('#modalDetails').hide();
    }

    // Function to hide loader and display details
    function hideLoader() {
        $('#modalLoader').hide();
        $('#modalDetails').show();
    }

    const modal = $('#formHandlerModal');
    const modalPhone = $('#current_phone');
    const modalOperator = $('#current_operator');
    const modalAmount = $('#current_amount');
    const modalAit = $('#current_ait');
    const modalFee = $('#topup_fee');
    const modalReceived = $('#current_received');
    let countryTax;
    let userCountry;

    // Function to get the API online exchange rate for USD 
    async function getUSDExchangeRate(pckUnit) {
        try {
            const exchangeRateApiResponse = await fetch('https://api.exchangerate-api.com/v4/latest/USD');
            const exchangeRateData = await exchangeRateApiResponse.json();
            return exchangeRateData.rates[pckUnit];
        } catch (error) {
            console.error('Error fetching USD exchange rate:', error);
            throw error; // Re-throw the error to handle it outside
        }
    }

    $(document).on('click', '.modalOpener', async function () {
        showLoader();

        try {
            countryTax = await getTaxRate($(this).data('iso'));
            const usdExchangeRate = await getUSDExchangeRate($(this).data('pck-currency'));
            userCountry = await getUserCountryByIP();
            hideLoader();
            // alert('Current Exchange Rate: ' + usdExchangeRate);
            const pckUnit = $(this).data('pck-currency');
            const amount = +$(this).data('package-amount') > 0 ? $(this).data('package-amount') : '0';
            const amountUSD = amount / usdExchangeRate; // Amount in USD
            const pckCountry = $(this).data('pck-country');
            const interior = $(this).data('interior') || 0;
            const outdoor = $(this).data('outdoor') || 0;
            const exchangeRate = usdExchangeRate || 0;

            const adjustedRate = exchangeRate * 0.98;
            const todayDollarCurrent = exchangeRate;
            const interiorCharge = pckCountry === userCountry ? interior / adjustedRate : outdoor / todayDollarCurrent;
            const topupFeeUSD = interiorCharge;

            const taxValue = countryTax ? +(amount / 100 * (+countryTax)) : 0;
            const totalfees = taxValue;
            const totalReceive = amount > totalfees ? amount - totalfees : 'Amount is less than AIT amount!';
            const totalReceiveUSD = totalReceive / exchangeRate;

            modalReceived.html('<span style="color: #798e98;">They receive: <span style="color: #dce2e4;">' + totalReceive.toFixed(2) + " " + pckUnit + '</span><br><hr>');
            modalReceived.append('<span style="line-height: 1.7; color: #798e98;">Topup-fee: </span><span style="line-height: 1.7; color: #dce2e4;">' + topupFeeUSD.toFixed(2) + ' USD</span><br>');
            modalReceived.append('<span style="line-height: 1.7; color: #798e98;">Your-Subtotal: </span><span style="line-height: 1.7; color: #dce2e4;">' + amountUSD.toFixed(2) + ' USD</span><br>');
            modalReceived.append('<span style="line-height: 1.7; color: #798e98;">Your Total: </span><span style="line-height: 1.7; color: #3cd2a5;">' + (parseFloat(topupFeeUSD.toFixed(2)) + parseFloat(amountUSD.toFixed(2))).toFixed(2) + ' USD</span><br>');
            

            // Update other modal fields
            modal.attr('package_id', $(this).data('package-id'));
            modal.attr('package_amount', amount);
            modal.attr('country_tax', taxValue);

            modalPhone.html('<span style="color: #798e98;">Number: <span style="color: #dce2e4;">' + $('#phone-number').val() + '<br>');
            modalOperator.html('<span style="color: #798e98;">Operator: <span style="color: #dce2e4;">' + $(this).data('operator') + '<br>');
            modalAmount.html('<span style="color: #798e98;">You\'re sending: <span style="color: #dce2e4;">' + amount + '<br>');
            modalAit.html('<span style="color: #798e98;">Country Taxes (AIT): <span style="color: #dce2e4;">' + '-' + taxValue + ' ' + pckUnit + '<br>');
        } catch (error) {
            hideLoader();
            console.error('Error fetching data:', error);
        }
    });
});

const flatPickerDate = (selector, icon, min = null) => {
    const dateInput = document.getElementById(selector);
    const config = {
        theme: "dark-theme",
        clickOpens: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    };

    if (min) {
        config.minDate = min;
    }

    flatpickr("#" + selector, config);

    document.getElementById(icon).addEventListener("click", () => {
        dateInput._flatpickr.toggle();
    });
}


const optionGenerator = (parent, text, value = "") => {
    const newOption = document.createElement('option');
    newOption.value = value;
    newOption.textContent = text;
    parent.appendChild(newOption);
}

const fetchUsersForPackages = (userRole, usersList) => {
    userRole.addEventListener('change', async function () {
        const selectedRole = userRole.value;

        try {
            let endpoint = `/users-by-role/${selectedRole}`;

            if (selectedRole === '') {
                endpoint = '/all-users';
            }
            const response = await fetch(endpoint);

            if (!response.ok) {
                throw new Error('Failed to fetch data');
            }

            const data = await response.json();

            usersList.innerHTML = '';
            optionGenerator(usersList, "SELECT USER");
            optionGenerator(usersList, "ALL");

            if (data.users.length > 0) {
                data.users.forEach(user => {
                    optionGenerator(usersList, user.name, user.id);
                });
            }
        } catch (error) {
            console.error('An error occurred:', error);
        }
    });
}

const getNetworksForSelectedCountry = (countriesDropdown, networksList, isForFilter = false) => {
    countriesDropdown.addEventListener('change', async function () {
        const selectedOption = countriesDropdown.options[countriesDropdown.selectedIndex];
        const isoCode = selectedOption.getAttribute('data-iso');

        try {
            let endpoint = `/networks-by-iso/${isoCode}`;

            if (isoCode === '' || selectedOption.textContent.includes('All')) {
                endpoint = '/all-networks';
            }
            const response = await fetch(endpoint);

            if (!response.ok) {
                throw new Error('Failed to fetch data');
            }

            const data = await response.json();

            networksList.innerHTML = '';

            optionGenerator(networksList, "SELECT OPERATOR");

            if (data.networks.length > 1 && !isForFilter) {
                optionGenerator(networksList, "All");
            } else {
                optionGenerator(networksList, "All", "all");
            }

            if (data.networks.length > 0) {
                data.networks.forEach(network => {
                    optionGenerator(networksList, network.ntw_name, network.id);
                });
            } else {
                networksList.innerHTML = '';
                optionGenerator(networksList, 'NO OPERATOR');
            }
        } catch (error) {
            console.error('An error occurred:', error);
        }
    });
}


const getMultiSelect = (selector) => {
    $('#' + selector).selectize({
        maxItems: null,
        valueField: 'id',
        labelField: 'title',
        searchField: 'title',
        create: false
    });
}



function updateUsersList(selectizeInstance, usersData) {
    selectizeInstance.clearOptions();

    selectizeInstance.addOption({
        id: "all",
        title: "ALL"
    });

    for (var i = 0; i < usersData.length; i++) {
        selectizeInstance.addOption({
            id: usersData[i].id,
            title: usersData[i].name
        });
    }
    selectizeInstance.refreshOptions();
}

const inputAppender = (name, value, id, parent) => {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.value = value;
    input.name = name;
    input.setAttribute('id', id);
    parent.appendChild(input);
}

// Delete after confirmation
const deleteWithModalConfirmation = (deleteButtonSelector, modalSelector, modalDeleteButtonSelector, formSelector, item) => {
    let deleteItemId = null;
    const deleteButtons = document.querySelectorAll('.' + deleteButtonSelector);
    const modal = document.querySelector(modalSelector);

    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            deleteItemId = button.getAttribute('data-' + item + '-id');
            modal.querySelector('.mybody').innerHTML = `
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class=" btn btn-danger" id="${modalDeleteButtonSelector}" data-bs-dismiss="modal">Delete</button>`;
            modal.querySelector(`#${modalDeleteButtonSelector}`).addEventListener('click', function () {
                if (deleteItemId !== null) {
                    const formId = formSelector + deleteItemId;
                    document.getElementById(formId).submit();
                }
            });
        });
    });
};

// Messenger UI configuration
document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.messenger').closest('.app-content').style.padding = '0 0 0 2rem';
});

// loader animkation script 
$(document).ready(function () {
    // Submit form function
    $('.submtting_pack').on('click', function () {
        // Show loader overlay
        $('#loader-overlay').show();

        // Show loader
        $('#loader').show();

        // Apply gradient text effect with faster animation
        $('#loading-text').addClass('fast-animated-gradient');

        // Submit the form
        $('form').submit();
    });
});


// if reseller-user set custom value then do bellow 
document.addEventListener('DOMContentLoaded', function () {
    const topAmountInput = document.getElementById('top_amount');
    const formSubmitButton = document.getElementById('formMainSubmit');
    const resultDiv = document.getElementById('resultDiv');

    topAmountInput.addEventListener('input', function () {
        const enteredAmount = parseFloat(topAmountInput.value);

        if (!isNaN(enteredAmount)) {
            formSubmitButton.removeAttribute('disabled');
            let countryTaxPercentage = 0.1; // Default country tax percentage
            let countryCurrencySymbol = ''; // Default currency symbol

            // Check if the user is from Turkey and update the tax percentage and currency symbol
            if (currentUserCountry === 'Turkey') {
                countryTaxPercentage = 0.00;
                countryCurrencySymbol = '₺';
            }

            // Check if the user is from Afghanistan and update the tax percentage and currency symbol
            if (currentUserCountry === 'Afghanistan') {
                countryTaxPercentage = 0.10;
                countryCurrencySymbol = 'AF';
            }

            const systemFeeAmount = 0.02 * enteredAmount;
            const receivedCredit = enteredAmount - systemFeeAmount;
            const feeinput = document.createElement('input');
            feeinput.setAttribute('type', 'hidden');
            feeinput.setAttribute('name', 'topup_fee');
            feeinput.setAttribute('value', systemFeeAmount);
            const form = document.getElementById('multi-step-form');
            form.appendChild(feeinput);
            // Display the result in the result div with styling
            resultDiv.innerHTML = `
            <div class="col-xl-6 col-xl-12">
                <div class="card border-theme bg-theme bg-opacity-25 mb-3">
                    <div class="card-header">
                        <h6 class="border-theme text-theme"><i class="bi bi-check2-circle fa-3x custom-amounticon"></i> <span class="custom-amount-tittle">Submit to confirm request!</span> </h6>
                    </div>
                    <div class="card-body custom-input-content h5 lh-lg">
                        <strong>SELECTED AMOUNT:</strong> ${enteredAmount.toFixed(2)} ${countryCurrencySymbol}<br>
                         <strong>System Fee:</strong> ${systemFeeAmount.toFixed(2)} ${countryCurrencySymbol}<br>
                        <strong>RECEIVED CREDIT:</strong> ${receivedCredit.toFixed(2)} ${countryCurrencySymbol}    
                     </div>
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                </div>
            </div>`;
        } else {
            resultDiv.innerHTML = '';
            formSubmitButton.setAttribute('disabled');
        }
    });
});
// End of if reseller-user set custom value then do bellow