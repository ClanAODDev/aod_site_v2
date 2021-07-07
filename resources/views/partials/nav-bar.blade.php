<div class="primary-nav {{(!request()->is('/'))? 'stay-fixed' : null }}">
    <div class="nav-texture full-nav">
        <div class="menu-primary-container">
            <ul id="menu-primary" class="menu">
                <li><a href="/forums">Forums</a></li>
                <li><a href="/divisions/">Divisions</a></li>
                <li><a href="/twitch/">Stream</a></li>
                <li><a href="/history/">History</a></li>
                <li class="apply-button"><a href="#">Apply</a></li>
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
                <li id="menu-item-269" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-269"><a
                        href="/forums">Forums</a></li>
                <li><a href="https://www.clanaod.net/divisions/">Divisions</a></li>
                <li><a href="https://www.twitch.tv/clanaodstream">Stream</a></li>
                <li><a href="https://www.clanaod.net/history/">History</a></li>
                <li><a href="#">Apply</a></li>
            </ul>
        </div>
    </div>
</div>