import { useEffect, useState, type RefObject } from 'react';

import { useOpenApplyDialog } from '@/components/site/apply-dialog';
import { cn } from '@/lib/utils';

interface MenuItem {
    id: string;
    label: string;
}

/**
 * Builds a jump-nav from the <h2>s inside a rendered-markdown container,
 * assigning each one an id if it doesn't already have one.
 */
function useAutoMenu(containerRef: RefObject<HTMLElement | null>) {
    const [items, setItems] = useState<MenuItem[]>([]);

    useEffect(() => {
        const container = containerRef.current;
        if (!container) {
            return;
        }

        const headings = Array.from(container.querySelectorAll('h2'));
        setItems(
            headings.map((heading, index) => {
                if (!heading.id) {
                    heading.id = `section_${index}`;
                }
                return { id: heading.id, label: heading.textContent ?? '' };
            }),
        );
    }, [containerRef]);

    return items;
}

export function AutoMenu({ containerRef, className }: { containerRef: RefObject<HTMLElement | null>; className?: string }) {
    const items = useAutoMenu(containerRef);
    const openApply = useOpenApplyDialog();

    if (items.length === 0) {
        return null;
    }

    const pillClass =
        'inline-block rounded-full border px-4 py-2 text-xs font-medium tracking-wide uppercase opacity-30 transition-opacity hover:opacity-100';

    return (
        <nav className={cn('flex flex-wrap gap-3', className)}>
            {items.map((item) => (
                <a key={item.id} href={`#${item.id}`} className={cn(pillClass, 'border-foreground text-foreground')}>
                    {item.label}
                </a>
            ))}
            <button
                onClick={openApply}
                className={cn(pillClass, 'border-primary bg-gradient-to-br from-primary to-primary/80 text-primary-foreground opacity-100 hover:shadow-[0_0_15px_var(--primary-glow)]')}
            >
                Apply
            </button>
        </nav>
    );
}
