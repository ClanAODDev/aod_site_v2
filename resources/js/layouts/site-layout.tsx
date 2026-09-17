import type { ReactNode } from 'react';

import { ApplyDialogProvider } from '@/components/site/apply-dialog';
import { Footer } from '@/components/site/footer';
import { Nav } from '@/components/site/nav';

interface SiteLayoutProps {
    children: ReactNode;
    /** Pages with a full-viewport hero (currently just home) place `<Nav />` themselves, right after
     * the hero, so it starts in normal document flow below the fold and only becomes sticky once
     * scrolled to - pass true here to skip rendering it in the usual spot. */
    heroNav?: boolean;
}

export function SiteLayout({ children, heroNav = false }: SiteLayoutProps) {
    return (
        <ApplyDialogProvider>
            <div className="flex min-h-screen flex-col">
                {!heroNav && <Nav />}
                <main className="flex-1">{children}</main>
                <Footer />
            </div>
        </ApplyDialogProvider>
    );
}
