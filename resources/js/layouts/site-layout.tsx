import type { ReactNode } from 'react';

import { ApplyDialogProvider } from '@/components/site/apply-dialog';
import { Footer } from '@/components/site/footer';
import { Nav } from '@/components/site/nav';

interface SiteLayoutProps {
    children: ReactNode;
    /** Pass true on pages with a full-viewport hero directly behind the nav (currently just home). */
    heroNav?: boolean;
}

export function SiteLayout({ children, heroNav = false }: SiteLayoutProps) {
    return (
        <ApplyDialogProvider>
            <div className="flex min-h-screen flex-col">
                <Nav floatOverHero={heroNav} />
                <main className="flex-1">{children}</main>
                <Footer />
            </div>
        </ApplyDialogProvider>
    );
}
