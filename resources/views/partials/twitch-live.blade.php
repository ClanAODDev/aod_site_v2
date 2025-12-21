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
                <div id="twitch-embed"></div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var embed = new Twitch.Embed("twitch-embed", {
                width: "100%",
                height: "100%",
                channel: "{{ $twitch['channel'] }}",
                layout: "video",
                autoplay: true,
                muted: true,
                parent: [window.location.hostname]
            });

            var player = null;
            var unmuteBtn = document.getElementById('twitch-unmute');

            embed.addEventListener(Twitch.Embed.VIDEO_READY, function() {
                player = embed.getPlayer();
            });

            if (unmuteBtn) {
                unmuteBtn.addEventListener('click', function() {
                    if (player) {
                        player.setMuted(false);
                        unmuteBtn.style.display = 'none';
                    }
                });
            }
        });
    </script>
</section>
