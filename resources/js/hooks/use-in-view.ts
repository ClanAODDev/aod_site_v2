import { useEffect, useRef, useState } from 'react';

interface UseInViewOptions extends IntersectionObserverInit {
    /** Stop observing after the first time the element becomes visible, so a scroll-reveal doesn't replay when scrolling back past it. */
    once?: boolean;
}

/**
 * True while the element intersects the observer's root/margin/threshold.
 * Replaces the old app.js pattern of polling every element's
 * getBoundingClientRect() in a requestAnimationFrame loop.
 */
export function useInView<T extends Element>({ once, ...options }: UseInViewOptions = {}) {
    const ref = useRef<T>(null);
    const [inView, setInView] = useState(false);

    useEffect(() => {
        const el = ref.current;
        if (!el) {
            return;
        }

        const observer = new IntersectionObserver(([entry]) => {
            setInView(entry.isIntersecting);
            if (once && entry.isIntersecting) {
                observer.disconnect();
            }
        }, options);

        observer.observe(el);
        return () => observer.disconnect();
    }, [once]);

    return { ref, inView };
}
