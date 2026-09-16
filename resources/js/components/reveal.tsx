import type { ReactNode } from 'react';

import { useInView } from '@/hooks/use-in-view';
import { cn } from '@/lib/utils';

const HIDDEN_TRANSFORM = {
    left: 'translateX(-40px)',
    right: 'translateX(40px)',
    bottom: 'translateY(30px)',
    up: 'translateY(-30px)',
};

interface RevealProps {
    children: ReactNode;
    from?: keyof typeof HIDDEN_TRANSFORM;
    delay?: number;
    className?: string;
}

/** Fades/slides its children in once they scroll into view. */
export function Reveal({ children, from = 'bottom', delay = 0, className }: RevealProps) {
    const { ref, inView } = useInView<HTMLDivElement>({ once: true, rootMargin: '0px 0px -10% 0px' });

    return (
        <div
            ref={ref}
            className={cn('transition-all duration-700 ease-out', className)}
            style={{
                opacity: inView ? 1 : 0,
                transform: inView ? 'translate(0, 0)' : HIDDEN_TRANSFORM[from],
                transitionDelay: `${delay}ms`,
            }}
        >
            {children}
        </div>
    );
}
