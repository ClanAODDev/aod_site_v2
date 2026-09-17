import { Menu } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';

import { useOpenApplyDialog } from '@/components/site/apply-dialog';
import { Button } from '@/components/ui/button';
import { Sheet, SheetContent, SheetHeader, SheetTitle } from '@/components/ui/sheet';
import { cn } from '@/lib/utils';

const links = [
    { label: 'Forums', href: '/forums' },
    { label: 'Divisions', href: '/divisions' },
    { label: 'History', href: '/history' },
    { label: 'Fallen Angels', href: '/fallen-angels' },
];

const itemClass = 'px-5 text-base font-medium tracking-wide text-foreground/70 uppercase transition-colors hover:text-foreground';

interface NavProps {
    /** True on pages where the nav starts in normal document flow, below the fold, rather than
     * immediately stuck at the top (currently just home). While not yet stuck, the home link shows
     * as plain text instead of the logo, matching what it swaps to once it docks. */
    startsUnstuck?: boolean;
}

export function Nav({ startsUnstuck = false }: NavProps) {
    const [mobileOpen, setMobileOpen] = useState(false);
    const openApply = useOpenApplyDialog();
    const sentinelRef = useRef<HTMLDivElement>(null);
    const [stuck, setStuck] = useState(!startsUnstuck);

    useEffect(() => {
        const sentinel = sentinelRef.current;
        if (!startsUnstuck || !sentinel) {
            return;
        }

        const observer = new IntersectionObserver(([entry]) => setStuck(!entry.isIntersecting), { threshold: 0 });
        observer.observe(sentinel);
        return () => observer.disconnect();
    }, [startsUnstuck]);

    return (
        <>
            {startsUnstuck && <div ref={sentinelRef} aria-hidden className="h-px" />}

            <header className="nav-hatch sticky top-0 z-40 border-b border-border bg-gradient-to-b from-popover to-card backdrop-blur-md">
                <div className="mx-auto flex h-20 max-w-6xl items-center justify-between px-4 md:justify-center">
                    <a href="/" className="flex items-center gap-2 md:hidden">
                        <img src="/images/aod_new.png" alt="Angels of Death" className="h-11 w-auto" />
                    </a>

                    <nav className="hidden items-center divide-x divide-border-strong/60 md:flex">
                        <a href="/" className={cn(itemClass, 'flex items-center')}>
                            {stuck ? <img src="/images/aod_new.png" alt="Home" className="h-9 w-auto" /> : 'Home'}
                        </a>
                        {links.map((link) => (
                            <a key={link.href} href={link.href} className={itemClass}>
                                {link.label}
                            </a>
                        ))}
                        <button onClick={openApply} className={cn(itemClass, 'font-semibold text-primary hover:text-primary/80')}>
                            Apply
                        </button>
                    </nav>

                    <Button variant="ghost" size="icon" className="md:hidden" onClick={() => setMobileOpen(true)} aria-label="Open menu">
                        <Menu />
                    </Button>
                </div>

                <Sheet open={mobileOpen} onOpenChange={setMobileOpen}>
                    <SheetContent side="right">
                        <SheetHeader>
                            <SheetTitle>
                                <img src="/images/aod_new.png" alt="Angels of Death" className="h-8 w-auto" />
                            </SheetTitle>
                        </SheetHeader>
                        <nav className="flex flex-col gap-1 px-4">
                            {links.map((link) => (
                                <a
                                    key={link.href}
                                    href={link.href}
                                    className="rounded-md px-3 py-2.5 text-sm font-medium text-foreground/80 transition-colors hover:bg-accent hover:text-foreground"
                                    onClick={() => setMobileOpen(false)}
                                >
                                    {link.label}
                                </a>
                            ))}
                            <Button
                                className="mt-2"
                                onClick={() => {
                                    setMobileOpen(false);
                                    openApply();
                                }}
                            >
                                Apply
                            </Button>
                        </nav>
                    </SheetContent>
                </Sheet>
            </header>
        </>
    );
}
