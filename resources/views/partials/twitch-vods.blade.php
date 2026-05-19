<section class="twitch-section twitch-vods-section with-shadow">
    <div class="section-content-container section--centered">
        <h2 class="animate slide-in-left">Recent Streams</h2>
        <div class="section-blurb">
            <p class="animate slide-in-right">Catch up on our latest broadcasts from the Angels of Death community.</p>
        </div>
        <div class="vod-carousel">
            <button class="vod-nav vod-prev" aria-label="Previous videos">&lsaquo;</button>
            <div class="vod-viewport">
                <div class="vod-grid">
                    @foreach($twitch['vods'] as $vod)
                    <a href="{{ $vod['url'] }}" class="vod-item" target="_blank" rel="noopener noreferrer">
                        <div class="vod-thumbnail">
                            <img src="{{ str_replace(['%{width}', '%{height}'], ['320', '180'], $vod['thumbnail_url']) }}" alt="{{ $vod['title'] }}">
                            <span class="vod-duration">{{ $vod['duration'] }}</span>
                        </div>
                        <div class="vod-info">
                            <span class="vod-title">{{ $vod['title'] }}</span>
                            <span class="vod-meta">
                                <i class="fas fa-eye"></i> {{ number_format($vod['view_count']) }} views
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            <button class="vod-nav vod-next" aria-label="Next videos">&rsaquo;</button>
        </div>
        <a href="https://www.twitch.tv/{{ $twitch['channel'] }}/videos" class="twitch-cta animate drop-up" target="_blank" rel="noopener noreferrer">
            <i class="fab fa-twitch"></i> View All Videos on Twitch
        </a>
    </div>
</section>
