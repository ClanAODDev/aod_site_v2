import './bootstrap.js';
import './easyModal.min.js';

'use strict';

// Set up AOD global configuration
window.AOD = window.AOD || {"path": window.location.origin};

// Initialize ClanAOD when everything is ready
function initializeClanAOD() {
    console.log('Initializing ClanAOD...');
    console.log('jQuery available:', typeof window.$ !== 'undefined');
    console.log('easyModal available:', typeof window.$.fn.easyModal !== 'undefined');

    if (typeof window.$ === 'undefined') {
        console.error('jQuery is not available!');
        return;
    }

    var $ = window.$;
    var ClanAOD = {};

    !function (e) {
    ClanAOD = {
        setup: function () {
            this.addDynamicLinks();
            this.stickyNav();
            this.handleModals();
            this.initAutoMenu();
            this.handleApplicationLinks();
            this.handleViewportAnimations();
            this.setupDivisionEmbeds();
            this.scaleHeroVideo();
        },
        addDynamicLinks: function () {
            var twitch = e('body').data('twitch-status') === 'online' ? '<i class="fa fa-circle twitch-live"></i>' : null;
            e('.stream-button').append(twitch);
            var n = '<li class="home"><a href="/" class="text-link">Home</a><img class="clan-logo" src="' + (AOD.path + '/images/') + 'aod_new.png" onclick="window.location.replace(\'/\')"/></li>';
            e('.full-nav ul').prepend(n), e('.mobile-nav ul').prepend('<li class="home"><a href="/" class="text-link">Home</a></li>'), e('.social-media-sites li').click(function () {
                var n = e(this).attr('data-link');
                n && window.open(n);
            }), e('.hamburger').click(function () {
                e('.nav-items').fadeToggle();
            });

            // if (meta.'clan-twitch-status' === 'online') {
            //   alert('woooo')
            // } else {
            //   alert('nahhh')
            // }
        },
        smoothScroll: function () {
            e('.smooth-scroll').click(function (n) {
                n.preventDefault();
                var t = e(this).attr('href'), o = e(t).offset().top - 90;
                e('html, body').stop().animate({scrollTop: o}, 750);
            });
        },
        handleApplicationLinks: function () {
            e('*[data-application-link]').click(function (n) {
                n.preventDefault();
                var t = e(this).data('application-id') ? e(this).data('application-id') : e('.division').data('application-id');
                return null == t ? (alert('Division application id is not set!'), !1) : void window.open('/forums/forms.php?do=form&fid=' + t);
            });
        },
        initAutoMenu: function () {
            e('#sub-nav').length && ClanAOD.handleAutoMenu('sub-nav', 'h2');
        },
        stickyNav: function () {
            console.log('Setting up sticky nav...');
            e(window).bind('scroll', function () {
                var scrollTop = e(window).scrollTop();
                var stayFixed = e('.stay-fixed').length > 0;
                console.log('Scroll event - scrollTop:', scrollTop, 'stayFixed:', stayFixed);

                // Handle hero video and text fade based on scroll position
                var heroVideo = e('.hero-video');
                var heroText = e('.hero-text');
                if (heroVideo.length > 0) {
                    var fadeStart = 500; // Start fading at 500px
                    var fadeEnd = 700;   // Fully faded at 700px
                    var opacity = 1;

                    if (scrollTop >= fadeEnd) {
                        opacity = 0;
                    } else if (scrollTop >= fadeStart) {
                        opacity = 1 - ((scrollTop - fadeStart) / (fadeEnd - fadeStart));
                    }

                    heroVideo.css('opacity', opacity);
                    heroText.css('opacity', opacity);
                }

                if (stayFixed) {
                    e('.stay-fixed').find('.full-nav .home').addClass('show-logo');
                } else if (scrollTop > 700) {
                    console.log('Adding fixed class to primary-nav');
                    e('.primary-nav').addClass('fixed').find('.full-nav .home').addClass('show-logo');
                } else {
                    console.log('Removing fixed class from primary-nav');
                    e('.primary-nav').removeClass('fixed').find('.full-nav .home').removeClass('show-logo');
                }
            });
        },
        handleModals: function () {
            console.log('Setting up modals...');
            console.log('Apply form elements found:', e('.apply-form').length);
            console.log('Apply button elements found:', e('.apply-button').length);
            console.log('easyModal available:', typeof e.fn.easyModal !== 'undefined');

            // Set up intro video modal
            e('.intro-video').easyModal({
                overlayOpacity: .75,
                overlayColor: '#000',
                autoOpen: !1,
                onClose: function () {
                    document.getElementById('video-iframe').contentWindow.postMessage(ClanAOD.postYTMessage('stop'), '*');
                },
                onOpen: function () {
                    document.getElementById('video-iframe').contentWindow.postMessage(ClanAOD.postYTMessage('start'), '*');
                }
            });

            e('.play-button').click(function (n) {
                console.log('Play button clicked!');
                e('.intro-video').trigger('openModal');
                n.preventDefault();
            });

            e('.close-video').click(function () {
                e('.intro-video').trigger('closeModal');
            });

            // Set up apply form modal
            e('.apply-form').easyModal({overlayOpacity: .75});

            e('.apply-button').click(function (n) {
                console.log('Apply button clicked!');
                e('.apply-form').trigger('openModal');
                n.preventDefault();
            });
        },
        /**
         * Hero video play functionality
         *
         * @param e
         * @returns {string}
         */
        postYTMessage: function (e) {
            switch (e) {
                case'start':
                    return '{"event":"command","func":"playVideo","args":""}';
                case'stop':
                    return '{"event":"command","func":"stopVideo","args":""}';
            }
        },
        /**
         * Divisional sub-header links
         *
         * @param n
         * @param t
         */
        handleAutoMenu: function (n, t) {
            var o = document.getElementById(n), i = e('.automenu h2');
            if (i.length >= 1) {
                for (var a = document.createElement('UL'), l = 0; l < i.length; l++) {
                    var s = '';
                    i[l].id ? s = i[l].id : (s = 'section_' + l, i[l].setAttribute('id', s));
                    var d = i[l].firstChild.nodeValue;
                    i[l].firstChild.nodeValue = d;
                    var c = document.createElement('A');
                    c.setAttribute('href', '#' + s), c.setAttribute('class', 'smooth-scroll'), c.appendChild(document.createTextNode(d));
                    var r = document.createElement('LI');
                    r.appendChild(c), a.appendChild(r);
                }
                for (; o.hasChildNodes();) o.removeChild(o.firstChild);
                o.appendChild(a);
            }
        },
        handleViewportAnimations: function () {
            // Detect request animation frame
            var scroll = window.requestAnimationFrame ||
                // IE Fallback
                function (callback) {
                    window.setTimeout(callback, 1000 / 60)
                };
            var elementsToShow = document.querySelectorAll('.animate');

            function loop() {

                Array.prototype.forEach.call(elementsToShow, function (element) {
                    if (isElementInViewport(element)) {
                        element.classList.add('animated');
                    } else {
                        element.classList.remove('animated');
                    }
                });

                scroll(loop);
            }

            loop();

            function isElementInViewport(el) {
                // special bonus for those using jQuery
                if (typeof jQuery === "function" && el instanceof jQuery) {
                    el = el[0];
                }
                var rect = el.getBoundingClientRect();
                return (
                    (rect.top <= 0
                        && rect.bottom >= 0)
                    ||
                    (rect.bottom >= (window.innerHeight || document.documentElement.clientHeight) &&
                        rect.top <= (window.innerHeight || document.documentElement.clientHeight))
                    ||
                    (rect.top >= 0 &&
                        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight))
                );
            }
        },
        setupDivisionEmbeds() {
            // find a way to do this with embed/embed later
            $('.division iframe').addClass('youtube-embed')
        },
        scaleHeroVideo: function () {
            console.log('Setting up hero video scaling...');

            // Store reference to resize function for external access
            window.resizeHeroVideo = function() {
                // YouTube API replaces the div with an iframe that has the same ID
                var $video = e('#video');
                console.log('Resize attempt - Element found:', $video.length > 0, 'Is iframe:', $video.is('iframe'), 'Tag name:', $video.prop('tagName'));

                if ($video.length === 0 || !$video.is('iframe')) {
                    // Video not loaded yet, try again in a moment
                    console.log('Video not ready, retrying in 100ms...');
                    setTimeout(window.resizeHeroVideo, 100);
                    return;
                }

                var windowWidth = e(window).width();
                var windowHeight = e(window).height();
                var videoAspectRatio = 16 / 9;
                var windowAspectRatio = windowWidth / windowHeight;

                console.log('Resizing video - Window:', windowWidth + 'x' + windowHeight, 'Aspect:', windowAspectRatio);

                // Calculate scale factors for both dimensions
                var scaleX = windowWidth / (windowHeight * videoAspectRatio);
                var scaleY = windowHeight / (windowWidth / videoAspectRatio);

                // Use the larger scale factor to ensure complete coverage
                var scale = Math.max(scaleX, scaleY);

                // Apply scale with a small buffer to ensure no gaps
                scale = Math.max(scale, 1.01);

                var videoWidth = windowWidth * scale;
                var videoHeight = windowHeight * scale;

                // Ensure video maintains 16:9 aspect ratio
                if (videoWidth / videoHeight > videoAspectRatio) {
                    videoHeight = videoWidth / videoAspectRatio;
                } else {
                    videoWidth = videoHeight * videoAspectRatio;
                }

                // Apply the calculated dimensions with transform-based centering
                $video.css({
                    'width': videoWidth + 'px',
                    'height': videoHeight + 'px',
                    'transform': 'translate(-50%, -50%)',
                    'top': '50%',
                    'left': '50%',
                    'position': 'absolute'
                });

                console.log('Video scaled to:', videoWidth + 'x' + videoHeight);
                console.log('Coverage check - Width covers:', (videoWidth >= windowWidth), 'Height covers:', (videoHeight >= windowHeight));
            };

            // Initial resize
            window.resizeHeroVideo();

            // Resize on window resize
            e(window).resize(function() {
                window.resizeHeroVideo();
            });
        }
    };
    }($);

    // Initialize ClanAOD functionality
    ClanAOD.setup();
    ClanAOD.smoothScroll();
}

// Wait for DOM to be ready, then initialize
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeClanAOD);
} else {
    // DOM is already ready
    initializeClanAOD();
}
