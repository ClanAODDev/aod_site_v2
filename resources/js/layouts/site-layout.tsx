import type { ReactNode } from 'react';

import { ApplyDialogProvider } from '@/components/site/apply-dialog';
import { Footer } from '@/components/site/footer';
import { Nav } from '@/components/site/nav';

export function SiteLayout({ children }: { children: ReactNode }) {
    return (
        <ApplyDialogProvider>
            <div className="flex min-h-screen flex-col">
                <Nav />
                <main className="flex-1">{children}</main>
                <Footer />
            </div>
        </ApplyDialogProvider>
    );
}
