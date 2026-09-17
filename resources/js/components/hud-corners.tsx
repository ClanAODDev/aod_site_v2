import { cn } from '@/lib/utils';

interface HudCornersProps {
    /** Applied to all four corner marks - use to control color/thickness/transition together. */
    className?: string;
}

/** Four small L-shaped corner marks framing the parent (which needs `relative`), for a
 * targeting-reticle/HUD readout look in place of a plain box border. */
export function HudCorners({ className }: HudCornersProps) {
    const corners = [
        'top-0 left-0 border-t border-l',
        'top-0 right-0 border-t border-r',
        'bottom-0 left-0 border-b border-l',
        'bottom-0 right-0 border-b border-r',
    ];

    return (
        <>
            {corners.map((position) => (
                <span key={position} aria-hidden className={cn('pointer-events-none absolute size-3', position, className)} />
            ))}
        </>
    );
}
