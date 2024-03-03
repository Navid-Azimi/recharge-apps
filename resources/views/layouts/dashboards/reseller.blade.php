@extends('layouts.app')
@section('content')
    @inject('httpClient', 'GuzzleHttp\Client')

    @php
        $balance = $balance ?? null;
        $currentUserCountry = auth()->user()->user_country;
    @endphp
    <script>
        var currentUserCountry = @json(auth()->user()->user_country);
    </script>

    <div id="app" class="app pt-0">
        <x-messages />
        <div id="wizardLayout3" class="mb-1">
            <div class="card">
                @if ($announcements->count() > 0)
                    @foreach ($announcements as $announcement)
                        @php
                            $words = explode(' ', $announcement->text);
                        @endphp
                        @if (count($words) > 7)
                            <div class="p-2">
                                <div class="marquee-container">
                                    <div class="marquee-content">
                                        @if ($announcement->ann_logo)
                                            <div class="d-flex align-items-center justify-content-center">
                                                <img class="img-responsive" width="50" height="50"
                                                    src="{{ asset('/storage/uploads/' . $announcement->ann_logo) }}"
                                                    alt="announcement logo">
                                            </div>
                                        @endif
                                        <div class="ms-3 mt-3">
                                            <h3>{!! $announcement->text !!}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="d-flex align-items-center p-2">
                                @if ($announcement->ann_logo)
                                    <div
                                        class="w-50px h-50px bg-inverse bg-opacity-25 d-flex align-items-center justify-content-center">
                                        <img class="mw-100 mh-100"
                                            src="{{ asset('/storage/uploads/' . $announcement->ann_logo) }}"
                                            alt="announcement logo">
                                    </div>
                                @endif
                                <div class="ms-3 mt-3">
                                    <h3>{!! $announcement->text !!}</h3>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
                <div class="card-body flex-grow-1 flex-shrink-1 pt-1">
                    <!-- ======== multi step form =========  -->
                    <div class="row multistep-form">
                        <div class="col-xl-10 m-auto" id="form-container">
                            <form
                                class="multisp_form d-flex justify-content-center flex-column align-items-center mb-0 pb-0 pt-3"
                                action="{{ route('topup') }}" method="post" id="multi-step-form">
                                @csrf
                                <!-- nav cercle 4step  -->
                                <div class="nav-wizards-container w-100">
                                    <nav class="nav nav-wizards-1" id="progress">
                                        <div class="nav-item col">
                                            <a class="nav-link step active" href="#">
                                                <div class="nav-no">1</div>
                                                <div class="nav-text">Set Phone Number</div>
                                            </a>
                                        </div>
                                        <div class="nav-item col step">
                                            <a class="nav-link step" href="#">
                                                <div class="nav-no">2</div>
                                                <div class="nav-text">Select Package</div>
                                            </a>
                                        </div>
                                    </nav>
                                </div>
                                <!-- nav cercle 4step  -->
                                <div class="w-100 d-flex justify-content-center pt-3">
                                    <!-- ----------------------- Step 1 ADD PHONE -->
                                    <div class="form-step active">
                                        <table class="table mx-auto mb-0">
                                            <thead>
                                                <tr>
                                                    @php
                                                        $fileContent = file_get_contents(public_path('data/countries.json'));

                                                        if ($fileContent !== false) {
                                                            $countryCollection = json_decode($fileContent, true);
                                                            usort($countryCollection, function ($a, $b) {
                                                                return strcasecmp($a['name']['common'], $b['name']['common']);
                                                            });
                                                        }
                                                    @endphp
                                                    <th class="p-0">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-fill ps-2">
                                                                <div class="position-relative d-flex align-items-center">
                                                                    <input type="text" id="phone-number"
                                                                        class="my_custom_country_flag form-control rounded-2 bg-white bg-opacity-15"
                                                                        placeholder="Enter your phone" name="phone">
                                                                    <!-- -------------------- foreach --------- -->
                                                                    <div id="country-list-container" class="country-list">
                                                                        <ul id="country-list" class="m-0 p-0">
                                                                            @foreach ($countryCollection as $country)
                                                                                <li
                                                                                    data-country-code="{{ $country['cca2'] }}">
                                                                                    <div
                                                                                        class="d-flex justify-content-between w-100">
                                                                                        <div>
                                                                                            <img src="{{ $country['flags']['png'] }}"
                                                                                                alt="{{ $country['name']['common'] }} Flag"
                                                                                                height="28"
                                                                                                width="34"
                                                                                                class="country-flag rounded-2">
                                                                                            <strong>{{ $country['name']['common'] }}</strong>
                                                                                        </div>
                                                                                        <span>{{ $country['idd']['root'] ?? 'N/A' }}{{ $country['idd']['suffixes'][0] ?? 'N/A' }}</span>

                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                    <!-- -------------------- foreach --------- -->
                                                                    <div id="search-results" class="position-absolute">
                                                                        <a href="#"><i id="mycaret-globe"
                                                                                class="my_caret_globe fa fa-globe fa-spin"></i></a>
                                                                        <myflag id="mycaret-flag" style="font-size: 2rem;">
                                                                        </myflag>
                                                                        <a href="#"><i id="mycaret-down"
                                                                                class="my_caret_down fas fa-lg fa-fw me-2 fa-caret-down"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div class="card-body mobile_button">
                                            <button id="next-1" class="btn btn-theme btn-lg mb-1" disabled>Start
                                                Topup</button>
                                            <br>
                                        </div>
                                        <!-- ----------------------- Step 1 ADD PHONE -->
                                    </div>
                                    <!-- ----------------------- Step 2 ADD PACKAGE -->
                                    <div class="form-step beautiful-box w-100">
                                        <table class="table mx-auto">
                                            <thead>
                                                <tr class=" d-flex justify-content-between gap-4">
                                                    <th class="w-100 p-0">
                                                        <div class="card px-2">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="row">
                                                                        <div class="col-md-6 p-1 col-sm-6">
                                                                            <select class="form-select mt-2 form-select-lg"
                                                                                name="top_networks_id" id="top_networks_id">
                                                                                <option value="">Change Operator
                                                                                </option>
                                                                                @foreach ($networks as $operator)
                                                                                    <option value="{{ $operator->id }}"
                                                                                        data-logo="{{ $operator->ntw_logo }}"
                                                                                        data-commission="{{ $operator->commission }}">
                                                                                        {{ $operator->ntw_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6 p-1 col-sm-12">
                                                                            <input type="number"
                                                                                class="form-control mt-2 py-2"
                                                                                id="top_amount" name="top_amount"
                                                                                placeholder="Topup amount">
                                                                        </div>

                                                                        <div id="resultDiv" class="p-0 mt-3"></div>
                                                                        <div class="col-md-6 p-1 col-sm-12">
                                                                            <button id="formMainSubmit" type="submit"
                                                                                class="submtting_pack ms-1 mt-2 py-2 btn btn-success btn-lg"
                                                                                disabled>Submit</button>
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
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div class="card">
                                            <div
                                                class="card-header bg-transparent fw-bold small d-flex justify-content-center align-items-center">
                                                <h4 class="flex-grow-1 text-center mt-2">All Packages</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row" id="top_pac_id">
                                                </div>
                                            </div>
                                            <div class="card-arrow">
                                                <div class="card-arrow-top-left"></div>
                                                <div class="card-arrow-top-right"></div>
                                                <div class="card-arrow-bottom-left"></div>
                                                <div class="card-arrow-bottom-right"></div>
                                            </div>
                                        </div>
                                        <div class="card-body pb-2 mobile_button">
                                            <button id="prev-3" class="btn btn-secondary btn-lg">Previous</button>
                                            <br>
                                        </div>
                                    </div>
                                    <!-- ----------------------- Step 2 ADD PACKAGE -->
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- ======== multi step form =========  -->
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
    <!-- END #app -->
    <div class="row">
        <div class="col-lg-12">
            <!-- BEGIN #tableHeadOptions -->
            <div id="tableHeadOptions" class="mb-3">
                <x-topup-list route="reseller_dashboard" :topups="$topups" :operators="$operators" :countries="$countries" />
            </div>
            <!-- END #tableHeadOptions -->
        </div>
    </div>
    {{-- form submition handler modal --}}

    <div id="formHandlerModal" class="mb-5 p-2 modal fade" tabindex="-1"
        aria-labelledby="exampleModalLabel"aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="modal-header border-bottom-0 p-0">
                            <h5 class="modal-title w-100">
                                <div
                                    class="content w-100 text-center d-flex flex-column justify-content-center align-items-center">
                                    <h1 class="display-4"><i class="fa-solid text-success fa-circle-check"></i>
                                    </h1>
                                    <h3>Please confirm your request</h3>
                                </div>
                            </h5>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="modal-body">
                            <div class="d-flex justify-content-center"   >
                                <div class="spinner-border" role="status" style="display: none;" id="modalLoader">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <div class="panel panel-default" id="modalDetails" style="text-align: left;">
                                <div class="panel-body">
                                    <div class='validation-error alert-danger alert form-group d-none'>
                                    </div>
                                    <x-validationErrors />
                                    <div>
                                        <h5 class="d-inline-block" id="current_phone"></h5>
                                    </div>
                                    <div>
                                        <h5 class="d-inline-block" id="current_operator"></h5>
                                    </div>
                                    <div>
                                        <h5 class="d-inline-block" id="current_amount"></h5>
                                    </div>
                                    <div>
                                        <h5 class="d-inline-block" id="current_ait"></h5>
                                    </div>
                                    <div>
                                        <h5 class="d-inline-block" id="topup_fee"></h5>
                                    </div>
                                    <div>
                                        <h5 class="d-inline-block" id="current_received"></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-transparent d-flex justify-content-around">
                            <button type="button" class="btn btn-outline-default"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-outline-theme" id="packageFormConfirm">Confirm</button>
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
    <!--  multi step form script  -->
    <script>
        const form = document.querySelector('#multi-step-form');
        const progress = document.querySelectorAll('.nav-item');
        const steps = document.querySelectorAll('.form-step');
        const prevBtns = document.querySelectorAll('button[id^="prev"]');
        const nextBtns = document.querySelectorAll('button[id^="next"]');
        let currentStep = 0;

        // Next button event listeners
        nextBtns.forEach((btn, i) => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                steps[currentStep].classList.remove('active');
                progress[currentStep].querySelector('.nav-link').classList.remove('active');
                currentStep++;
                steps[currentStep].classList.add('active');
                progress[currentStep].querySelector('.nav-link').classList.add('active');
            });
        });

        // Previous button event listeners
        prevBtns.forEach((btn, i) => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                steps[currentStep].classList.remove('active');
                progress[currentStep].querySelector('.nav-link').classList.remove('active');
                currentStep--;
                steps[currentStep].classList.add('active');
                progress[currentStep].querySelector('.nav-link').classList.add('active');
            });
        });

        // topup form handler
        const submitButton = document.getElementById('packageFormConfirm');
        const container = $('.validation-error');

        submitButton.addEventListener('click', async function(event) {
            event.preventDefault();
            const phoneNumber = $('#phone-number').val();
            const packageId = $('#formHandlerModal').attr('package_id');
            const topAmount = $('#formHandlerModal').attr('package_amount');
            const countryTax = $('#formHandlerModal').attr('country_tax');
            const currency = $('#formHandlerModal').attr('package_unit');
            const topupFee = $('#formHandlerModal').attr('topup_fee');
            const countryIso = $('#country_iso').val();

            const data = {
                phone: phoneNumber,
                country_tax: countryTax,
                topup_fee: topupFee,
                top_pac_id: +packageId,
                top_amount: topAmount,
                country_iso: countryIso,
            }
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const currentResponse = await fetch('/reseller-topup', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(data),
                });

                const topupResponse = await currentResponse.json();

                if (topupResponse.success) {
                    location.reload();
                    window.scrollTo(0, 0);
                } else {
                    const ul = document.createElement('ul');
                    for (let i = 0; i < topupResponse.errors.length; i++) {
                        let li = document.createElement('li');
                        li.textContent = topupResponse.errors[i];
                        ul.appendChild(li);
                        container.empty().append(ul);
                    }
                    $('.validation-error')
                        .removeClass('d-none')
                        .find('.alert');
                }
            } catch (error) {
                container.empty().text(error.message);
                $('.validation-error')
                    .removeClass('d-none')
                    .find('.alert');
            }
        });

        // topup dropdown input related js 

        $(document).ready(function() {
            var countryCodes = {
                'AF': '+93', // Afghanistan
                'PF': '+689', // French Polynesia
                'AL': '+355', // Albania
                'DZ': '+213', // Algeria
                'MF': '+590', // Saint Martin
                'AD': '+376', // Andorra
                'TM': '+993', // Turkmenistan
                'AO': '+244', // Angola
                'AG': '+1-268', // Antigua and Barbuda
                'AR': '+54', // Argentina
                'AM': '+374', // Armenia
                'AU': '+61', // Australia
                'AT': '+43', // Austria
                'AZ': '+994', // Azerbaijan
                'BS': '+1-242', // Bahamas
                'BH': '+973', // Bahrain
                'BD': '+880', // Bangladesh
                'BB': '+1-246', // Barbados
                'BY': '+375', // Belarus
                'BE': '+32', // Belgium
                'BZ': '+501', // Belize
                'BJ': '+229', // Benin
                'BT': '+975', // Bhutan
                'BO': '+591', // Bolivia
                'BA': '+387', // Bosnia and Herzegovina
                'BW': '+267', // Botswana
                'BR': '+55', // Brazil
                'BN': '+673', // Brunei
                'BG': '+359', // Bulgaria
                'BF': '+226', // Burkina Faso
                'BI': '+257', // Burundi
                'CV': '+238', // Cabo Verde
                'KH': '+855', // Cambodia
                'CM': '+237', // Cameroon
                'CA': '+1', // Canada
                'CF': '+236', // Central African Republic
                'TD': '+235', // Chad
                'CL': '+56', // Chile
                'CN': '+86', // China
                'CO': '+57', // Colombia
                'KM': '+269', // Comoros
                'CG': '+242', // Congo
                'CR': '+506', // Costa Rica
                'CI': '+225', // Cote d'Ivoire
                'HR': '+385', // Croatia
                'CY': '+357', // Cyprus
                'CZ': '+420', // Czechia
                'CD': '+243', // Democratic Republic of the Congo
                'DK': '+45', // Denmark
                'DJ': '+253', // Djibouti
                'DM': '+1-767', // Dominica
                'DO': '+1-809, 1-829, 1-849', // Dominican Republic
                'EC': '+593', // Ecuador
                'EG': '+20', // Egypt
                'SV': '+503', // El Salvador
                'GQ': '+240', // Equatorial Guinea
                'ER': '+291', // Eritrea
                'EE': '+372', // Estonia
                'SZ': '+268', // Eswatini
                'ET': '+251', // Ethiopia
                'FJ': '+679', // Fiji
                'FI': '+358', // Finland
                'FR': '+33', // France
                'GA': '+241', // Gabon
                'GM': '+220', // Gambia
                'GE': '+995', // Georgia
                'DE': '+49', // Germany
                'GH': '+233', // Ghana
                'GR': '+30', // Greece
                'GD': '+1-473', // Grenada
                'GT': '+502', // Guatemala
                'GN': '+224', // Guinea
                'GW': '+245', // Guinea-Bissau
                'GY': '+592', // Guyana
                'HT': '+509', // Haiti
                'HN': '+504', // Honduras
                'HU': '+36', // Hungary
                'IS': '+354', // Iceland
                'IN': '+91', // India
                'ID': '+62', // Indonesia
                'IQ': '+964', // Iraq
                'IE': '+353', // Ireland
                'IL': '+972', // Israel
                'IT': '+39', // Italy
                'JM': '+1-876', // Jamaica
                'JP': '+81', // Japan
                'JO': '+962', // Jordan
                'KZ': '+7', // Kazakhstan
                'KE': '+254', // Kenya
                'KI': '+686', // Kiribati
                'KR': '+82', // Korea, South
                'XK': '+383', // Kosovo
                'KW': '+965', // Kuwait
                'KG': '+996', // Kyrgyzstan
                'LA': '+856', // Laos
                'LV': '+371', // Latvia
                'LB': '+961', // Lebanon
                'LS': '+266', // Lesotho
                'LR': '+231', // Liberia
                'LY': '+218', // Libya
                'LI': '+423', // Liechtenstein
                'LT': '+370', // Lithuania
                'LU': '+352', // Luxembourg
                'MG': '+261', // Madagascar
                'MW': '+265', // Malawi
                'MY': '+60', // Malaysia
                'MV': '+960', // Maldives
                'ML': '+223', // Mali
                'MT': '+356', // Malta
                'MH': '+692', // Marshall Islands
                'MR': '+222', // Mauritania
                'MU': '+230', // Mauritius
                'MX': '+52', // Mexico
                'FM': '+691', // Micronesia
                'MD': '+373', // Moldova
                'MC': '+377', // Monaco
                'MN': '+976', // Mongolia
                'ME': '+382', // Montenegro
                'MA': '+212', // Morocco
                'MZ': '+258', // Mozambique
                'MM': '+95', // Myanmar
                'NA': '+264', // Namibia
                'NR': '+674', // Nauru
                'NP': '+977', // Nepal
                'NL': '+31', // Netherlands
                'NZ': '+64', // New Zealand
                'NI': '+505', // Nicaragua
                'NE': '+227', // Niger
                'NG': '+234', // Nigeria
                'MK': '+389', // North Macedonia
                'NO': '+47', // Norway
                'OM': '+968', // Oman
                'PK': '+92', // Pakistan
                'PW': '+680', // Palau
                'PS': '+970', // Palestine
                'PA': '+507', // Panama
                'PG': '+675', // Papua New Guinea
                'PY': '+595', // Paraguay
                'PE': '+51', // Peru
                'PH': '+63', // Philippines
                'IR': '+98', // Iran
                'ZA': '+27', // South Africa
                'TR': '+90', // Turkey
                'SS': '+211', // Soudan
                'GF': '+33', // French Guiana
                'RW': '+250', // Rwanda
                'SA': '+966', // Saudi Arabia
                'TL': '+670', // Timor-Leste
                'SD': '+249', // Sudan
                'AX': '+354', // Åland Islands
                'VC': '+1-869', // Saint Vincent
                'EH': '+212', // Western Sahara
                'FK': '+500', // Falkland Islands
                'VU': '+678', // Vanuatu
                'TK': '+690', // Tokelau
                'SC': '+248', // Seychelles
                'NU': '+683', // Niue
                'CK': '+682', // Cook Islands
                'US': '+1', // United States
                'GI': '+350', // Gibraltar
                'RE': '+262', // Réunion
                'VE': '+58', // Venezuela
                'MP': '+692', // Northern Mariana Islands
                'ST': '+239', // São Tomé and Príncipe
                'CU': '+53', // Cuba
                'SR': '+597', // Suriname
                'SK': '+421', // Slovakia
                'UA': '+380', // Ukraine
                'KY': '+1-345', // Cayman Islands
                'TC': '1-649', // Turks and Caicos Islands
                'AW': '+297', // Aruba
                'TT': '+1-868', // Trinidad and Tobago
                'CC': '+61', // Cocos (Keeling) Islands
                'WS': '+685', // Samoa
                'SS': '+211', // South Sudan
                'SG': '+65', // Singapore
                'VN': '+84', // Vietnam
                'QA': '+974', // Qatar
                'GP': '+590', // Guadeloupe
                'SI': '+386', // Slovenia
                'FO': '+386', // Faroe Islands
                'PL': '+48', // Poland
                'CX': '+61', // Christmas
                'VA': '+379', // Vatican City
                'PN': '+64', // Pitcairn Islands
                'BM': '+44', // Bermuda
                'ES': '+34', // Spain
                'NF': '+672', // Norfolk Island
                'IO': '+246', // British Indian Ocean Territory
                'KP': '+850', // North Korea
                'YT': '+262', // Mayotte
                'TG': '+228', // Togo
                'BQ': '+599', // Caribbean Netherlands
                'UG': '+256', // Uganda
                'AQ': '+672', // Antarctica
                'CH': '+41', // Switzerland
                'IM': '+44', // Isle of Man
                'HK': '+852', // Hong Kong
                'JE': '+44', // Jersey
                'TJ': '+992', // Tajikistan
                'TF': '+262', // French Southern and Antarctic Lands
                'TZ': '+255', // Tanzania
                'VI': '+1-340', // United States Virgin Islands
                'SO': '+252', // Somalia
                'SX': '+1-721', // Sint Maarten
                'MS': '+1-664', // Montserrat
                'GS': '+500', // South Georgia
                'SN': '+221', // Senegal
                'BV': '+47', // Bouvet Island
                'SB': '+677', // Solomon Islands
                'SH': '+290', // Saint Helena, Ascension and Tristan da Cunha
                'MO': '+853', // Macau
                'AI': '+1-264', // Anguilla
                'GG': '+44', // Guernsey
                'KN': '+1-869', // Saint Kitts and Nevis
                'SY': '+963', // Syria
                'PR': '+1-787', // Puerto Rico
                'SM': '+378', // San Marino
                'NC': '+687', // New Caledonia
                'SL': '+232', // Sierra Leone
                'PM': '+508', // Saint Pierre and Miquelon
                'AS': '+1-684', // American Samoa
                'PT': '+351', // Portugal
                'TW': '+886', // Taiwan
                'LK': '+94', // Sri Lanka
                'RS': '+381', // Serbia
                'RO': '+40', // Romania
                'CW': '+599', // Curaçao
                'ZM': '+260', // Zambia
                'ZW': '+263', // Zimbabwe
                'TN': '+216', // Tunisia
                'AE': '+971', // United Arab Emirates
                'GL': '+299', // Greenland
                'UY': '+598', // Uruguay
                'RU': '+7', // Russia
                'VG': '+1-284', // British Virgin Islands
                'WF': '+681', // Wallis and Futuna
                'LC': '+1-758', // Saint Lucia
                'YE': '+967', // Yemen
                'SE': '+46', // Sweden
                'SJ': '+47', // Svalbard and Jan Mayen
                'BL': '+590', // Saint Barthélemy
                'Tonga': '+676', // Tonga
                'UZ': '+998' // Uzbekistan
            };

            function toggleCountries() {
                var countryList = $('#country-list-container');
                if (countryList.is(':visible')) {
                    countryList.hide();
                } else {
                    countryList.show();
                }
            }

            function filterCountryList(searchQuery) {
                var countryListItems = $('#country-list li');

                countryListItems.each(function() {
                    var countryName = $(this).find('div strong').text().toLowerCase();
                    var countryCode = $(this).data('country-code');

                    var dialingCode = `${countryCodes[countryCode]}`;
                    if (countryName.startsWith(searchQuery) || dialingCode === searchQuery || searchQuery
                        .includes(dialingCode.substring(1))) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }

            function clearSelectedCountry() {
                // Clear only the flag and globe icon, but keep the dialing code
                $('#mycaret-flag').empty(); // Clear the flag icon
                $('#mycaret-globe').show(); // Show the globe icon
            }

            $('#phone-number').on('input', function() {
                var searchQuery = $(this).val().trim().toLowerCase();
                filterCountryList(searchQuery);

                if (searchQuery.trim() === '') {
                    clearSelectedCountry();
                }

                if (searchQuery.trim().length >= 6) {
                    var countryList = $('#country-list-container');
                    countryList.hide();
                }
            });

            $('#phone-number').on('focus', function() {
                var searchQuery = $(this).val().trim().toLowerCase();
                filterCountryList(searchQuery);

                if (searchQuery.trim() === '' || searchQuery.trim().length >= 6) {
                    clearSelectedCountry();
                }
            });

            $('#mycaret-flag').click(function(e) {
                e.stopPropagation();
                toggleCountries();
            });

            $('#country-list li').click(function() {
                const phoneNumberInput = document.getElementById("phone-number");

                var selectedCountryName = $(this).find('div strong').text();
                var selectedCountryCode = $(this).data('country-code');
                var selectedDialingCode = countryCodes[`${selectedCountryCode}`];
                const globIcon = document.getElementById('mycaret-globe');
                const countryListContainer = document.getElementById('country-list-container');
                phoneNumberInput.value = selectedDialingCode;
                var numbered;
                if (phoneNumberInput.value.startsWith('+')) {
                    numbered = Number(phoneNumberInput.value.substring(1));
                }
                if (/^\d+$/.test(phoneNumberInput.value) || typeof numbered === 'number') {
                    phoneNumberInput.type = 'tel';
                } else {
                    phoneNumberInput.type = 'text';
                }

                var flagUrl = $(this).find('img').attr('src');
                $('#mycaret-flag').html(
                    `<img class="test" src="${flagUrl}" alt="${selectedCountryName} Flag" style="width: 2rem; height: 2rem;">`
                );
                globIcon.style.display = 'none';
                countryListContainer.style.display = 'none';
                // $('#mycaret-globe').hide();
                // $('#country-list-container').hide();
            });
        });



        $(document).ready(function() {
            function showCountries() {
                var countryList = $('#country-list-container');
                countryList.toggle();
            }

            // Function to hide the country list
            function hideCountries() {
                var countryList = $('#country-list-container');
                countryList.hide();
            }

            // Hide the country list when the page is initially loaded
            hideCountries();

            // Attach a click event handler to the #phone-number input to show the country list
            $('#phone-number').click(function(e) {
                e.stopPropagation(); // Prevent the click event from propagating to the document
                showCountries();
            });

            $('#mycaret-down').click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                showCountries();
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('#phone-number').length && !$(e.target).closest('#mycaret-down')
                    .length) {
                    hideCountries();
                }
            });

        });

        //making disable the start button if continue with empty or letter
        const phoneNumberInput = document.getElementById("phone-number");
        const startTopupButton = document.getElementById("next-1");

        phoneNumberInput.addEventListener("input", function() {
            if (phoneNumberInput.value === "" || isNaN(phoneNumberInput.value)) {
                startTopupButton.disabled = true;
            } else {
                startTopupButton.disabled = false;
            }
            if (/^\d+$/.test(phoneNumberInput.value) || (phoneNumberInput.value.startsWith('+') && /^\d+$/.test(
                    phoneNumberInput.value.substring(1)))) {
                phoneNumberInput.type = 'tel';
            } else {
                phoneNumberInput.type = 'text';
            }
        });
    </script>

    <!--  Confirmation Request -->
    <script>
        // read more script in topup details
        $(document).ready(function() {
            $('.read-more-link').click(function() {
                const $transactionDetails = $(this).prev('.read_more');
                $transactionDetails.slideToggle();
            });
        });
    </script>
    <!--  Confirmation Request -->

    <!--  selecting commissions base on network type  -->
    <script>
        $(document).ready(function() {
            $('#top_networks_id').on('change', function() {
                var selectedOptionId = $(this).val();
                $("#selec_networks_id").text($("#top_networks_id option:selected").text())
                let logoPath = "{{ asset('storage/uploads') }}/" + $("#top_networks_id option:selected")
                    .attr('data-logo');
                $('#networkLogo').attr('src', logoPath);
                $("#comission").val($("#top_networks_id option:selected").attr('data-commission'))
            });
        });

        let ajaxRequest;

        function makeAjaxCall(inputValue) {
            ajaxRequest = $.ajax({
                url: "get_phone_network_data",
                method: "GET",
                data: {
                    phone: inputValue
                },
                success: function(response) {
                    inputAppender('country_iso', response.network.ntw_country_iso, 'country_iso', form);
                    inputAppender('operator_commission', response.network.ntw_rate, 'operator_commission',
                        form);
                    $("#selec_networks_id").text(response.selectedNetwork)
                    $("#comission").val(response.commission);
                    let logoPath = "{{ asset('storage/uploads') }}/";
                    set_network_packages(response.network.id, "top_pac_id", logoPath);
                },
                error: function(error) {
                    console.error("AJAX error:", error);
                }
            });
        }

        $('#phone-number').on('keyup', function() {
            const inputValue = $(this).val();

            if (inputValue.length >= 9) {
                if (ajaxRequest && ajaxRequest.readyState !== 4) {
                    ajaxRequest.abort();
                }
                makeAjaxCall(inputValue);
            }
        });
    </script>
    <!--  selecting package type  -->
    <script>
        $(document).ready(function() {
            $('#top_networks_id').on('change', function() {
                var selectedOptionId = $(this).val();
                let logoPath = "{{ asset('storage/uploads') }}/";
                set_network_packages(selectedOptionId, "top_pac_id", logoPath);
            });
        });
    </script>
    <!--  selecting package type  -->
@endsection
