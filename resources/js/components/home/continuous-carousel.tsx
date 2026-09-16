import { ChevronLeft, ChevronRight } from 'lucide-react';
import type { ReactNode } from 'react';

import { useContinuousCarousel } from '@/hooks/use-continuous-carousel';
import { cn } from '@/lib/utils';

interface ContinuousCarouselProps<T> {
    items: T[];
    keyFor: (item: T) => string;
    renderItem: (item: T) => ReactNode;
    speed?: number;
    gap?: number;
    navHoverClassName?: string;
}

export function ContinuousCarousel<T>({ items, keyFor, renderItem, speed = 0.5, gap = 20, navHoverClassName }: ContinuousCarouselProps<T>) {
    const { viewportRef, trackRef, onMouseEnter, onMouseLeave, prev, next } = useContinuousCarousel<HTMLDivElement>({ speed, gap });

    if (items.length === 0) {
        return null;
    }

    const doubled = [...items, ...items];
    const navClass = cn(
        'flex size-11 shrink-0 items-center justify-center rounded-full border border-border-strong bg-white/10 text-foreground transition-colors max-md:hidden',
        navHoverClassName,
    );

    return (
        <div className="my-10 flex items-center gap-4" onMouseEnter={onMouseEnter} onMouseLeave={onMouseLeave}>
            <button onClick={prev} aria-label="Previous items" className={navClass}>
                <ChevronLeft />
            </button>

            <div ref={viewportRef} className="flex-1 overflow-hidden [mask-image:linear-gradient(to_right,transparent,black_8%,black_92%,transparent)]">
                <div ref={trackRef} className="flex w-max" style={{ gap: `${gap}px` }}>
                    {doubled.map((item, index) => (
                        <div key={`${keyFor(item)}-${index}`} className="shrink-0">
                            {renderItem(item)}
                        </div>
                    ))}
                </div>
            </div>

            <button onClick={next} aria-label="Next items" className={navClass}>
                <ChevronRight />
            </button>
        </div>
    );
}
