<div id="header" class="app-header">
    <!-- BEGIN desktop-toggler -->
    <div class="desktop-toggler">
        <button type="button" class="menu-toggler" data-toggle-class="app-sidebar-collapsed"
            data-dismiss-class="app-sidebar-toggled" data-toggle-target=".app">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
    </div>
    <!-- BEGIN desktop-toggler -->

    <!-- BEGIN mobile-toggler -->
    <div class="mobile-toggler">
        <button type="button" class="menu-toggler" data-toggle-class="app-sidebar-mobile-toggled"
            data-toggle-target=".app">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
    </div>
    <!-- END mobile-toggler -->

    <!-- BEGIN brand -->
    <div class="brand">
        <a href="#" class="brand-logo">
            <span class="brand-img">
                <span class="brand-img-text text-theme">R</span>
            </span>
            <span class="brand-text">KikWek Topup Services</span>
        </a>
    </div>
    <!-- END brand -->

    <!-- BEGIN menu -->
    <div class="menu">
        <div class="menu-item dropdown dropdown-mobile-full">
            <a href="#" data-bs-toggle="dropdown" data-bs-display="static" class="menu-link">
                <div class="menu-img online">
                    @php
                        $user = Auth::user();
                        $currentRoute = Route::currentRouteName();
                        $imgUrl = $currentRoute == 'users-chat' ? $user->avatar : '/storage/uploads/' . $user->avatar;
                    @endphp
                    @if ($user->avatar)
                        <img src="{{ $imgUrl }}" class="profile_pecture text-theme" width="80"
                            height="80" alt="{{ $user->name }} avatar">
                    @else
                        <img src="{{ asset('assets/img/user/avatar.png') }}" class="profile_pecture text-theme"
                            alt="user avatar">
                    @endif
                </div>
                <div>{{ Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-end me-lg-3 fs-11px mt-1">
                @if (Auth::user()->user_role == 'admin')
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <span>{{ __('PROFILE') }}</span>
                        <i class="bi bi-person-circle ms-auto text-theme fs-16px my-n1"></i>
                    </a>
                    <!-- <a class="dropdown-item d-flex align-items-center" href="{{ route('configurations.index') }}">
                        <span>{{ __('SETTINGS') }}</span>
                        <i class="bi bi-gear ms-auto text-theme fs-16px my-n1"></i>
                    </a> -->
                @endif
                <div class="dropdown-divider" style="border-top: none;"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="dropdown-item d-flex align-items-center" href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <span>{{ __('LOGOUT') }}</span>
                        <i class="bi bi-toggle-off ms-auto text-theme fs-20px my-n1"></i>
                    </a>
                </form>
            </div>
        </div>
    </div>

    <!-- END menu -->

    <!-- BEGIN menu-search -->
    <form class="menu-search" method="POST" name="header_search_form">
        <div class="menu-search-container">
            <div class="menu-search-icon"><i class="bi bi-search"></i></div>
            <div class="menu-search-input">
                <input type="text" class="form-control form-control-lg" placeholder="Search menu...">
            </div>
            <div class="menu-search-icon">
                <a href="#" data-toggle-class="app-header-menu-search-toggled" data-toggle-target=".app"><i
                        class="bi bi-x-lg"></i></a>
            </div>
        </div>
    </form>
    <!-- END menu-search -->
</div>
