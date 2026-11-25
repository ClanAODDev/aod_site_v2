import { ChevronDown, Menu, X } from 'lucide-react';
import { useEffect, useState } from 'react';

import { AodMark } from '@/components/next/aod-mark';
import { useOpenApplyDialog } from '@/components/site/apply-dialog';
import { cn } from '@/lib/utils';

interface NavLink {
    label: string;
    href: string;
    description?: string;
    children?: NavLink[];
}

export const NEXT_LINKS: NavLink[] = [
    {
        label: 'Values',
        href: '/#values',
        children: [
            { label: 'Code of Conduct', href: '/code-of-conduct', description: 'The standard every member agrees to.' },
            { label: 'Ranking Structure', href: '/ranks', description: 'Every rank, from Recruit to Sergeant Major.' },
        ],
    },
    { label: 'History', href: '/#timeline' },
    { label: 'Divisions', href: '/#divisions' },
    { label: 'Stream', href: '/#stream' },
    { label: 'Fallen Angels', href: '/fallen-angels' },
    { label: 'Forums', href: 'https://www.clanaod.net/forums' },
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
                scrolled || open ? 'border-b border-border bg-background/95' : 'bg-transparent',
            )}
        >
            <div className="mx-auto flex h-16 max-w-7xl items-center gap-6 px-4 sm:px-6">
                <a href="/" className="flex items-center gap-3">
                    <AodMark className="size-8" />
                    <span className="next-heading text-base font-bold tracking-[0.18em] whitespace-nowrap text-foreground uppercase sm:text-lg">
                        Angels of Death
                    </span>
                </a>
                <nav className="ml-auto hidden items-center gap-6 lg:flex" aria-label="Main">
                    {NEXT_LINKS.map((link) =>
                        link.children ? (
                            <div key={link.href} className="group relative">
                                <a
                                    href={link.href}
                                    className="inline-flex items-center gap-1 text-sm text-muted-foreground transition-colors group-hover:text-foreground hover:text-foreground"
                                >
                                    {link.label}
                                    <ChevronDown
                                        className="size-3.5 transition-transform duration-200 group-focus-within:rotate-180 group-hover:rotate-180"
                                        aria-hidden="true"
                                    />
                                </a>
                                <div className="invisible absolute top-full left-1/2 z-50 -translate-x-1/2 pt-4 opacity-0 transition-all duration-200 group-focus-within:visible group-focus-within:opacity-100 group-hover:visible group-hover:opacity-100">
                                    <ul className="next-panel w-72 bg-background p-2 shadow-2xl">
                                        {link.children.map((child) => (
                                            <li key={child.href}>
                                                <a
                                                    href={child.href}
                                                    className="block px-3 py-2.5 transition-colors hover:bg-white/5 focus-visible:bg-white/5"
                                                >
                                                    <span className="next-heading block text-base font-bold tracking-wide text-foreground uppercase">
                                                        {child.label}
                                                    </span>
                                                    <span className="block text-xs text-muted-foreground">{child.description}</span>
                                                </a>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            </div>
                        ) : (
                            <a key={link.href} href={link.href} className="text-sm text-muted-foreground transition-colors hover:text-foreground">
                                {link.label}
                            </a>
                        ),
                    )}
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
                <nav className="border-t border-border px-4 pt-2 pb-6 lg:hidden" aria-label="Main">
                    {NEXT_LINKS.map((link) => (
                        <div key={link.href}>
                            <a href={link.href} onClick={() => setOpen(false)} className="block py-3 text-base text-foreground">
                                {link.label}
                            </a>
                            {link.children?.map((child) => (
                                <a
                                    key={child.href}
                                    href={child.href}
                                    onClick={() => setOpen(false)}
                                    className="block border-l border-border py-2.5 pl-4 text-sm text-muted-foreground"
                                >
                                    {child.label}
                                </a>
                            ))}
                        </div>
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
