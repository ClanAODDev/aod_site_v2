<div class="primary-nav {{(!request()->is('/'))? 'stay-fixed' : null }}">
    <div class="nav-texture full-nav">
        <div class="menu-primary-container">
            <ul id="menu-primary" class="menu">
                @include('partials.nav-links')
            </ul>
        </div>
    </div>
    <div class="mobile-nav">
        <img class="clan-logo" src="{{ asset('images/aod_new.png') }}"
             alt="Clan AOD Logo"
             onclick="window.location.href = '/';"/>

        <div class="hamburger"><i class="fa fa-bars fa-2x"></i></div>
        <div class="nav-items">
            <ul id="menu-mobile" class="menu">
                @include('partials.nav-links')
            </ul>
        </div>
    </div>
</div>