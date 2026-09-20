import type { ReactNode } from 'react';

import { cn } from '@/lib/utils';

interface SectionTitleProps {
    children: ReactNode;
    className?: string;
    as?: 'h1' | 'h2';
}

/** Large all-caps section heading in the display face. font-medium (not bold) and normal
 * tracking (not widened) match clanaod.net's own heading treatment - MuseoSans's one bundled
 * cut is 500/medium, so requesting bold would make the browser synthesize a heavier weight it
 * was never cut for, and the live site doesn't widen its letter-spacing either. */
export function SectionTitle({ children, className, as: Tag = 'h2' }: SectionTitleProps) {
    return <Tag className={cn('font-display text-2xl font-medium uppercase md:text-4xl', className)}>{children}</Tag>;
}
