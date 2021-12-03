@if (in_array(now()->month, [12, 1]))
    <img src="{{ asset('images/logo-xmas.png') }}" class="aod-logo" alt="AOD Clan Logo"/>
@else
    <img src="{{ asset('images/official-logo.png') }}" class="aod-logo" alt="AOD Clan Logo"/>
@endif
