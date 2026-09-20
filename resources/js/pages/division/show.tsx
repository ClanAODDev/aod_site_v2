import { Head } from '@inertiajs/react';
import { useRef } from 'react';

import { AutoMenu } from '@/components/division/auto-menu';
import { ScreenshotGallery } from '@/components/division/screenshot-gallery';
import { Prose } from '@/components/prose';
import { SectionTitle } from '@/components/section-title';
import { SiteLayout } from '@/layouts/site-layout';

interface DivisionDetail {
    name: string;
    icon: string;
    headerImage: string;
    siteContentHtml: string | null;
    screenshots?: { url: string; caption?: string }[];
}

interface DivisionShowProps {
    division: DivisionDetail;
}

export default function DivisionShow({ division }: DivisionShowProps) {
    const contentRef = useRef<HTMLDivElement>(null);

    return (
        <SiteLayout>
            <Head title={`${division.name} Division`} />

            <section
                className="division-hero pt-8"
                style={{ '--division-header-image': `url('${division.headerImage}')` } as React.CSSProperties}
            >
                <div className="relative z-10 mx-auto max-w-5xl px-4 py-16">
                    <div className="mt-[116px] mb-8 flex flex-wrap items-center gap-4">
                        <img src={division.icon} alt={`${division.name} Division`} className="size-12 shrink-0 object-contain" />
                        <SectionTitle as="h1" className="text-left">
                            {division.name} Division
                        </SectionTitle>
                    </div>

                    <AutoMenu containerRef={contentRef} className="mb-8" />

                    <hr className="mb-8 border-border" />

                    <div ref={contentRef}>
                        {division.siteContentHtml ? (
                            <Prose html={division.siteContentHtml} />
                        ) : (
                            <p className="text-muted-foreground">Division content coming soon.</p>
                        )}
                    </div>

                    <ScreenshotGallery screenshots={division.screenshots ?? []} />
                </div>
            </section>
        </SiteLayout>
    );
}
