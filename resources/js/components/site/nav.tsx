import { Menu } from 'lucide-react';
import { useState } from 'react';

import { useOpenApplyDialog } from '@/components/site/apply-dialog';
import { Button } from '@/components/ui/button';
import { Sheet, SheetContent, SheetHeader, SheetTitle } from '@/components/ui/sheet';

const links = [
    { label: 'Forums', href: '/forums' },
    { label: 'Divisions', href: '/divisions' },
    { label: 'History', href: '/history' },
    { label: 'Fallen Angels', href: '/fallen-angels' },
];

export function Nav() {
    const [mobileOpen, setMobileOpen] = useState(false);
    const openApply = useOpenApplyDialog();

    return (
        <header className="sticky top-0 z-40 border-b border-border bg-background/80 backdrop-blur-md">
            <div className="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">
                <a href="/" className="flex items-center gap-2">
                    <img src="/images/aod_new.png" alt="Angels of Death" className="h-9 w-auto" />
                </a>

                <nav className="hidden items-center gap-6 md:flex">
                    {links.map((link) => (
                        <a key={link.href} href={link.href} className="text-sm font-medium text-foreground/80 transition-colors hover:text-foreground">
                            {link.label}
                        </a>
                    ))}
                    <Button size="sm" onClick={openApply}>
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
    );
}
