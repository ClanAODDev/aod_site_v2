import type { ReactNode } from 'react';

interface PageHeroProps {
    eyebrow: string;
    title: ReactNode;
    children: ReactNode;
}

export function PageHero({ eyebrow, title, children }: PageHeroProps) {
    return (
        <section className="next-page-hero relative overflow-hidden px-4 pb-20 pt-40 text-center sm:px-6">
            <span className="next-mark next-page-hero-mark" aria-hidden="true" />
            <div className="next-scanlines" aria-hidden="true" />
            <div className="relative z-10 mx-auto flex max-w-3xl flex-col items-center">
                <p className="mb-4 font-mono text-xs uppercase tracking-[0.35em] next-red-text sm:text-sm">{eyebrow}</p>
                <h1 className="next-heading text-5xl font-bold uppercase leading-none tracking-wide text-foreground sm:text-7xl">{title}</h1>
                <div className="mt-6 text-balance text-lg leading-relaxed text-muted-foreground sm:text-xl">{children}</div>
            </div>
        </section>
    );
}
