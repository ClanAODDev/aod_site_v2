<section class="twitch-section twitch-live-section with-shadow">
    <div class="section-content-container section--centered">
        <div class="twitch-content animate drop-up">
            <div class="twitch-live-badge">
                <span class="live-dot"></span>
                <span>LIVE NOW</span>
            </div>
            <h1>{{ $twitch['stream']['title'] ?? 'ClanAOD is Live!' }}</h1>
            @if(isset($twitch['stream']['game_name']))
                <p class="stream-game">Playing {{ $twitch['stream']['game_name'] }}</p>
            @endif
            <div class="twitch-embed-container">
                <div id="twitch-embed" data-channel="{{ $twitch['channel'] }}"></div>
                <button class="twitch-unmute-btn" id="twitch-unmute">
                    <i class="fas fa-volume-mute"></i>
                    <span>Click to Unmute</span>
                </button>
            </div>
            <a href="https://www.twitch.tv/{{ $twitch['channel'] }}" class="twitch-cta" target="_blank">
                <i class="fab fa-twitch"></i> Watch on Twitch
            </a>
        </div>
    </div>
    <script src="https://embed.twitch.tv/embed/v1.js"></script>
</section>
