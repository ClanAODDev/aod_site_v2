import { Menu } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';

import { useOpenApplyDialog } from '@/components/site/apply-dialog';
import { Button } from '@/components/ui/button';
import { Sheet, SheetContent, SheetHeader, SheetTitle } from '@/components/ui/sheet';

const links = [
    { label: 'Forums', href: '/forums' },
    { label: 'Divisions', href: '/divisions' },
    { label: 'History', href: '/history' },
    { label: 'Fallen Angels', href: '/fallen-angels' },
];

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

            <header className="nav-hatch sticky top-0 z-40 border-b border-border bg-gradient-to-b from-card/95 to-background/90 backdrop-blur-md">
                <div className="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">
                    <a href="/" className="flex items-center gap-2">
                        {stuck ? (
                            <img src="/images/aod_new.png" alt="Angels of Death" className="h-9 w-auto" />
                        ) : (
                            <span className="text-sm font-medium text-foreground/80 transition-colors hover:text-foreground">Home</span>
                        )}
                    </a>

                    <nav className="hidden items-center md:flex">
                        <div className="flex items-center divide-x divide-border-strong/60">
                            {links.map((link) => (
                                <a
                                    key={link.href}
                                    href={link.href}
                                    className="px-4 text-sm font-medium text-foreground/80 transition-colors hover:text-foreground"
                                >
                                    {link.label}
                                </a>
                            ))}
                        </div>
                        <Button size="sm" className="ml-6" onClick={openApply}>
                            Apply
                        </Button>
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
