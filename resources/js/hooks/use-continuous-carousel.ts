import { useEffect, useRef } from 'react';

import { useMediaQuery } from '@/hooks/use-media-query';

interface UseContinuousCarouselOptions {
    /** Pixels advanced per animation frame while idle. */
    speed?: number;
    /** Gap (px) added between the two cloned item sets when measuring one full cycle's width. */
    gap?: number;
}

/**
 * Marquee-style auto-scrolling carousel: the track's children are rendered
 * twice back to back, and this continuously translates the track by one
 * item-set's width, wrapping to 0 for a seamless loop. Pauses on hover and
 * while touch-dragging; drag also lets the user manually scrub the offset.
 *
 * Replaces three near-identical jQuery implementations (merch, VOD, and the
 * old screenshot carousel) that only differed in speed/gap/class names.
 *
 * Honours `prefers-reduced-motion`: the auto-scroll never starts, but the
 * prev/next buttons and touch-drag still work.
 */
export function useContinuousCarousel<T extends HTMLElement>({ speed = 0.5, gap = 20 }: UseContinuousCarouselOptions = {}) {
    const viewportRef = useRef<T>(null);
    const trackRef = useRef<HTMLDivElement>(null);
    const offset = useRef(0);
    const setWidth = useRef(0);
    const paused = useRef(false);
    const reduceMotion = useMediaQuery('(prefers-reduced-motion: reduce)');

    useEffect(() => {
        const track = trackRef.current;
        const viewport = viewportRef.current;
        if (!track || !viewport) {
            return;
        }

        let touching = false;
        let horizontalSwipe: boolean | null = null;
        let touchStartX = 0;
        let touchStartY = 0;
        let touchStartOffset = 0;
        let resumeTimer: ReturnType<typeof setTimeout> | null = null;
        let frame: number;

        function measure() {
            const items = Array.from(track!.children) as HTMLElement[];
            const half = items.slice(0, items.length / 2);
            setWidth.current = half.reduce((total, item) => total + item.offsetWidth + gap, 0);
        }

        function normalize() {
            if (offset.current >= setWidth.current) {
                offset.current -= setWidth.current;
            } else if (offset.current < 0) {
                offset.current += setWidth.current;
            }
        }

        function render() {
            track!.style.transform = `translateX(-${offset.current}px)`;
        }

        function tick() {
            if (!paused.current && !touching) {
                offset.current += speed;
                normalize();
                render();
            }
            frame = requestAnimationFrame(tick);
        }

        function onTouchStart(event: TouchEvent) {
            touching = true;
            horizontalSwipe = null;
            if (resumeTimer) {
                clearTimeout(resumeTimer);
            }
            touchStartX = event.touches[0].clientX;
            touchStartY = event.touches[0].clientY;
            touchStartOffset = offset.current;
        }

        function onTouchMove(event: TouchEvent) {
            if (!touching) {
                return;
            }
            const x = event.touches[0].clientX;
            const y = event.touches[0].clientY;
            const deltaX = Math.abs(x - touchStartX);
            const deltaY = Math.abs(y - touchStartY);

            if (horizontalSwipe === null && (deltaX > 5 || deltaY > 5)) {
                horizontalSwipe = deltaX > deltaY;
            }

            if (horizontalSwipe) {
                event.preventDefault();
                offset.current = touchStartOffset + (touchStartX - x);
                normalize();
                render();
            }
        }

        function onTouchEnd() {
            touching = false;
            horizontalSwipe = null;
            resumeTimer = setTimeout(() => {
                paused.current = false;
            }, 2500);
        }

        const resizeObserver = new ResizeObserver(measure);
        resizeObserver.observe(track);
        measure();
        if (!reduceMotion) {
            frame = requestAnimationFrame(tick);
        }

        viewport.addEventListener('touchstart', onTouchStart, { passive: true });
        viewport.addEventListener('touchmove', onTouchMove, { passive: false });
        viewport.addEventListener('touchend', onTouchEnd, { passive: true });

        return () => {
            cancelAnimationFrame(frame);
            resizeObserver.disconnect();
            viewport.removeEventListener('touchstart', onTouchStart);
            viewport.removeEventListener('touchmove', onTouchMove);
            viewport.removeEventListener('touchend', onTouchEnd);
            if (resumeTimer) {
                clearTimeout(resumeTimer);
            }
        };
    }, [speed, gap, reduceMotion]);

    function step(direction: 1 | -1) {
        const track = trackRef.current;
        if (!track) {
            return;
        }
        const firstItem = track.children[0] as HTMLElement | undefined;
        if (!firstItem) {
            return;
        }
        offset.current += direction * (firstItem.offsetWidth + gap);
        if (offset.current >= setWidth.current) {
            offset.current -= setWidth.current;
        } else if (offset.current < 0) {
            offset.current += setWidth.current;
        }
        track.style.transform = `translateX(-${offset.current}px)`;
    }

    return {
        viewportRef,
        trackRef,
        onMouseEnter: () => {
            paused.current = true;
        },
        onMouseLeave: () => {
            paused.current = false;
        },
        prev: () => step(-1),
        next: () => step(1),
    };
}
