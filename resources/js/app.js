require('./bootstrap');

'use strict';
var ClanAOD = ClanAOD || {};
!function (e) {
    ClanAOD = {
        setup: function () {
            this.addDynamicLinks();
            this.stickyNav();
            this.handleModals();
            this.initAutoMenu();
            this.handleApplicationLinks();
            this.handleViewportAnimations();
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
            e(window).bind('scroll', function () {
                e('.stay-fixed').length > 0 ? e('.stay-fixed').find('.full-nav .home').addClass('show-logo') : e(window).scrollTop() > 700 ? e('.primary-nav').addClass('fixed').find('.full-nav .home').addClass('show-logo') : e('.primary-nav').removeClass('fixed').find('.full-nav .home').removeClass('show-logo');
            });
        },
        handleModals: function () {
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
            }), e('.play-button').click(function (n) {
                e('.intro-video').trigger('openModal'), n.preventDefault();
            }), e('.close-video').click(function () {
                e('.intro-video').trigger('closeModal');
            }), e('.apply-form').easyModal({overlayOpacity: .75}), e('.apply-button').click(function (n) {
                e('.apply-form').trigger('openModal'), n.preventDefault();
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
        }
    };
}(jQuery), ClanAOD.setup(), ClanAOD.smoothScroll();
