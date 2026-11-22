import type { ReactNode } from 'react';

interface PageHeroProps {
    eyebrow: string;
    title: ReactNode;
    children: ReactNode;
}

export function PageHero({ eyebrow, title, children }: PageHeroProps) {
    return (
        <section className="next-page-hero relative overflow-hidden px-4 pt-40 pb-20 text-center sm:px-6">
            <span className="next-mark next-page-hero-mark" aria-hidden="true" />
            <div className="next-scanlines" aria-hidden="true" />
            <div className="relative z-10 mx-auto flex max-w-3xl flex-col items-center">
                <p className="next-red-text mb-4 font-mono text-xs tracking-[0.35em] uppercase sm:text-sm">{eyebrow}</p>
                <h1 className="next-heading text-5xl leading-none font-bold tracking-wide text-foreground uppercase sm:text-7xl">{title}</h1>
                <div className="mt-6 text-lg leading-relaxed text-balance text-muted-foreground sm:text-xl">{children}</div>
            </div>
        </section>
    );
}
