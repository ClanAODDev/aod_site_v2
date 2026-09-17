import { useEffect, useState } from 'react';

/** True once the page has scrolled past `threshold` pixels. */
export function usePastScrollThreshold(threshold: number) {
    const [past, setPast] = useState(false);

    useEffect(() => {
        function handleScroll() {
            setPast(window.scrollY > threshold);
        }

        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();
        return () => window.removeEventListener('scroll', handleScroll);
    }, [threshold]);

    return past;
}
