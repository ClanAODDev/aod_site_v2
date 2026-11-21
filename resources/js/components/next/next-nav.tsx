import { Menu, X } from 'lucide-react';
import { useEffect, useState } from 'react';

import { AodMark } from '@/components/next/aod-mark';
import { useOpenApplyDialog } from '@/components/site/apply-dialog';
import { cn } from '@/lib/utils';

export const NEXT_LINKS = [
    { label: 'Legacy', href: '#legacy' },
    { label: 'Divisions', href: '#divisions' },
    { label: 'Values', href: '#values' },
    { label: 'History', href: '/history' },
    { label: 'Forums', href: 'https://www.clanaod.net/forums' },
    { label: 'Tracker', href: 'https://tracker.clanaod.net' },
];

export function NextNav() {
    const openApply = useOpenApplyDialog();
    const [scrolled, setScrolled] = useState(false);
    const [open, setOpen] = useState(false);

    useEffect(() => {
        const onScroll = () => setScrolled(window.scrollY > 24);
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
        return () => window.removeEventListener('scroll', onScroll);
    }, []);

    return (
        <header
            className={cn(
                'fixed inset-x-0 top-0 z-40 transition-colors duration-300',
                scrolled || open ? 'border-b border-border bg-background/90 backdrop-blur-md' : 'bg-transparent',
            )}
        >
            <div className="mx-auto flex h-16 max-w-7xl items-center gap-6 px-4 sm:px-6">
                <a href="#top" className="flex items-center gap-3">
                    <AodMark className="size-8" />
                    <span className="next-heading whitespace-nowrap text-base font-bold uppercase tracking-[0.18em] text-foreground sm:text-lg">Angels of Death</span>
                </a>
                <span className="hidden rounded-sm border border-primary/50 px-2 py-0.5 font-mono text-[10px] uppercase tracking-widest next-red-text sm:inline">
                    Prototype
                </span>
                <nav className="ml-auto hidden items-center gap-6 lg:flex" aria-label="Main">
                    {NEXT_LINKS.map((link) => (
                        <a key={link.href} href={link.href} className="text-sm text-muted-foreground transition-colors hover:text-foreground">
                            {link.label}
                        </a>
                    ))}
                </nav>
                <button type="button" onClick={openApply} className="next-button ml-auto hidden lg:ml-0 lg:inline-flex">
                    Join AOD
                </button>
                <button
                    type="button"
                    className="ml-auto inline-flex size-11 items-center justify-center text-foreground lg:hidden"
                    aria-label={open ? 'Close menu' : 'Open menu'}
                    aria-expanded={open}
                    onClick={() => setOpen((value) => !value)}
                >
                    {open ? <X className="size-6" /> : <Menu className="size-6" />}
                </button>
            </div>
            {open && (
                <nav className="border-t border-border px-4 pb-6 pt-2 lg:hidden" aria-label="Main">
                    {NEXT_LINKS.map((link) => (
                        <a key={link.href} href={link.href} onClick={() => setOpen(false)} className="block py-3 text-base text-foreground">
                            {link.label}
                        </a>
                    ))}
                    <button
                        type="button"
                        onClick={() => {
                            setOpen(false);
                            openApply();
                        }}
                        className="next-button mt-3 w-full"
                    >
                        Join AOD
                    </button>
                </nav>
            )}
        </header>
    );
}
