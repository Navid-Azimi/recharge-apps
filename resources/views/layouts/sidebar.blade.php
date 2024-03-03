<link href="{{ asset('/css/main.pro.css') }}" rel="stylesheet">

<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
    <!-- BEGIN menu -->
    <div class="menu mb-3">
        <br>
        @php
            $currentRoute = Route::currentRouteName();
            $user = Auth::user();
        @endphp
        <!-- profile  -->
        <div class="reseller-profile">
            <table style="text-align: center;">
                <thead>
                    <tr>
                        <th class="bg-transparent">
                            @php
                                $imgUrl = $currentRoute == 'users-chat' ? $user->avatar : '/storage/uploads/' . $user->avatar;
                            @endphp
                            @if ($user->user_role == 'reseller')
                                <div class="reseller-img" data-bs-toggle="tooltip"
                                    data-bs-placement="right"data-html="true"
                                    data-original-title="<strong>Business Type: </strong> {{ $user->business_type ? $user->business_type : 'Not set' }}<br><strong>Business License: </strong>{{ $user->business_license_nu ? $user->business_license_nu : 'Not set' }} <br><strong>ID Number: </strong> {{ $user->passport_number ? $user->passport_number : 'Not set' }}">
                                @elseif ($user->user_role == 'admin')
                                    <div class="reseller-img">
                            @endif
                            @if ($user->avatar && $user->avatar != 'avatar.png')
                                <img class="UserProfilePicture text-theme rounded-circle" height="76"
                                    width="76"src="{{ $imgUrl }}" alt="{{ $user->name }} avatar">
                            @else
                                <img src="{{ asset('assets/img/user/avatar.png') }}" alt="user avatar">
                            @endif
        </div>
        </th>
        </tr>
        <tr>
            <td><a href="{{ url('/') }}" style="font-size: 1.2rem;">{{ $user->name }}</a></td>
        </tr>
        <tr>
            <td>
                <div class="reseller-account">
                    @if ($user->user_role == 'admin')
                        <h5><span class="amount-value" style="display: none;">$430.12</span></h5>
                    @else
                        <h5><span class="amount-value" style="display: none;">${{ $balance }}</span></h5>
                    @endif

                    <i class="bi bi-eye toggle-amount app_balaceshow_toggle"></i>
                    <br>
                    <br>
                </div>
            </td>
        </tr>
        </thead>
        </table>
        <hr class="reseler-profiles-endline">
    </div>
    <!-- end profile  -->
    <!-- setting  -->
    <div class="menu-item {{ Request::is('*dashboard') ? 'active' : '' }} ">
        <a href="{{ url('/') }}" class="menu-link">
            <span class="menu-icon"><i class="fa fa-gear"></i></span>
            <span class="menu-text">Dashboard</span>
        </a>
    </div>
    <!-- end setting  -->
    @if (Auth::user()->user_role == 'admin')
        <div class="menu-item has-sub {{ Request::is('networks*') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <span class="menu-icon">
                    <i class="fas fa-sim-card"></i>
                </span>
                <span class="menu-text">Operators</span>
                <span class="menu-caret"><b class="caret"></b></span>
            </a>
            <div class="menu-submenu">
                <div class="menu-item  {{ Request::is('networks') ? 'active' : '' }}">
                    <a href="{{ route('networks.index') }}" class="menu-link">
                        <span class="menu-text">All Operators</span>
                    </a>
                </div>

                <div class="menu-item {{ Request::is('networks/create') ? 'active' : '' }}">
                    <a href="{{ route('networks.create') }}" class="menu-link">
                        <span class="menu-text">Add operator</span>
                    </a>
                </div>

                <div class="menu-item {{ Request::is('networks_contact') ? 'active' : '' }}">
                    <a href="{{ route('networks_contact.index') }}" class="menu-link">
                        <span class="menu-text">Contacts Operators</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="menu-item has-sub {{ Request::is('packages*') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <span class="menu-icon">
                    <i class="fas fa-credit-card"></i>
                </span>
                <span class="menu-text">Packages</span>
                <span class="menu-caret"><b class="caret"></b></span>
            </a>
            <div class="menu-submenu">
                <div class="menu-item {{ Request::is('packages') ? 'active' : '' }}">
                    <a href="{{ route('packages.index') }}" class="menu-link">
                        <span class="menu-text">All Packages</span>
                    </a>
                </div>
                <div class="menu-item {{ Request::is('packages/create') ? 'active' : '' }}">
                    <a href="{{ route('packages.create') }}" class="menu-link">
                        <span class="menu-text">Add Package</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- end Package  -->
        <div class="menu-item has-sub {{ Request::is('giftcard*') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <span class="menu-icon">
                    <i class="fas fa-gift"></i>
                </span>
                <span class="menu-text">Gift Cards</span>
                <span class="menu-caret"><b class="caret"></b></span>
            </a>
            <div class="menu-submenu">
                <div class="menu-item {{ Request::is('giftcardbrands') ? 'active' : '' }}">
                    <a href="{{ route('giftcardbrands.index') }}" class="menu-link">
                        <span class="menu-text">Gift Card Brands</span>
                    </a>
                </div>
                <div class="menu-item {{ Request::is('giftcardtypes') ? 'active' : '' }}">
                    <a href="{{ route('giftcardtypes.index') }}" class="menu-link">
                        <span class="menu-text">Gift Card Types</span>
                    </a>
                </div>
                <div class="menu-item {{ Request::is('giftcards') ? 'active' : '' }}">
                    <a href="{{ route('giftcards.index') }}" class="menu-link">
                        <span class="menu-text">Gift Cards</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- promo code  -->
        <div class="menu-item has-sub {{ Request::is('promocodes*') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <span class="menu-icon">
                    <i class="fa-solid fa-award"></i> </span>
                <span class="menu-text">Promo Codes</span>
                <span class="menu-caret"><b class="caret"></b></span>
            </a>
            <div class="menu-submenu">
                <div class="menu-item  {{ Request::is('promocodes') ? 'active' : '' }}">
                    <a href="{{ route('promocodes.index') }}" class="menu-link">
                        <span class="menu-text">All Promo Codes</span>
                    </a>
                </div>
                <div class="menu-item {{ Request::is('promocodes/create') ? 'active' : '' }}">
                    <a href="{{ route('promocodes.create') }}" class="menu-link">
                        <span class="menu-text">Add Promo Code</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- end promo code  -->

        <!-- country_rate_and_tax  -->
        <div class="menu-item {{ Request::is('country_rate_and_tax') ? 'active' : '' }}">
            <a href="{{ route('country_rate_and_tax.index') }}" class="menu-link">
                <span class="menu-icon"><i class="fas fa-comments-dollar"></i></span>
                <span class="menu-text">Taxes & Rates</span>
            </a>
        </div>
        <!-- end country_rate_and_tax  -->

        <!-- payment history  -->
        <div class="menu-item {{ Request::is('reseller-payments') ? 'active' : '' }}">
            <a href="{{ url('/reseller-payments') }}" class="menu-link">
                <span class="menu-icon"><i class="fa fa-money-bill"></i></span>
                <span class="menu-text">Payments History</span>
            </a>
        </div>
        <!-- end payment history  -->

        <!--  Reports -->
        <!-- -----------------------------------------------------------------------  -->
        <div class="menu-item has-sub {{ Request::is('*reports') ? 'active' : '' }}">
            <a href="{{ url('/reports') }}" class="menu-link">
                <span class="menu-icon"><i class="fa fa-chart-bar"></i></span>
                <span class="menu-text">Reports</span>
                <span class="menu-caret"><b class="caret"></b></span>
            </a>
            <div class="menu-submenu ">
                <div class="menu-item {{ Request::is('reports') ? 'active' : '' }}">
                    <a href="{{ url('/reports') }}" class="menu-link">
                        <span class="menu-text">All Reports</span>
                    </a>
                </div>

                <div class="menu-item {{ Request::is('reseller-reports') ? 'active' : '' }}">
                    <a href="{{ route('reseller_reports') }}" class="menu-link">
                        <span class="menu-text">Reseller Reports</span>
                    </a>
                </div>

                <div class="menu-item {{ Request::is('customer-reports') ? 'active' : '' }}">
                    <a href="{{ route('customer_reports') }}" class="menu-link">
                        <span class="menu-text">Customer Reports</span>
                    </a>
                </div>
                <div class="menu-item {{ Request::is('customer-giftcards-reports') ? 'active' : '' }}">
                    <a href="{{ route('giftcards_reports') }}" class="menu-link">
                        <span class="menu-text">Gift Cards Reports</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- -----------------------------------------------------------------------  -->
        <!--  Activity logs -->
        <div class="menu-item {{ Request::is('activity') ? 'active' : '' }}">
            <a href="{{ url('/activity') }}" class="menu-link">
                <span class="menu-icon"><i class="fa fa-chart-simple"></i></span>
                <span class="menu-text">Activity Logs</span>
            </a>
        </div>
        <!--  Manage Resellers -->
        <div class="menu-item has-sub {{ Request::is('manage-reseller*') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <span class="menu-icon"><i class="fa fa-users"></i></span>
                <span class="menu-text">Manage Resellers</span>
                <span class="menu-caret"><b class="caret"></b></span>
            </a>
            <div class="menu-submenu">
                <div class="menu-item {{ Request::is('manage-resellers') ? 'active' : ''}}">
                    <a href="{{ route('manage_resellers') }}" class="menu-link">
                        <span class="menu-text">Management</span>
                    </a>
                </div>

                <div class="menu-item {{ Request::is('manage-reseller-req') ? 'active' : ''}}">
                    <a href="{{ route('requests_reseller') }}" class="menu-link">
                        <span class="menu-text">Requests</span>
                    </a>
                </div>
            </div>
        </div>
        <!--  Manage Resellers -->
        <!-- backup  -->
        <div class="menu-item {{ Request::is('backup-panel') ? 'active' : '' }}">
            <a href="{{ url('/backup-panel') }}" class="menu-link">
                <span class="menu-icon"><i class="fa fa-hdd"></i></span>
                <span class="menu-text">Backup</span>
            </a>
        </div>
        <!-- end backup  -->
        <!-- Announcements  -->
        <div class="menu-item has-sub {{ Request::is('announcements*') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <span class="menu-icon">
                    <i class="fa-solid fa-bullhorn"></i></span>
                <span class="menu-text">Announcements</span>
                <span class="menu-caret"><b class="caret"></b></span>
            </a>
            <div class="menu-submenu">
                <div class="menu-item {{ Request::is('announcements') ? 'active' : '' }}">
                    <a href="{{ route('announcements.index') }}" class="menu-link">
                        <span class="menu-text">All Announcements</span>
                    </a>
                </div>

                <div class="menu-item {{ Request::is('announcements/create') ? 'active' : '' }}">
                    <a href="{{ route('announcements.create') }}" class="menu-link">
                        <span class="menu-text">Add Announcement</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Announcements  -->

        <!-- services  -->
        <div class="menu-item {{ Request::is('services') ? 'active' : '' }}">
            <a href="{{ route('services') }}" class="menu-link">
                <span class="menu-icon"><i class="fab fa-lg fa-fw me-2 fa-servicestack"></i></span>
                <span class="menu-text">Services</span>
            </a>
        </div>
        <!-- services  -->

        <!-- users  -->
        <div class="menu-item {{ Request::is('users*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <span class="menu-icon"><i class="bi bi-people"></i></span>
                <span class="menu-text">Users</span>
            </a>
        </div>
        <!-- end users  -->
    @endif

    @if (Auth::user()->user_role == 'reseller')
        <!-- My Wallet  -->
        <div class="menu-item {{ Request::is('reseller-wallet') ? 'active' : '' }}">
            <a href="{{ url('/reseller-wallet') }}" class="menu-link">
                <span class="menu-icon"><i class="fa fa-wallet"></i></span>
                <span class="menu-text">My Wallet</span>
            </a>
        </div>
        <!-- end My Wallet  -->

        <!-- My Wallet  -->
        <div class="menu-item {{ Request::is('reseller-payments') ? 'active' : '' }}">
            <a href="{{ url('/reseller-payments') }}" class="menu-link">
                <span class="menu-icon"><i class="fa fa-money-bill"></i></span>
                <span class="menu-text">Payments</span>
            </a>
        </div>
        <!-- end My Wallet  -->

        <!-- Gift Card Reseller  -->
        <div class="menu-item has-sub {{ Request::is('*gifts') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <span class="menu-icon"><i class="fa fa-gift"></i></span>
                <span class="menu-text">Gift Cards</span>
                <span class="menu-caret"><b class="caret"></b></span>
            </a>
            <div class="menu-submenu">
                <div class="menu-item {{ Request::is('reseller-buy_gifts') ? 'active' : ''}}">
                    <a href="{{ url('/reseller-buy_gifts') }}" class="menu-link">
                        <span class="menu-text">Buy Gift Cards</span>
                    </a>
                </div>

                <div class="menu-item {{ Request::is('reseller-my_gifts') ? 'active' : '' }}">
                    <a href="{{ url('/reseller-my_gifts') }}" class="menu-link">
                        <span class="menu-text">My Gift Cards</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- end gift Card Reseller  -->
    @endif
</div>
</div>

<script>
    //  show and hide reseller balance
    const toggleAmount = document.querySelector('.toggle-amount');
    const amountValue = document.querySelector('.amount-value');

    amountValue.style.display = 'none';
    toggleAmount.classList.add('bi-eye-slash');

    toggleAmount.addEventListener('click', function() {
        if (amountValue.style.display === 'none') {
            amountValue.style.display = 'inline';
            toggleAmount.classList.remove('bi-eye-slash');
            toggleAmount.classList.add('bi-eye');
        } else {
            amountValue.style.display = 'none';
            toggleAmount.classList.remove('bi-eye');
            toggleAmount.classList.add('bi-eye-slash');
        }
    });
    //  end of show and hide reseller balance
</script>
