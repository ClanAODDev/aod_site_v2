import { Head } from '@inertiajs/react';
import type { ReactNode } from 'react';

import { AodMark } from '@/components/next/aod-mark';
import { NextNav } from '@/components/next/next-nav';
import { ApplyDialogProvider } from '@/components/site/apply-dialog';

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
        <ApplyDialogProvider>
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
                        <p className="font-mono text-xs uppercase tracking-widest">
                            Prototype · <a href="/" className="next-red-text hover:underline">Back to the current site</a>
                        </p>
                    </div>
                </footer>
            </div>
        </ApplyDialogProvider>
    );
}
