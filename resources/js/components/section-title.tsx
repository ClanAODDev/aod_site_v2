import type { ReactNode } from 'react';

import { cn } from '@/lib/utils';

interface SectionTitleProps {
    children: ReactNode;
    className?: string;
    as?: 'h1' | 'h2';
}

/** Large all-caps section heading in the HUD monospace face, for a more technical/futuristic feel than the body sans font. */
export function SectionTitle({ children, className, as: Tag = 'h2' }: SectionTitleProps) {
    return (
        <Tag className={cn('font-mono text-2xl font-medium tracking-[0.06em] uppercase md:text-4xl', className)}>{children}</Tag>
    );
}
