@extends('application.base')

@section('page-title', 'History of AOD')

@section('content')

    <div id="timeline" class="timeline-container">

        <div class="timeline-era" data-era="foundations">
            <div class="era-background">
                <div id="foundations-era-video" class="era-video"></div>
            </div>

            <div class="timeline-block">
                <div class="timeline-bullet cd-location animate">
                    <img src="{{ asset('images/cd-icon-location.svg') }}" alt="bullet">
                </div>
                <div class="timeline-content animate">
                    <h2>The Early Years</h2>
                    <h2 class="date-text">1999-2003</h2>
                    <p>In the beginning there was only Liquid_Smoke and Lividum. Thankfully they were good at making friends
                        and motivating others leading to expansion across the following titles:</p>
                    <div class="game-grid">
                        <span class="game-tag">SWAT 3</span>
                        <span class="game-tag">Red Faction</span>
                        <span class="game-tag">Medal of Honor: Allied Assault</span>
                        <span class="game-tag">Jedi Knight</span>
                        <span class="game-tag">Nascar 2003</span>
                        <span class="game-tag">Star Wars: Galaxies</span>
                        <span class="game-tag">PlanetSide</span>
                    </div>
                </div>
            </div>

            <div class="timeline-block">
                <div class="timeline-bullet cd-location animate">
                    <img src="{{ asset('images/cd-icon-location.svg') }}" alt="bullet">
                </div>
                <div class="timeline-content animate">
                    <h2>Taking Flight</h2>
                    <h2 class="date-text">2004-2007</h2>
                    <p>These were the years where we learned to fly leveraging a people-focused culture supported by strong
                        and reliable leadership.</p>
                    <div class="game-grid">
                        <span class="game-tag">Counter Strike: Source</span>
                        <span class="game-tag">Everquest 2</span>
                        <span class="game-tag">Joint Operations Typhoon Rising</span>
                        <span class="game-tag">World of Warcraft</span>
                        <span class="game-tag">Age of Empires III</span>
                        <span class="game-tag">Battlefront 2</span>
                        <span class="game-tag">Call of Duty 2</span>
                        <span class="game-tag">Day of Defeat: Source</span>
                        <span class="game-tag">Guild Wars</span>
                        <span class="game-tag">Battlefield 2</span>
                        <span class="game-tag">Battlefield 2142</span>
                        <span class="game-tag">Call of Duty 4: Modern Warfare</span>
                        <span class="game-tag">Enemy Territory: Quake Wars</span>
                        <span class="game-tag">Team Fortress 2</span>
                        <span class="game-tag">WarRock</span>
                    </div>
                </div>
            </div>

            <div class="timeline-block">
                <div class="timeline-bullet cd-location animate">
                    <img src="{{ asset('images/cd-icon-location.svg') }}" alt="bullet">
                </div>
                <div class="timeline-content animate">
                    <h2>Explosive Expansion</h2>
                    <h2 class="date-text">2009-2012</h2>
                    <p>If there's one thing that will test a system, it's too much success. Transitioning from a medium
                        sized group of hundreds of members to thousands across the globe came with challenges in addition to
                        the exhilaration. The redundancies and safeguards instituted years prior paved the way out of our
                        valley.</p>
                    <div class="game-grid">
                        <span class="game-tag">Darkfall</span>
                        <span class="game-tag">Battlefield Bad Company 2</span>
                        <span class="game-tag">EVE Online</span>
                        <span class="game-tag">Global Agenda</span>
                        <span class="game-tag highlight">World of Tanks – World Champions</span>
                        <span class="game-tag">DC Universe</span>
                        <span class="game-tag">Section 8 – Prejudice</span>
                        <span class="game-tag">Star Wars The Old Republic</span>
                        <span class="game-tag">Battlefield 3</span>
                        <span class="game-tag">WarZ</span>
                        <span class="game-tag">Guild Wars 2</span>
                        <span class="game-tag">PlanetSide 2</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="timeline-era" data-era="evolution">
            <div class="era-background"></div>

            <div class="timeline-block">
                <div class="timeline-bullet cd-location animate">
                    <img src="{{ asset('images/cd-icon-location.svg') }}" alt="bullet">
                </div>
                <div class="timeline-content animate">
                    <h2>Finding Our Center</h2>
                    <h2 class="date-text">2013-2014</h2>
                    <p>Success looks different now, more than a decade from our start. We number thousands full of passion
                        for the chance to belong – and contribute to – something altogether remarkable.</p>
                    <div class="game-grid">
                        <span class="game-tag">Archeage</span>
                        <span class="game-tag">Defiance</span>
                        <span class="game-tag">Mech Warrior Online</span>
                        <span class="game-tag">Warframe</span>
                        <span class="game-tag">War Thunder</span>
                        <span class="game-tag">Battlefield 4</span>
                        <span class="game-tag">Arma 3</span>
                        <span class="game-tag">DayZ</span>
                        <span class="game-tag">FireFall</span>
                        <span class="game-tag">Ghost Recon: Phantoms</span>
                        <span class="game-tag">The Repopulation</span>
                    </div>
                </div>
            </div>

            <div class="timeline-block">
                <div class="timeline-bullet cd-location animate">
                    <img src="{{ asset('images/cd-icon-location.svg') }}" alt="bullet">
                </div>
                <div class="timeline-content animate">
                    <h2>Grounding Vision</h2>
                    <h2 class="date-text">2015-2017</h2>
                    <p>Coming up on 20 years, the world of gaming and gaming communities has changed. New games come with
                        new challenges. Navigating this new universe requires foundational improvements, strong leadership,
                        and new tools. Adaptation is the pillar of survival.</p>
                    <div class="game-grid">
                        <span class="game-tag">Armored Warfare</span>
                        <span class="game-tag">ARK: Survival Evolved</span>
                        <span class="game-tag">H1Z1</span>
                        <span class="game-tag">Project Cars</span>
                        <span class="game-tag">Skyforge</span>
                        <span class="game-tag">Star Wars: Battlefront</span>
                        <span class="game-tag">Rainbow Six Siege</span>
                        <span class="game-tag">Ghost Recon: Wildlands</span>
                        <span class="game-tag">Black Desert Online</span>
                        <span class="game-tag">Overwatch</span>
                        <span class="game-tag">Tom Clancy's The Division</span>
                        <span class="game-tag">Warhammer 40K: Eternal Crusade</span>
                        <span class="game-tag">Titanfall 2</span>
                        <span class="game-tag">Battlefield 1</span>
                        <span class="game-tag">PlayerUnknown's Battlegrounds</span>
                        <span class="game-tag">Mass Effect: Andromeda</span>
                        <span class="game-tag">Elite: Dangerous</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="timeline-era" data-era="brave">
            <div class="era-background"></div>
            <div class="timeline-block">
                <div class="timeline-bullet cd-location animate">
                    <img src="{{ asset('images/cd-icon-location.svg') }}" alt="bullet">
                </div>
                <div class="timeline-content animate">
                    <h2>A Brave New World</h2>
                    <h2 class="date-text">2018-2020</h2>
                    <p>We continue to scale sensibly, piloting ever-forward. Our future, much like our history, is ours to
                        create.</p>
                    <div class="game-grid">
                        <span class="game-tag">Anthem</span>
                        <span class="game-tag">Apex Legends</span>
                        <span class="game-tag">Battlefield V</span>
                        <span class="game-tag">Battlefront II</span>
                        <span class="game-tag">Call of Duty: Modern Warfare</span>
                        <span class="game-tag">Ghost Recon: Breakpoint</span>
                        <span class="game-tag">Destiny 2</span>
                        <span class="game-tag">World of Warships</span>
                        <span class="game-tag">World of Warcraft Classic</span>
                        <span class="game-tag">Sea of Thieves</span>
                        <span class="game-tag">The Division 2</span>
                        <span class="game-tag">iRacing</span>
                        <span class="game-tag">Fortnite</span>
                        <span class="game-tag">Bless Online</span>
                        <span class="game-tag">Escape From Tarkov</span>
                        <span class="game-tag">Fallout 76</span>
                        <span class="game-tag">Hearts of Iron IV</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="timeline-era" data-era="modern">
            <div class="era-background">
                <div id="modern-era-video" class="era-video"></div>
            </div>
            <div class="timeline-block">
                <div class="timeline-bullet cd-location animate">
                    <img src="{{ asset('images/cd-icon-location.svg') }}" alt="bullet">
                </div>
                <div class="timeline-content animate">
                    <h2>Modern Era</h2>
                    <h2 class="date-text">2021-Present</h2>
                    <p>Into our third decade, we continue to evolve and adapt. New generations of gamers join our ranks as we
                        expand into emerging titles while maintaining our core values of community, leadership, and excellence.</p>
                    <div class="game-grid">
                        <span class="game-tag">Hell Let Loose</span>
                        <span class="game-tag">Halo Infinite</span>
                        <span class="game-tag">Squad</span>
                        <span class="game-tag">Valorant</span>
                        <span class="game-tag">Star Wars: Squadrons</span>
                        <span class="game-tag">Conan Exiles</span>
                        <span class="game-tag">New World</span>
                        <span class="game-tag">Final Fantasy XIV</span>
                        <span class="game-tag">Lost Ark</span>
                        <span class="game-tag">Diablo IV</span>
                        <span class="game-tag">BattleBit Remastered</span>
                        <span class="game-tag">Skull and Bones</span>
                        <span class="game-tag">Helldivers 2</span>
                        <span class="game-tag">XDefiant</span>
                        <span class="game-tag">Once Human</span>
                        <span class="game-tag">Bluntz' Reserves</span>
                        <span class="game-tag">Throne and Liberty</span>
                        <span class="game-tag">Delta Force</span>
                        <span class="game-tag">DUNE: Awakening</span>
                        <span class="game-tag">Marvel Rivals</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        var tag = document.createElement("script");
        tag.src = "https://www.youtube.com/iframe_api";
        var modernEraPlayer;
        var foundationsEraPlayer;
        var firstScriptTag = document.getElementsByTagName("script")[0];

        function onYouTubeIframeAPIReady() {
            foundationsEraPlayer = new YT.Player("foundations-era-video", {
                videoId: "KN6yvG9aJsg",
                playerVars: {
                    autoplay: 1,
                    mute: 1,
                    branding: 0,
                    controls: 0,
                    loop: 1,
                    modestbranding: 0,
                    origin: window.location.origin,
                    playsinline: 1,
                    rel: 0,
                    playlist: "KN6yvG9aJsg"
                },
                events: {
                    onReady: onFoundationsEraPlayerReady,
                    onStateChange: onFoundationsEraPlayerStateChange
                }
            });

            modernEraPlayer = new YT.Player("modern-era-video", {
                videoId: "{{ config('aod.hero_video_id') }}",
                playerVars: {
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
                },
                events: {
                    onReady: onModernEraPlayerReady,
                    onStateChange: onModernEraPlayerStateChange
                }
            });
        }

        function scaleEraVideo(videoId, containerId) {
            var iframe = document.getElementById(videoId);
            var container = document.querySelector('[data-era="' + containerId + '"] .era-video');

            if (!iframe || !container || !iframe.tagName || iframe.tagName !== 'IFRAME') {
                setTimeout(function() { scaleEraVideo(videoId, containerId); }, 100);
                return;
            }

            var containerWidth = container.offsetWidth;
            var containerHeight = container.offsetHeight;
            var videoAspectRatio = 16 / 9;

            var videoWidth = containerWidth;
            var videoHeight = containerWidth / videoAspectRatio;

            if (videoHeight < containerHeight) {
                videoHeight = containerHeight;
                videoWidth = containerHeight * videoAspectRatio;
            }

            iframe.style.width = videoWidth + 'px';
            iframe.style.height = videoHeight + 'px';
            iframe.style.position = 'absolute';
            iframe.style.top = '50%';
            iframe.style.left = '50%';
            iframe.style.transform = 'translate(-50%, -50%)';
        }

        function onFoundationsEraPlayerReady(e) {
            e.target.mute();
            e.target.playVideo();
            scaleEraVideo('foundations-era-video', 'foundations');
        }

        function onFoundationsEraPlayerStateChange(e) {
            if (e.data === YT.PlayerState.ENDED) {
                foundationsEraPlayer.playVideo();
            }
        }

        function onModernEraPlayerReady(e) {
            e.target.mute();
            e.target.playVideo();
            scaleEraVideo('modern-era-video', 'modern');
        }

        function onModernEraPlayerStateChange(e) {
            if (e.data === YT.PlayerState.ENDED) {
                modernEraPlayer.playVideo();
            }
        }

        window.addEventListener('resize', function() {
            scaleEraVideo('foundations-era-video', 'foundations');
            scaleEraVideo('modern-era-video', 'modern');
        });

        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    </script>
@endsection
