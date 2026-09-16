import { useEffect, type RefObject } from 'react';

const FADE_START = 500;
const FADE_END = 700;

/**
 * Fades the given elements out as the page scrolls between FADE_START and
 * FADE_END, fully hiding (and disabling pointer events on) them past that.
 * Sets styles directly via refs rather than React state, since this runs on
 * every scroll tick.
 */
export function useHeroScrollFade(...refs: RefObject<HTMLElement | null>[]) {
    useEffect(() => {
        function handleScroll() {
            const scrollTop = window.scrollY;
            let opacity = 1;

            if (scrollTop >= FADE_END) {
                opacity = 0;
            } else if (scrollTop >= FADE_START) {
                opacity = 1 - (scrollTop - FADE_START) / (FADE_END - FADE_START);
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
