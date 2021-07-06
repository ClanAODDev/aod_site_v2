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
        <a href="/">
            <img class="clan-logo" src="{{ asset('images/aod_new.png') }}"/>
        </a>
        <div class="hamburger"><i class="fa fa-bars fa-2x"></i></div>
        <div class="nav-items">
            <ul id="menu-primary" class="menu">
                <li class="home show-logo">
                    <a href="/" class="text-link">Home</a>
                    <img class="clan-logo" alt="AOD Clan Logo"
                         src="{{ asset('images/aod_new.png')}}"
                         onclick="window.location.replace('/')">
                </li>
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