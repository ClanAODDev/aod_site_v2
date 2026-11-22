import { usePage } from '@inertiajs/react';
import { ArrowLeft, ArrowRight, Shield, Users } from 'lucide-react';
import { useEffect, useRef, useState, type CSSProperties } from 'react';

import { ScreenshotGallery } from '@/components/division/screenshot-gallery';
import { NextLayout, nextDivisionHref } from '@/components/next/next-layout';
import { Prose } from '@/components/prose';
import { Reveal } from '@/components/reveal';
import { useOpenApplyDialog } from '@/components/site/apply-dialog';
import type { SharedPageProps } from '@/types';

interface Leader {
    name: string;
    position: string | null;
    rank: string | null;
    rankColor: string | null;
}

interface DivisionDetail {
    name: string;
    slug: string;
    abbreviation: string;
    icon: string | null;
    membersCount: number | null;
    headerImage: string;
    siteContentHtml: string | null;
    screenshots: { url: string; caption?: string }[];
    leadership: Leader[];
}

interface DivisionProps {
    division: DivisionDetail;
    foundedYear: number;
    currentYear: number;
}

function useSectionLinks(html: string | null) {
    const ref = useRef<HTMLDivElement>(null);
    const [links, setLinks] = useState<{ id: string; label: string }[]>([]);

    useEffect(() => {
        const headings = Array.from(ref.current?.querySelectorAll('h2') ?? []);
        setLinks(
            headings.map((heading, index) => {
                heading.id ||= `section-${index}`;
                return { id: heading.id, label: heading.textContent ?? '' };
            }),
        );
    }, [html]);

    return { ref, links };
}

function JoinButton({ className }: { className?: string }) {
    const openApply = useOpenApplyDialog();

    return (
        <button type="button" onClick={openApply} className={className}>
            Join this division <ArrowRight className="size-5" />
        </button>
    );
}

export default function DivisionPage({ division, foundedYear, currentYear }: DivisionProps) {
    const { divisions } = usePage<SharedPageProps>().props;
    const { ref, links } = useSectionLinks(division.siteContentHtml);
    const others = divisions.filter((entry) => entry.slug !== division.slug);

    return (
        <NextLayout title={`${division.name} | Prototype`} foundedYear={foundedYear} currentYear={currentYear}>
            <section className="next-division-hero relative overflow-hidden px-4 pb-16 pt-52 sm:px-6" style={{ '--division-art': `url('${division.headerImage}')` } as CSSProperties}>
                <div className="next-division-art" aria-hidden="true" />
                <div className="relative z-10 mx-auto max-w-6xl">
                    <a href="/next#divisions" className="inline-flex items-center gap-2 font-mono text-xs uppercase tracking-widest text-muted-foreground hover:text-foreground">
                        <ArrowLeft className="size-4" /> All divisions
                    </a>
                    <div className="mt-6 flex flex-col gap-6 sm:flex-row sm:items-center">
                        {division.icon && <img src={division.icon} alt="" className="size-20 shrink-0 object-contain drop-shadow-[0_0_24px_rgba(0,0,0,0.8)]" />}
                        <div>
                            <p className="font-mono text-xs uppercase tracking-[0.3em] next-red-text">AOD Division</p>
                            <h1 className="next-heading mt-1 text-5xl font-bold uppercase leading-none text-foreground sm:text-7xl">{division.name}</h1>
                        </div>
                    </div>
                    <div className="mt-8 flex flex-wrap items-center gap-3">
                        <JoinButton className="next-button next-button-lg" />
                        <span className="next-stat-chip">
                            <Users className="size-4" aria-hidden="true" /> {division.membersCount?.toLocaleString('en-US') ?? '—'} members
                        </span>
                        {division.leadership.length > 0 && (
                            <span className="next-stat-chip">
                                <Shield className="size-4" aria-hidden="true" /> {division.leadership.length} leaders
                            </span>
                        )}
                    </div>
                </div>
            </section>

            <section className="border-t border-border px-4 py-16 sm:px-6">
                <div className="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[1fr_20rem]">
                    <div className="min-w-0">
                        {links.length > 1 && (
                            <nav aria-label="On this page" className="mb-8 flex flex-wrap gap-2">
                                {links.map((link) => (
                                    <a key={link.id} href={`#${link.id}`} className="next-button-ghost min-h-9 px-3 py-1 text-sm">
                                        {link.label}
                                    </a>
                                ))}
                            </nav>
                        )}
                        <div ref={ref} className="next-prose">
                            {division.siteContentHtml ? (
                                <Prose html={division.siteContentHtml} />
                            ) : (
                                <p className="text-muted-foreground">This division hasn't written its page yet. Leaders can add it in the tracker.</p>
                            )}
                        </div>
                        {division.screenshots.length > 0 && (
                            <div className="mt-12">
                                <h2 className="next-heading mb-4 text-3xl font-bold uppercase text-foreground">From the field</h2>
                                <ScreenshotGallery screenshots={division.screenshots} />
                            </div>
                        )}
                    </div>

                    <aside className="flex flex-col gap-4 lg:sticky lg:top-24 lg:self-start">
                        {division.leadership.length > 0 && (
                            <div className="next-panel p-6">
                                <h2 className="next-heading text-2xl font-bold uppercase text-foreground">Leadership</h2>
                                <ul className="mt-4 divide-y divide-border">
                                    {division.leadership.map((leader) => (
                                        <li key={`${leader.name}-${leader.position}`} className="flex items-center gap-3 py-3">
                                            <span className="next-rank" style={{ '--rank-color': leader.rankColor ?? 'var(--border-strong)' } as CSSProperties}>
                                                {leader.rank ?? '—'}
                                            </span>
                                            <span className="min-w-0">
                                                <span className="block truncate font-medium text-foreground">{leader.name}</span>
                                                {leader.position && <span className="block text-xs text-muted-foreground">{leader.position}</span>}
                                            </span>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        )}
                        <div className="next-panel p-6">
                            <h2 className="next-heading text-2xl font-bold uppercase text-foreground">Play with us</h2>
                            <p className="mt-2 text-sm text-muted-foreground">Ready to play? Start an application and we'll get you to the right people.</p>
                            <JoinButton className="next-button mt-4 w-full" />
                        </div>
                    </aside>
                </div>
            </section>

            {others.length > 0 && (
                <section className="border-t border-border bg-card/40 px-4 py-16 sm:px-6">
                    <div className="mx-auto max-w-6xl">
                        <h2 className="next-heading mb-6 text-3xl font-bold uppercase text-foreground">Other divisions</h2>
                        <ul className="flex flex-wrap gap-3">
                            {others.map((entry, index) => (
                                <li key={entry.href}>
                                    <Reveal delay={Math.min(index, 10) * 40}>
                                        <a href={nextDivisionHref(entry.href)} className="next-division min-h-0 gap-3 py-2.5 pl-3 pr-4">
                                            <img src={entry.icon} alt="" className="size-7 object-contain" />
                                            <span className="next-heading text-base font-bold uppercase text-foreground">{entry.name}</span>
                                        </a>
                                    </Reveal>
                                </li>
                            ))}
                        </ul>
                    </div>
                </section>
            )}
        </NextLayout>
    );
}
