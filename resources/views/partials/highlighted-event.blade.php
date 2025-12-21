<section class="highlighted-event-section {{ $highlightedEvent['theme'] ?? 'default' }}-theme with-shadow">
    @if($highlightedEvent['show_snowflakes'] ?? false)
    <div class="snowflakes">
        <div class="snowflake">❄</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❄</div>
    </div>
    @endif
    <div class="section-content-container section--centered">
        <div class="highlighted-event-content animate drop-up">
            @if(isset($highlightedEvent['badge']))
            <div class="highlighted-event-badge">
                @if(isset($highlightedEvent['badge']['icon']))
                <i class="{{ $highlightedEvent['badge']['icon'] }}"></i>
                @endif
                <span>{{ $highlightedEvent['badge']['text'] }}</span>
                @if(isset($highlightedEvent['badge']['icon']))
                <i class="{{ $highlightedEvent['badge']['icon'] }}"></i>
                @endif
            </div>
            @endif

            <h1>{{ $highlightedEvent['title'] }}</h1>

            @if(isset($highlightedEvent['description']))
            <p>{{ $highlightedEvent['description'] }}</p>
            @endif

            @if(isset($highlightedEvent['video']))
            <div class="highlighted-event-video">
                @if($highlightedEvent['video']['type'] === 'youtube')
                <iframe
                    src="https://www.youtube.com/embed/{{ $highlightedEvent['video']['id'] }}"
                    title="{{ $highlightedEvent['video']['title'] ?? $highlightedEvent['title'] }}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
                @elseif($highlightedEvent['video']['type'] === 'twitch')
                <iframe
                    src="https://player.twitch.tv/?video={{ $highlightedEvent['video']['id'] }}&parent={{ request()->getHost() }}"
                    title="{{ $highlightedEvent['video']['title'] ?? $highlightedEvent['title'] }}"
                    frameborder="0"
                    allowfullscreen>
                </iframe>
                @endif
            </div>
            @endif

            @if(isset($highlightedEvent['cta']))
            <a href="{{ $highlightedEvent['cta']['url'] }}" class="highlighted-event-cta" target="_blank">
                @if(isset($highlightedEvent['cta']['icon']))
                <i class="{{ $highlightedEvent['cta']['icon'] }}"></i>
                @endif
                {{ $highlightedEvent['cta']['text'] }}
            </a>
            @endif
        </div>
    </div>
</section>
