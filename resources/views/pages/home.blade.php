@extends ('application.base')

@section('content')

    <div class="commo-bar">
        <p class="commo-item">
            <a href="https://discord.gg/clanaod" title="Join the AOD Discord">
                JOIN US ON DISCORD <i class="fab fa-discord fa-lg"></i>
            </a>

            @if($discord && array_key_exists('online', $discord))
                ONLINE: {{ $discord['online'] + $discord['idle'] + $discord['dnd'] }} / {{ $discord['total'] }}
            @endif

        </p>
    </div>

    <div class="intro-video" style="display: none;">
        <div class="close-video">
            <i class="fa fa-times-circle fa-lg"></i>
        </div>
        <iframe src="https://www.youtube.com/embed/{{ config('aod.intro_video_id') }}?autoplay=0&amp;showinfo=0&amp;
        enablejsapi=1&amp;rel=0&amp;modestbranding=1&amp;origin={{ url('/') }}"
                id="video-iframe" allowfullscreen style="border: none;"></iframe>
    </div>

    <div class="hero-video video-background">
        <div class="video-container video-foreground">

            <div class="hero-text">
                @include('partials.aod-logo')
                <h1 class="slide-in-right">Game with purpose<br/>inspired by community</h1>
                <h2 class="subtitle">What are you waiting for?</h2>
                <div class="play-button">PLAY VIDEO</div>
            </div>

            <div class="grid"></div>

            <div id="video" style="border: 0;width: 100%;height: 100%;"></div>
            <script>
                var tag = document.createElement("script");
                tag.src = "https://www.youtube.com/iframe_api";
                var player,
                    firstScriptTag = document.getElementsByTagName("script")[0];

                function onYouTubeIframeAPIReady() {
                    player = new YT.Player("video", {
                        videoId: "{{ config('aod.hero_video_id') }}", playerVars: {
                            autoplay: 1,
                            mute: 1,
                            branding: 0,
                            controls: 0,
                            loop: 1,
                            modestbranding: 0,
                            origin: window.location.origin,
                            playsinline: 1,
                            rel: 0,
                            playlist: "{{ config('aod.hero_video_id') }}"
                        }, events: {onReady: onPlayerReady, onStateChange: onPlayerStateChange}
                    })
                }

                function onPlayerReady(e) {
                    e.target.mute();
                    e.target.playVideo();

                    // Trigger video scaling after player is ready
                    if (window.resizeHeroVideo) {
                        setTimeout(window.resizeHeroVideo, 100);
                    }
                }

                function onPlayerStateChange(e) {
                    if (e.data === YT.PlayerState.ENDED) {
                        player.playVideo();
                    }
                }

                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            </script>
        </div>
    </div>

    <section class="holiday-section with-shadow">
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
        <div class="section-content-container section--centered">
            <div class="holiday-content animate drop-up">
                <div class="holiday-badge">
                    <i class="fas fa-snowflake"></i>
                    <span>Holiday Special</span>
                    <i class="fas fa-snowflake"></i>
                </div>
                <h1>AOD Christmas Podcast 2025</h1>
                <p>Celebrate the season with the Angels of Death! Join us for our annual holiday podcast featuring community stories, gaming highlights, and festive fun.</p>
                <div class="holiday-video">
                    <iframe
                        src="https://www.youtube.com/embed/cdVZmCGgTxs"
                        title="AOD Christmas Podcast 2024"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <section class="supported-games with-shadow">
        <div class="section-content-container section--centered ">
            <h1 class="slide-in-right animate">Engaged in <strong>{{ count($aod_divisions) }}</strong> major titles <br>with more than
                <strong>1200</strong> active members </h1>
            <div class="section-blurb slide-in-left animate animation-delay-2">
                <p>From first-person shooters and survival games to the most well known massive-multiplayer games,
                    you'll always have something to play. And there's no shortage of AOD members playing around the
                    clock from Brisbane, Australia and Osaka, Japan crossing the likes of Norway, France, and Brazil,
                    and dominating the time zones of North and South America.</p>
            </div>
            <div class="divisions-grid animate drop-up animation-delay-3">
                @foreach($aod_divisions as $division)
                <a href="{{ route('division.show', $division['slug']) }}" class="division-icon" title="{{ $division['name'] }}">
                    <img src="{{ $division['icon'] }}" alt="{{ $division['name'] }}">
                    <span class="division-name">{{ $division['name'] }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="founded-info with-shadow">
        <div class="section-content-container  ">
            <div class="section--short-width">
                <div class="section-blurb slide-in-left animate">
                    <h1>Founded in <strong>1999</strong><br>and still growing! </h1>
                    <p>The Angels of Death is a time-tested organization, supporting over 56 major gaming titles in the
                        past 25 years including classics like Medal of Honor: Allied Assault, and Swat 3.</p>
                    <p>We’ve lasted this long because of the tireless efforts of people who love gaming, and our
                        community is as diverse as the games we play. AOD is truly a family, and we’ve never stopped
                        growing.</p>
                    <p><a href="{{ route('history') }}">Read the history of AOD</a></p>

                </div>
                <div class="section-image slide-in-right animate animation-delay-4">
                    <img width="700" height="700" src="{{ asset('images/dude.png') }}" class="attachment-full size-full"
                         alt="">
                </div>
            </div>
        </div>
    </section>

    <section class="section with-shadow"
             style="background: url({{ asset('images/belong-section-bg.jpg') }}) #050505 no-repeat center 0">
        <div class="section-content-container section--centered">
            <h1 class="slide-in-left animate">Belong to something <strong>unique</strong> and<br>worldwide that <strong>endures</strong>
                through time
            </h1>
            <div class="section-blurb slide-in-right animate">
                <p>Maniacal adolescent leaders with cosmic delusional powers, leaders that suddenly vanish, councils
                    that focus more on forum flair than decisions. Like you, we’ve experienced them all and learned a
                    lot in the process.</p>
                <p>We made sure AOD was different. We intentionally cultivated a community focused on less drama, and
                    more gaming. Here your relationships and investments in the community continue beyond a single
                    game.</p>
                <p>At AOD, your legacy can last for years.</p>

            </div>
        </div>
    </section>

    <section class="honor-info ">
        <div class="section-content-container animate drop-down-fade-in">
            <h1>We aspire to win the right way </h1>
            <div class="section-blurb">
                <p>Chief among our priorities is maintaining a gaming atmosphere free of drama that all can enjoy. While
                    winning is important to us, so is fair play, respect among members, and courtesy to our volunteer
                    staff.</p>
                <p><a href="https://www.clanaod.net/forums/showthread.php?t=3327">Read our Code of Conduct</a></p>

            </div>
        </div>
    </section>

    <section class="social-media with-shadow">
        <div class="section-content-container section--centered">
            <h1 class="animate slide-in-left animate-delay-0">Catch up with us on social media </h1>
            <div class="section-blurb">
                <p class="animate slide-in-right animate-delay-0">Grab one of the hundreds of seats in our hosted VOIP
                    amphitheater while working your WASD and, when you have to leave your mechanical keys, keep up to
                    date by following our social feeds.</p>
                <div class="social-icons">
                    <a href="https://discord.gg/clanaod" class="social-icon discord animate drop-up animation-delay-1" title="Discord">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028 14.09 14.09 0 0 0 1.226-1.994.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/></svg>
                        <span>Discord</span>
                    </a>
                    <a href="https://www.twitch.tv/clanaodstream" class="social-icon twitch animate drop-up animation-delay-2" title="Twitch">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714z"/></svg>
                        <span>Twitch</span>
                    </a>
                    <a href="https://twitter.com/officialclanaod" class="social-icon twitter animate drop-up animation-delay-3" title="X / Twitter">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        <span>X</span>
                    </a>
                    <a href="http://steamcommunity.com/groups/clanaod" class="social-icon steam animate drop-up animation-delay-4" title="Steam">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.979 0C5.678 0 .511 4.86.022 11.037l6.432 2.658c.545-.371 1.203-.59 1.912-.59.063 0 .125.004.188.006l2.861-4.142V8.91c0-2.495 2.028-4.524 4.524-4.524 2.494 0 4.524 2.031 4.524 4.527s-2.03 4.525-4.524 4.525h-.105l-4.076 2.911c0 .052.004.105.004.159 0 1.875-1.515 3.396-3.39 3.396-1.635 0-3.016-1.173-3.331-2.727L.436 15.27C1.862 20.307 6.486 24 11.979 24c6.627 0 11.999-5.373 11.999-12S18.605 0 11.979 0zM7.54 18.21l-1.473-.61c.262.543.714.999 1.314 1.25 1.297.539 2.793-.076 3.332-1.375.263-.63.264-1.319.005-1.949s-.75-1.121-1.377-1.383c-.624-.26-1.29-.249-1.878-.03l1.523.63c.956.4 1.409 1.5 1.009 2.455-.397.957-1.497 1.41-2.454 1.012H7.54zm11.415-9.303c0-1.662-1.353-3.015-3.015-3.015-1.665 0-3.015 1.353-3.015 3.015 0 1.665 1.35 3.015 3.015 3.015 1.663 0 3.015-1.35 3.015-3.015zm-5.273-.005c0-1.252 1.013-2.266 2.265-2.266 1.249 0 2.266 1.014 2.266 2.266 0 1.251-1.017 2.265-2.266 2.265-1.253 0-2.265-1.014-2.265-2.265z"/></svg>
                        <span>Steam</span>
                    </a>
                    <a href="http://bit.ly/2dKbL9I" class="social-icon youtube animate drop-up animation-delay-5" title="YouTube">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        <span>YouTube</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="apply-info ">
        <div class="section-content-container section--centered ">
            <h1>So what are you waiting for? </h1>
            <div class="section-blurb">
                <p>Complete a clan application with one of our divisions to start the process and see if we’re a good
                    fit for each other.</p>
                <p><a class="apply-button call-to-action-button" href="#">Apply</a></p>

            </div>
        </div>
    </section>

@endsection
