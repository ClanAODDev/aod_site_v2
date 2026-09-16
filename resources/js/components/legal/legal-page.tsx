import { Head } from '@inertiajs/react';
import { useRef, type ReactNode } from 'react';

import { AutoMenu } from '@/components/division/auto-menu';
import { SiteLayout } from '@/layouts/site-layout';

interface LegalPageProps {
    title: string;
    children: ReactNode;
}

export function LegalPage({ title, children }: LegalPageProps) {
    const contentRef = useRef<HTMLDivElement>(null);

    return (
        <SiteLayout>
            <Head title={title} />

            <section className="legal-hero relative">
                <div className="relative z-10 mx-auto max-w-4xl px-4 py-16">
                    <AutoMenu containerRef={contentRef} className="mb-8" />

                    <div ref={contentRef} className="prose-tron">
                        {children}
                    </div>
                </div>
            </section>
        </SiteLayout>
    );
}
