@if (isset($highlightedEvent) && ($highlightedEvent['theme'] ?? '') === 'holiday')
    <img src="{{ asset('images/logo-xmas.png') }}" class="aod-logo" alt="AOD Clan Logo"/>
@else
    <img src="{{ asset('images/official-logo.png') }}" class="aod-logo" alt="AOD Clan Logo"/>
@endif
