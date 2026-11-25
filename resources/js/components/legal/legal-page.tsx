import { usePage } from '@inertiajs/react';
import type { ReactNode } from 'react';

import { NextLayout } from '@/components/next/next-layout';
import { SectionLinks } from '@/components/next/section-links';
import { useSectionLinks } from '@/hooks/use-section-links';
import type { SharedPageProps } from '@/types';

interface LegalPageProps {
    title: string;
    children: ReactNode;
}

export function LegalPage({ title, children }: LegalPageProps) {
    const { foundedYear, currentYear } = usePage<SharedPageProps>().props;
    const { ref, links } = useSectionLinks();

    return (
        <NextLayout title={`${title} | Angels of Death`} foundedYear={foundedYear} currentYear={currentYear}>
            <section className="relative">
                <div className="relative z-10 mx-auto max-w-4xl px-4 pt-32 pb-20 sm:px-6">
                    <SectionLinks links={links} />

                    <div ref={ref} className="next-prose prose-tron">
                        {children}
                    </div>
                </div>
            </section>
        </NextLayout>
    );
}
