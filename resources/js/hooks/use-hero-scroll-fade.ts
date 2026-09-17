import { useEffect, type RefObject } from 'react';

/** Fraction of the viewport height scrolled before the fade starts/completes - the hero content
 * should be fully gone well before the real page content (which starts at 50vh) comes into view. */
const FADE_START_VH = 0.25;
const FADE_END_VH = 0.45;

/**
 * Fades the given elements out as the page scrolls between FADE_START_VH and
 * FADE_END_VH (fractions of viewport height), fully hiding (and disabling
 * pointer events on) them past that. Sets styles directly via refs rather
 * than React state, since this runs on every scroll tick.
 */
export function useHeroScrollFade(...refs: RefObject<HTMLElement | null>[]) {
    useEffect(() => {
        function handleScroll() {
            const scrollTop = window.scrollY;
            const fadeStart = window.innerHeight * FADE_START_VH;
            const fadeEnd = window.innerHeight * FADE_END_VH;
            let opacity = 1;

            if (scrollTop >= fadeEnd) {
                opacity = 0;
            } else if (scrollTop >= fadeStart) {
                opacity = 1 - (scrollTop - fadeStart) / (fadeEnd - fadeStart);
            }

            for (const ref of refs) {
                const el = ref.current;
                if (!el) {
                    continue;
                }
                el.style.opacity = String(opacity);
                el.style.pointerEvents = opacity === 0 ? 'none' : '';
            }
        }

        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);
}
