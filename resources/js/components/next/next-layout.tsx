import { Head } from '@inertiajs/react';
import type { CSSProperties, ReactNode } from 'react';

import { AodMark } from '@/components/next/aod-mark';
import { NextNav } from '@/components/next/next-nav';
import { ApplyDialogProvider } from '@/components/site/apply-dialog';
import { socialLinks } from '@/components/site/footer';

interface NextLayoutProps {
    title: string;
    foundedYear: number;
    currentYear: number;
    children: ReactNode;
}

export function nextDivisionHref(href: string): string {
    return href.replace(/^.*\/divisions\//, '/next/divisions/');
}

export function NextLayout({ title, foundedYear, currentYear, children }: NextLayoutProps) {
    return (
        <ApplyDialogProvider variant="next">
            <Head title={title}>
                <meta name="robots" content="noindex, nofollow" />
            </Head>
            <div className="next-root min-h-screen bg-background text-foreground">
                <NextNav />
                <main>{children}</main>
                <footer className="border-t border-border px-4 py-10 sm:px-6">
                    <div className="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 text-sm text-muted-foreground sm:flex-row">
                        <a href="/next" className="flex items-center gap-3 hover:text-foreground">
                            <AodMark className="size-6" />
                            <span>
                                Angels of Death · {foundedYear}–{currentYear}
                            </span>
                        </a>
                        <ul className="flex items-center gap-2" aria-label="AOD on social media">
                            {socialLinks.map(({ name, href, Icon, color }) => (
                                <li key={name}>
                                    <a
                                        href={href}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label={name}
                                        title={name}
                                        className="next-social"
                                        style={{ '--brand': color } as CSSProperties}
                                    >
                                        <Icon className="size-4" aria-hidden="true" />
                                    </a>
                                </li>
                            ))}
                        </ul>
                        <p className="font-mono text-xs tracking-widest uppercase">
                            Prototype ·{' '}
                            <a href="/" className="next-red-text hover:underline">
                                Back to the current site
                            </a>
                        </p>
                    </div>
                </footer>
            </div>
        </ApplyDialogProvider>
    );
}
