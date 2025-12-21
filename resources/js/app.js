import './bootstrap.js';
import './easyModal.min.js';

'use strict';

window.AOD = window.AOD || {"path": window.location.origin};

function initializeClanAOD() {
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
            this.setupHistoryTimeline();
            this.setupScreenshotGallery();
            this.setupMerchCarousel();
            this.setupVodCarousel();
        },
        addDynamicLinks: function () {
            var twitch = e('body').data('twitch-status') === 'online' ? '<i class="fa fa-circle twitch-live"></i>' : null;
            e('.stream-button').append(twitch);
            var n = '<li class="home"><a href="/" class="text-link">Home</a><img class="clan-logo" src="' + (AOD.path + '/images/') + 'aod_new.png" onclick="window.location.replace(\'/\')"/></li>';
            e('.full-nav ul').prepend(n), e('.mobile-nav ul').prepend('<li class="home"><a href="/" class="text-link">Home</a></li>'), e('.social-media-sites li').click(function () {
                var n = e(this).attr('data-link');
                n && window.open(n);
            });

            e('.hamburger').click(function () {
                e('.nav-items').addClass('active');
                e('.nav-overlay').addClass('active');
                e('.hamburger').hide();
                e('body').css('overflow', 'hidden');
            });

            e('.nav-close, .nav-overlay').click(function () {
                e('.nav-items').removeClass('active');
                e('.nav-overlay').removeClass('active');
                e('.hamburger').show();
                e('body').css('overflow', '');
            });

            e('.nav-items a').click(function () {
                e('.nav-items').removeClass('active');
                e('.nav-overlay').removeClass('active');
                e('.hamburger').show();
                e('body').css('overflow', '');
            });
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
            e(window).bind('scroll', function () {
                var scrollTop = e(window).scrollTop();
                var stayFixed = e('.stay-fixed').length > 0;

                var heroVideo = e('.hero-video');
                var heroText = e('.hero-text');
                if (heroVideo.length > 0) {
                    var fadeStart = 500;
                    var fadeEnd = 700;
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
                    e('.primary-nav').addClass('fixed').find('.full-nav .home').addClass('show-logo');
                } else {
                    e('.primary-nav').removeClass('fixed').find('.full-nav .home').removeClass('show-logo');
                }
            });
        },
        handleModals: function () {

            e('.intro-video').easyModal({
                overlayOpacity: .75,
                overlayColor: '#000',
                autoOpen: !1,
                overlayClose: true,
                closeOnEscape: true,
                onClose: function () {
                    ClanAOD.stopVideo();
                }
            });

            e('.play-button').click(function (n) {
                e('.intro-video').trigger('openModal');
                n.preventDefault();
            });

            e('.close-video').click(function () {
                e('.intro-video').trigger('closeModal');
            });

            e('.apply-form').easyModal({overlayOpacity: .75});

            e('.apply-button').click(function (n) {
                e('.apply-form').trigger('openModal');
                n.preventDefault();
            });
        },
        postYTMessage: function (e) {
            switch (e) {
                case'start':
                    return '{"event":"command","func":"playVideo","args":""}';
                case'stop':
                    return '{"event":"command","func":"stopVideo","args":""}';
            }
        },

        stopVideo: function() {
            var iframe = document.getElementById('video-iframe');
            if (iframe) {
                var src = iframe.src;
                iframe.src = 'about:blank';
                setTimeout(function() {
                    iframe.src = src.replace('autoplay=1', 'autoplay=0');
                }, 50);
            }
        },
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
            var scroll = window.requestAnimationFrame ||
                function (callback) {
                    window.setTimeout(callback, 1000 / 60)
                };
            var elementsToShow = document.querySelectorAll('.animate');
            var timelineEras = document.querySelectorAll('.timeline-era');

            function loop() {

                Array.prototype.forEach.call(elementsToShow, function (element) {
                    if (isElementInViewport(element)) {
                        element.classList.add('animated');
                    } else {
                        element.classList.remove('animated');
                    }
                });

                Array.prototype.forEach.call(timelineEras, function (era) {
                    if (isEraInViewport(era)) {
                        era.classList.add('era-visible');
                    } else {
                        era.classList.remove('era-visible');
                    }
                });

                scroll(loop);
            }

            loop();

            function isElementInViewport(el) {
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

            function isEraInViewport(el) {
                var rect = el.getBoundingClientRect();
                var windowHeight = window.innerHeight || document.documentElement.clientHeight;
                var threshold = windowHeight * 0.3;
                return rect.top < windowHeight - threshold && rect.bottom > threshold;
            }
        },
        setupDivisionEmbeds() {
            $('.division iframe').addClass('youtube-embed')
        },
        scaleHeroVideo: function () {
            window.resizeHeroVideo = function() {
                var $video = e('#video');

                if ($video.length === 0 || !$video.is('iframe')) {
                    setTimeout(window.resizeHeroVideo, 100);
                    return;
                }

                var windowWidth = e(window).width();
                var windowHeight = e(window).height();
                var videoAspectRatio = 16 / 9;
                var windowAspectRatio = windowWidth / windowHeight;

                var scaleX = windowWidth / (windowHeight * videoAspectRatio);
                var scaleY = windowHeight / (windowWidth / videoAspectRatio);

                var scale = Math.max(scaleX, scaleY);

                scale = Math.max(scale, 1.01);

                var videoWidth = windowWidth * scale;
                var videoHeight = windowHeight * scale;

                if (videoWidth / videoHeight > videoAspectRatio) {
                    videoHeight = videoWidth / videoAspectRatio;
                } else {
                    videoWidth = videoHeight * videoAspectRatio;
                }

                $video.css({
                    'width': videoWidth + 'px',
                    'height': videoHeight + 'px',
                    'transform': 'translate(-50%, -50%)',
                    'top': '50%',
                    'left': '50%',
                    'position': 'absolute'
                });
            };

            window.resizeHeroVideo();

            e(window).resize(function() {
                window.resizeHeroVideo();
            });
        },
        setupHistoryTimeline: function() {
            if (!document.body.classList.contains('page-template-page-history')) {
                return;
            }

            if (typeof window.YT === 'undefined') {
                var tag = document.createElement("script");
                tag.src = "https://www.youtube.com/iframe_api";
                var firstScriptTag = document.getElementsByTagName("script")[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            }

            window.eraPlayers = {};

            window.onYouTubeIframeAPIReady = function() {
                var foundationsVideoId = document.querySelector('meta[name="foundations-era-video-id"]')?.content || 'KN6yvG9aJsg';
                var modernVideoId = document.querySelector('meta[name="modern-era-video-id"]')?.content || 'XHgfL_Av_r4';

                ClanAOD.initializeEraPlayer('foundations', 'foundations-era-video', foundationsVideoId);
                ClanAOD.initializeEraPlayer('modern', 'modern-era-video', modernVideoId);
            };

            e(window).resize(function() {
                ClanAOD.scaleEraVideo('foundations-era-video', 'foundations');
                ClanAOD.scaleEraVideo('modern-era-video', 'modern');
            });
        },
        initializeEraPlayer: function(eraName, elementId, videoId) {
            window.eraPlayers[eraName] = new YT.Player(elementId, {
                videoId: videoId,
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
                    playlist: videoId
                },
                events: {
                    onReady: function(event) {
                        ClanAOD.onEraPlayerReady(event, elementId, eraName);
                    },
                    onStateChange: function(event) {
                        ClanAOD.onEraPlayerStateChange(event, eraName);
                    }
                }
            });
        },
        scaleEraVideo: function(videoId, containerId) {
            var iframe = document.getElementById(videoId);
            var container = document.querySelector('[data-era="' + containerId + '"] .era-video');

            if (!iframe || !container || !iframe.tagName || iframe.tagName !== 'IFRAME') {
                setTimeout(function() { ClanAOD.scaleEraVideo(videoId, containerId); }, 100);
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
        },
        onEraPlayerReady: function(event, elementId, eraName) {
            event.target.mute();
            event.target.playVideo();
            ClanAOD.scaleEraVideo(elementId, eraName);
        },
        onEraPlayerStateChange: function(event, eraName) {
            if (event.data === YT.PlayerState.ENDED) {
                window.eraPlayers[eraName].playVideo();
            }
        },
        setupScreenshotGallery: function() {
            var galleryItems = e('[data-lightbox]');
            if (galleryItems.length === 0) return;

            var overlay = e('#lightbox-overlay');
            var lightboxImage = e('#lightbox-image');
            var lightboxCaption = e('#lightbox-caption');
            var lightboxCounter = e('#lightbox-counter');
            var currentIndex = 0;
            var images = [];

            galleryItems.each(function() {
                images.push({
                    url: e(this).attr('href'),
                    caption: e(this).data('caption') || ''
                });
            });

            function showImage(index) {
                if (index < 0) index = images.length - 1;
                if (index >= images.length) index = 0;
                currentIndex = index;

                lightboxImage.attr('src', images[index].url);
                lightboxCaption.text(images[index].caption);
                lightboxCounter.text((index + 1) + ' / ' + images.length);
            }

            function openLightbox(index) {
                showImage(index);
                overlay.addClass('active');
                e('body').css('overflow', 'hidden');
            }

            function closeLightbox() {
                overlay.removeClass('active');
                e('body').css('overflow', '');
            }

            galleryItems.on('click', function(event) {
                event.preventDefault();
                var index = parseInt(e(this).data('index'), 10);
                openLightbox(index);
            });

            overlay.find('.lightbox-close').on('click', closeLightbox);
            overlay.find('.lightbox-prev').on('click', function() { showImage(currentIndex - 1); });
            overlay.find('.lightbox-next').on('click', function() { showImage(currentIndex + 1); });

            overlay.on('click', function(event) {
                if (event.target === overlay[0]) {
                    closeLightbox();
                }
            });

            e(document).on('keydown', function(event) {
                if (!overlay.hasClass('active')) return;
                if (event.key === 'Escape') closeLightbox();
                if (event.key === 'ArrowLeft') showImage(currentIndex - 1);
                if (event.key === 'ArrowRight') showImage(currentIndex + 1);
            });

            ClanAOD.setupScreenshotCarousel();
        },
        setupMerchCarousel: function() {
            var container = e('.merch-carousel');
            if (container.length === 0) return;

            var viewport = container.find('.merch-viewport');
            var grid = container.find('.merch-grid');
            var items = grid.find('.merch-item');
            var prevBtn = container.find('.merch-prev');
            var nextBtn = container.find('.merch-next');
            var currentOffset = 0;
            var isScrolling = true;
            var scrollSpeed = 0.5;
            var originalSetWidth = 0;

            var touchStartX = 0;
            var touchStartY = 0;
            var touchStartOffset = 0;
            var isTouching = false;
            var isHorizontalSwipe = null;
            var resumeTimer = null;

            items.clone().appendTo(grid);

            function calculateSetWidth() {
                originalSetWidth = 0;
                var gap = 25;
                items.each(function() {
                    originalSetWidth += e(this).outerWidth(true) + gap;
                });
            }

            function normalizeOffset() {
                if (currentOffset >= originalSetWidth) {
                    currentOffset -= originalSetWidth;
                } else if (currentOffset < 0) {
                    currentOffset += originalSetWidth;
                }
            }

            function continuousScroll() {
                if (isScrolling && !isTouching) {
                    currentOffset += scrollSpeed;
                    normalizeOffset();
                    grid.css('transform', 'translateX(-' + currentOffset + 'px)');
                }

                requestAnimationFrame(continuousScroll);
            }

            prevBtn.on('click', function() {
                currentOffset -= items.first().outerWidth(true);
                normalizeOffset();
                grid.css('transform', 'translateX(-' + currentOffset + 'px)');
            });

            nextBtn.on('click', function() {
                currentOffset += items.first().outerWidth(true);
                normalizeOffset();
                grid.css('transform', 'translateX(-' + currentOffset + 'px)');
            });

            container.on('mouseenter', function() {
                isScrolling = false;
            });

            container.on('mouseleave', function() {
                isScrolling = true;
            });

            viewport[0].addEventListener('touchstart', function(evt) {
                isTouching = true;
                isHorizontalSwipe = null;
                if (resumeTimer) {
                    clearTimeout(resumeTimer);
                    resumeTimer = null;
                }
                touchStartX = evt.touches[0].clientX;
                touchStartY = evt.touches[0].clientY;
                touchStartOffset = currentOffset;
            }, { passive: true });

            viewport[0].addEventListener('touchmove', function(evt) {
                if (!isTouching) return;
                var touchX = evt.touches[0].clientX;
                var touchY = evt.touches[0].clientY;
                var deltaX = Math.abs(touchX - touchStartX);
                var deltaY = Math.abs(touchY - touchStartY);

                if (isHorizontalSwipe === null && (deltaX > 5 || deltaY > 5)) {
                    isHorizontalSwipe = deltaX > deltaY;
                }

                if (isHorizontalSwipe) {
                    evt.preventDefault();
                    var delta = touchStartX - touchX;
                    currentOffset = touchStartOffset + delta;
                    normalizeOffset();
                    grid.css('transform', 'translateX(-' + currentOffset + 'px)');
                }
            }, { passive: false });

            viewport[0].addEventListener('touchend', function() {
                isTouching = false;
                isHorizontalSwipe = null;
                resumeTimer = setTimeout(function() {
                    isScrolling = true;
                }, 2500);
                isScrolling = false;
            }, { passive: true });

            e(window).on('resize', function() {
                calculateSetWidth();
            });

            calculateSetWidth();
            continuousScroll();
        },
        setupScreenshotCarousel: function() {
            var container = e('.carousel-container');
            if (container.length === 0) return;

            var viewport = container.find('.carousel-viewport');
            var grid = container.find('.gallery-grid');
            var items = grid.find('.gallery-item');
            var prevBtn = container.find('.carousel-prev');
            var nextBtn = container.find('.carousel-next');
            var dotsContainer = e('.carousel-dots');
            var currentPage = 0;

            function getItemsPerPage() {
                var windowWidth = e(window).width();
                if (windowWidth <= 480) return 1;
                if (windowWidth <= 720) return 2;
                return 3;
            }

            function getTotalPages() {
                var itemsPerPage = getItemsPerPage();
                return Math.ceil(items.length / itemsPerPage);
            }

            function updateCarousel() {
                var itemsPerPage = getItemsPerPage();
                var totalPages = getTotalPages();

                if (currentPage >= totalPages) currentPage = totalPages - 1;
                if (currentPage < 0) currentPage = 0;

                var itemWidth = items.first().outerWidth(true);
                var offset = currentPage * itemsPerPage * itemWidth;
                grid.css('transform', 'translateX(-' + offset + 'px)');

                prevBtn.prop('disabled', currentPage === 0);
                nextBtn.prop('disabled', currentPage >= totalPages - 1);

                dotsContainer.find('.dot').removeClass('active').eq(currentPage).addClass('active');
            }

            function createDots() {
                var totalPages = getTotalPages();
                dotsContainer.empty();

                if (totalPages <= 1) return;

                for (var i = 0; i < totalPages; i++) {
                    var dot = e('<button class="dot" aria-label="Go to page ' + (i + 1) + '"></button>');
                    dot.data('page', i);
                    dotsContainer.append(dot);
                }

                dotsContainer.find('.dot').on('click', function() {
                    currentPage = e(this).data('page');
                    updateCarousel();
                });
            }

            prevBtn.on('click', function() {
                if (currentPage > 0) {
                    currentPage--;
                    updateCarousel();
                }
            });

            nextBtn.on('click', function() {
                if (currentPage < getTotalPages() - 1) {
                    currentPage++;
                    updateCarousel();
                }
            });

            e(window).on('resize', function() {
                createDots();
                updateCarousel();
            });

            createDots();
            updateCarousel();
        },
        setupVodCarousel: function() {
            var container = e('.vod-carousel');
            if (container.length === 0) return;

            var viewport = container.find('.vod-viewport');
            var grid = container.find('.vod-grid');
            var items = grid.find('.vod-item');
            var prevBtn = container.find('.vod-prev');
            var nextBtn = container.find('.vod-next');
            var currentOffset = 0;
            var isScrolling = true;
            var scrollSpeed = 0.3;
            var originalSetWidth = 0;

            var touchStartX = 0;
            var touchStartY = 0;
            var touchStartOffset = 0;
            var isTouching = false;
            var isHorizontalSwipe = null;
            var resumeTimer = null;

            items.clone().appendTo(grid);

            function calculateSetWidth() {
                originalSetWidth = 0;
                var gap = 20;
                items.each(function() {
                    originalSetWidth += e(this).outerWidth(true) + gap;
                });
            }

            function normalizeOffset() {
                if (currentOffset >= originalSetWidth) {
                    currentOffset -= originalSetWidth;
                } else if (currentOffset < 0) {
                    currentOffset += originalSetWidth;
                }
            }

            function continuousScroll() {
                if (isScrolling && !isTouching) {
                    currentOffset += scrollSpeed;
                    normalizeOffset();
                    grid.css('transform', 'translateX(-' + currentOffset + 'px)');
                }

                requestAnimationFrame(continuousScroll);
            }

            prevBtn.on('click', function() {
                currentOffset -= items.first().outerWidth(true);
                normalizeOffset();
                grid.css('transform', 'translateX(-' + currentOffset + 'px)');
            });

            nextBtn.on('click', function() {
                currentOffset += items.first().outerWidth(true);
                normalizeOffset();
                grid.css('transform', 'translateX(-' + currentOffset + 'px)');
            });

            container.on('mouseenter', function() {
                isScrolling = false;
            });

            container.on('mouseleave', function() {
                isScrolling = true;
            });

            viewport[0].addEventListener('touchstart', function(evt) {
                isTouching = true;
                isHorizontalSwipe = null;
                if (resumeTimer) {
                    clearTimeout(resumeTimer);
                    resumeTimer = null;
                }
                touchStartX = evt.touches[0].clientX;
                touchStartY = evt.touches[0].clientY;
                touchStartOffset = currentOffset;
            }, { passive: true });

            viewport[0].addEventListener('touchmove', function(evt) {
                if (!isTouching) return;
                var touchX = evt.touches[0].clientX;
                var touchY = evt.touches[0].clientY;
                var deltaX = Math.abs(touchX - touchStartX);
                var deltaY = Math.abs(touchY - touchStartY);

                if (isHorizontalSwipe === null && (deltaX > 5 || deltaY > 5)) {
                    isHorizontalSwipe = deltaX > deltaY;
                }

                if (isHorizontalSwipe) {
                    evt.preventDefault();
                    var delta = touchStartX - touchX;
                    currentOffset = touchStartOffset + delta;
                    normalizeOffset();
                    grid.css('transform', 'translateX(-' + currentOffset + 'px)');
                }
            }, { passive: false });

            viewport[0].addEventListener('touchend', function() {
                isTouching = false;
                isHorizontalSwipe = null;
                resumeTimer = setTimeout(function() {
                    isScrolling = true;
                }, 2500);
                isScrolling = false;
            }, { passive: true });

            e(window).on('resize', function() {
                calculateSetWidth();
            });

            calculateSetWidth();
            continuousScroll();
        },
    };
    }($);

    ClanAOD.setup();
    ClanAOD.smoothScroll();
    ClanAOD.setupHistoryTimeline();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeClanAOD);
} else {
    initializeClanAOD();
}
