import { usePage } from '@inertiajs/react';
import { ArrowDown, ArrowLeft, ArrowRight, Crown, Flame, Pause, Play, Shield, Users } from 'lucide-react';
import { useEffect, useMemo, useRef, useState, type ReactNode } from 'react';

import { DiscordIcon } from '@/components/icons/discord-icon';
import { AodMark } from '@/components/next/aod-mark';
import { CoverVideo } from '@/components/next/cover-video';
import { IntroVideo } from '@/components/next/intro-video';
import { NextLayout, nextDivisionHref } from '@/components/next/next-layout';
import { StreamSection, type TwitchData } from '@/components/next/stream-section';
import { Reveal } from '@/components/reveal';
import { useOpenApplyDialog } from '@/components/site/apply-dialog';
import { useInView } from '@/hooks/use-in-view';
import { useMediaQuery } from '@/hooks/use-media-query';
import { historyEras } from '@/lib/history-eras';
import { cn } from '@/lib/utils';
import type { SharedPageProps } from '@/types';

interface DiscordStats {
    online?: number;
    idle?: number;
    dnd?: number;
    total?: number;
}

interface PrototypeProps {
    discord: DiscordStats | null;
    twitch: TwitchData;
    heroVideoId: string | null;
    introVideoId: string | null;
    historyVideoId: string | null;
    foundedYear: number;
    currentYear: number;
}

const VALUES = [
    {
        icon: Users,
        title: 'Community',
        body: 'A people-focused culture came first, before any single game. Members stay for the people long after a title fades.',
    },
    {
        icon: Crown,
        title: 'Leadership',
        body: 'Strong, reliable leadership carried AOD from two founders to thousands of members across the globe.',
    },
    {
        icon: Shield,
        title: 'Excellence',
        body: 'From world championship titles to well-run divisions, we hold ourselves to a standard worth belonging to.',
    },
    {
        icon: Flame,
        title: 'Adaptation',
        body: 'New games bring new challenges. Adaptation is the pillar of survival, and the reason we are still here.',
    },
];

function formatCount(value: number | undefined): string {
    return typeof value === 'number' ? value.toLocaleString('en-US') : '—';
}

function SectionHeading({ eyebrow, title, children }: { eyebrow: string; title: ReactNode; children?: ReactNode }) {
    return (
        <div className="relative mx-auto mb-12 max-w-3xl text-center">
            <p className="mb-3 font-mono text-xs uppercase tracking-[0.3em] next-red-text">{eyebrow}</p>
            <h2 className="next-heading text-4xl font-bold uppercase tracking-wide text-foreground sm:text-5xl">{title}</h2>
            {children && <p className="mt-4 text-balance text-base leading-relaxed text-muted-foreground sm:text-lg">{children}</p>}
        </div>
    );
}

function Hero({
    years,
    foundedYear,
    discord,
    divisionCount,
    videoId,
    introVideoId,
}: {
    years: number;
    foundedYear: number;
    discord: DiscordStats | null;
    divisionCount: number;
    videoId: string | null;
    introVideoId: string | null;
}) {
    const openApply = useOpenApplyDialog();
    const stats = [
        { value: `${years}`, label: 'Years strong' },
        { value: `${divisionCount || '—'}`, label: 'Active divisions' },
        { value: formatCount(discord?.total), label: 'On Discord' },
        { value: formatCount(discord?.online), label: 'Online now', live: true },
    ];

    return (
        <section id="top" className="next-hero relative flex min-h-svh flex-col items-center justify-center overflow-hidden px-4 pb-16 pt-28 text-center">
            <CoverVideo videoId={videoId} />
            <div className="next-triangles" aria-hidden="true">
                <span />
                <span />
                <span />
            </div>
            <div className="next-scanlines" aria-hidden="true" />

            <div className="relative z-10 flex flex-col items-center">
                <AodMark className="next-mark-glow mb-8 size-36 sm:size-44" />
                <p className="mb-4 font-mono text-xs uppercase tracking-[0.35em] next-red-text sm:text-sm">
                    Est. {foundedYear} · {years} years of play
                </p>
                <h1 className="next-heading text-6xl font-bold uppercase leading-none tracking-wide text-foreground sm:text-8xl">
                    Angels <span className="text-primary">of</span> Death
                </h1>
                <p className="mt-6 max-w-2xl text-balance text-lg leading-relaxed text-muted-foreground sm:text-xl">
                    A multi-game community that has outlasted the games that made it. Built on respect and leadership, still adapting to whatever comes next.
                </p>
                <div className="mt-10 flex flex-col gap-3 sm:flex-row">
                    <button type="button" onClick={openApply} className="next-button next-button-lg">
                        Join the ranks <ArrowRight className="size-5" />
                    </button>
                    <a href="#legacy" className="next-button-ghost next-button-lg">
                        Explore our legacy <ArrowDown className="size-5" />
                    </a>
                </div>
                <div className="mt-8">
                    <IntroVideo videoId={introVideoId} />
                </div>
            </div>

            <dl className="relative z-10 mt-16 grid w-full max-w-4xl grid-cols-2 border border-border bg-background/60 backdrop-blur-sm sm:grid-cols-4">
                {stats.map((stat) => (
                    <div key={stat.label} className="border-border px-4 py-5 [&:not(:last-child)]:border-r max-sm:[&:nth-child(2)]:border-r-0 max-sm:[&:nth-child(-n+2)]:border-b">
                        <dt className="flex items-center justify-center gap-2 font-mono text-[11px] uppercase tracking-widest text-muted-foreground">
                            {stat.live && <span className="next-live-dot" aria-hidden="true" />}
                            {stat.label}
                        </dt>
                        <dd className="next-heading mt-1 text-3xl font-bold text-foreground sm:text-4xl">{stat.value}</dd>
                    </div>
                ))}
            </dl>
        </section>
    );
}

function Legacy({ foundedYear }: { foundedYear: number }) {
    return (
        <section id="legacy" className="relative border-t border-border px-4 py-24 sm:px-6">
            <SectionHeading eyebrow="Then and now" title="The crest changed. The standard didn't.">
                The original Angels of Death crest flew over servers before most of today's games existed. The modern mark keeps its shape: the triangle, the ring, the blood red.
            </SectionHeading>

            <div className="mx-auto grid max-w-5xl items-center gap-6 md:grid-cols-[1fr_auto_1fr]">
                <Reveal from="left">
                    <figure className="next-panel flex flex-col items-center p-8">
                        <img src="/images/official-logo.png" alt="The original Angels of Death crest" width={250} height={250} className="size-56 object-contain" />
                        <figcaption className="mt-6 text-center">
                            <span className="next-heading block text-3xl font-bold text-foreground">{foundedYear}</span>
                            <span className="font-mono text-xs uppercase tracking-widest text-muted-foreground">The original crest</span>
                        </figcaption>
                    </figure>
                </Reveal>
                <div className="flex justify-center text-primary" aria-hidden="true">
                    <ArrowRight className="size-8 max-md:rotate-90" />
                </div>
                <Reveal from="right">
                    <figure className="next-panel flex flex-col items-center p-8">
                        <div className="flex size-56 items-center justify-center">
                            <AodMark className="next-mark-glow size-44" title="The modern Angels of Death mark" />
                        </div>
                        <figcaption className="mt-6 text-center">
                            <span className="next-heading block text-3xl font-bold text-foreground">Today</span>
                            <span className="font-mono text-xs uppercase tracking-widest text-muted-foreground">The modern mark</span>
                        </figcaption>
                    </figure>
                </Reveal>
            </div>
        </section>
    );
}

const ERA_SECONDS = 15;

function Timeline({ years, videoId }: { years: number; videoId: string | null }) {
    const periods = useMemo(() => historyEras({ foundations: '', modern: '' }).flatMap((era) => era.entries), []);
    const titleCount = useMemo(() => new Set(periods.flatMap((period) => period.tags.map((tag) => tag.label))).size, [periods]);
    const [active, setActive] = useState(0);
    const [cycle, setCycle] = useState(0);
    const [hovered, setHovered] = useState(false);
    const [paused, setPaused] = useState(false);
    const calm = useMediaQuery('(prefers-reduced-motion: reduce)');
    const railRef = useRef<HTMLDivElement>(null);
    const { ref, inView } = useInView<HTMLDivElement>({ rootMargin: '0px 0px -20% 0px' });
    const period = periods[active];
    const last = periods.length - 1;
    const playing = inView && !hovered && !paused && !calm;

    useEffect(() => {
        const rail = railRef.current;
        const stop = rail?.children[active] as HTMLElement | undefined;
        if (rail && stop && rail.scrollWidth > rail.clientWidth) {
            rail.scrollTo({ left: stop.offsetLeft - 16, behavior: 'smooth' });
        }
    }, [active]);

    const advance = () => setActive((index) => (index >= last ? 0 : index + 1));

    const choose = (index: number) => {
        setActive(Math.max(0, Math.min(index, last)));
        setCycle((value) => value + 1);
    };

    return (
        <section id="timeline" className="relative overflow-hidden border-t border-border bg-card/40 px-4 py-24 sm:px-6">
            <CoverVideo videoId={videoId} className="is-faint" />
            <SectionHeading eyebrow="The long game" title={`${years} years in the making`}>
                Two founders became thousands of members across {titleCount} titles and counting. Pick an era.
            </SectionHeading>

            <div ref={ref} className="relative mx-auto max-w-6xl" onMouseEnter={() => setHovered(true)} onMouseLeave={() => setHovered(false)}>
                {!calm && (
                    <div className="mb-3 flex justify-end">
                        <button type="button" onClick={() => setPaused((value) => !value)} className="inline-flex min-h-9 items-center gap-1.5 font-mono text-xs uppercase tracking-widest text-muted-foreground hover:text-foreground" aria-pressed={paused}>
                            {paused ? <Play className="size-3.5" aria-hidden="true" /> : <Pause className="size-3.5" aria-hidden="true" />}
                            {paused ? 'Play' : 'Pause'}
                        </button>
                    </div>
                )}
                <div ref={railRef} className="next-rail" role="tablist" aria-label="Eras of AOD">
                    {periods.map((entry, index) => (
                        <button
                            key={entry.title}
                            type="button"
                            role="tab"
                            id={`era-tab-${index}`}
                            aria-selected={index === active}
                            aria-controls="era-panel"
                            onClick={() => choose(index)}
                            className={cn('next-rail-stop', index === active && 'is-active', index < active && 'is-passed')}
                        >
                            <span className="next-rail-dot" aria-hidden="true" />
                            {index === active && (
                                <span
                                    key={cycle}
                                    className="next-rail-progress"
                                    style={{ animationDuration: `${ERA_SECONDS}s`, animationPlayState: playing ? 'running' : 'paused' }}
                                    onAnimationEnd={advance}
                                    aria-hidden="true"
                                />
                            )}
                            <span className="font-mono text-xs text-muted-foreground">{entry.dateRange}</span>
                            <span className="next-heading text-base font-bold uppercase tracking-wide text-foreground">{entry.title}</span>
                        </button>
                    ))}
                </div>

                <div id="era-panel" role="tabpanel" aria-labelledby={`era-tab-${active}`} aria-live="polite" className="next-panel mt-8 p-6 sm:p-10">
                    <div key={active} className="next-era-enter grid gap-8 lg:grid-cols-[2fr_3fr]">
                        <div>
                            <p className="font-mono text-sm next-red-text">{period.dateRange}</p>
                            <h3 className="next-heading mt-2 text-4xl font-bold uppercase text-foreground">{period.title}</h3>
                            <p className="mt-4 leading-relaxed text-muted-foreground">{period.description}</p>
                            <div className="mt-6 flex gap-2">
                                <button type="button" onClick={() => choose(active - 1)} disabled={active === 0} className="next-button-ghost disabled:opacity-40">
                                    <ArrowLeft className="size-4" /> Earlier
                                </button>
                                <button type="button" onClick={() => choose(active + 1)} disabled={active === last} className="next-button-ghost disabled:opacity-40">
                                    Later <ArrowRight className="size-4" />
                                </button>
                            </div>
                        </div>
                        <div>
                            <p className="mb-3 font-mono text-xs uppercase tracking-widest text-muted-foreground">{period.tags.length} titles played</p>
                            <ul className="flex flex-wrap gap-2">
                                {period.tags.map((tag, index) => (
                                    <li
                                        key={tag.label}
                                        style={{ animationDelay: `${120 + index * 30}ms` }}
                                        className={cn(
                                            'next-chip-enter rounded-sm border px-2.5 py-1 text-sm',
                                            tag.highlight ? 'border-primary bg-primary/15 text-primary-foreground' : 'border-border text-foreground/85',
                                        )}
                                    >
                                        {tag.highlight && <Crown className="mr-1.5 inline size-3.5 text-primary" aria-label="Championship" />}
                                        {tag.label}
                                    </li>
                                ))}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

function Divisions() {
    const { divisions } = usePage<SharedPageProps>().props;
    const sorted = useMemo(() => [...divisions].sort((a, b) => (b.members_count ?? 0) - (a.members_count ?? 0)), [divisions]);

    return (
        <section id="divisions" className="border-t border-border px-4 py-24 sm:px-6">
            <SectionHeading eyebrow="Where we play" title="Find your division">
                Each division runs its own game with its own leadership, under one banner and one code of conduct.
            </SectionHeading>

            {sorted.length === 0 ? (
                <p className="text-center text-muted-foreground">Division data is unavailable right now.</p>
            ) : (
                <ul className="mx-auto grid max-w-6xl gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    {sorted.map((division, index) => (
                        <li key={division.href}>
                            <Reveal delay={Math.min(index, 8) * 50}>
                                <a href={nextDivisionHref(division.href)} className="next-division group">
                                    <img src={division.icon} alt="" className="size-12 shrink-0 object-contain transition-transform duration-300 group-hover:scale-110" />
                                    <span className="min-w-0 flex-1">
                                        <span className="next-heading block truncate text-xl font-bold uppercase text-foreground">{division.name}</span>
                                        <span className="font-mono text-xs text-muted-foreground">{formatCount(division.members_count)} members</span>
                                    </span>
                                    <ArrowRight className="size-5 text-muted-foreground transition-all duration-300 group-hover:translate-x-1 group-hover:text-primary" />
                                </a>
                            </Reveal>
                        </li>
                    ))}
                </ul>
            )}
        </section>
    );
}

function Values() {
    return (
        <section id="values" className="border-t border-border bg-card/40 px-4 py-24 sm:px-6">
            <SectionHeading eyebrow="What holds us together" title="The code behind the crest" />
            <div className="mx-auto grid max-w-6xl gap-4 sm:grid-cols-2 lg:grid-cols-4">
                {VALUES.map((value, index) => (
                    <Reveal key={value.title} delay={index * 100}>
                        <article className="next-panel h-full p-6">
                            <value.icon className="size-8 text-primary" aria-hidden="true" />
                            <h3 className="next-heading mt-4 text-2xl font-bold uppercase text-foreground">{value.title}</h3>
                            <p className="mt-2 text-sm leading-relaxed text-muted-foreground">{value.body}</p>
                        </article>
                    </Reveal>
                ))}
            </div>
        </section>
    );
}

function Remembrance() {
    return (
        <section className="next-remembrance border-t border-border px-4 py-20 text-center sm:px-6">
            <p className="font-mono text-xs uppercase tracking-[0.3em] text-muted-foreground">Fallen Angels</p>
            <h2 className="next-heading mt-3 text-4xl font-bold uppercase text-foreground sm:text-5xl">We remember</h2>
            <p className="mx-auto mt-4 max-w-xl text-muted-foreground">Some of the people who built this community are no longer with us. Their names stay on our wall.</p>
            <a href="/next/fallen-angels" className="next-button-ghost mt-8 inline-flex">
                Honor the fallen <ArrowRight className="size-4" />
            </a>
        </section>
    );
}

function JoinBand({ foundedYear }: { foundedYear: number }) {
    const openApply = useOpenApplyDialog();

    return (
        <section className="next-join relative overflow-hidden border-t border-primary/40 px-4 py-24 sm:px-6">
            <div className="relative z-10 mx-auto flex max-w-5xl flex-col items-center gap-10 text-center lg:flex-row lg:text-left">
                <AodMark className="next-mark-glow size-32 shrink-0" />
                <div className="flex-1">
                    <h2 className="next-heading text-4xl font-bold uppercase text-foreground sm:text-5xl">Your squad has been waiting since {foundedYear}</h2>
                    <p className="mt-3 text-lg text-muted-foreground">Mature players, organized divisions, and a community that sticks around. Pick a game and we'll take it from there.</p>
                </div>
                <div className="flex flex-col gap-3">
                    <button type="button" onClick={openApply} className="next-button next-button-lg">
                        Join AOD <ArrowRight className="size-5" />
                    </button>
                    <a href="https://discord.gg/clanaod" target="_blank" rel="noreferrer" className="next-button-ghost next-button-lg">
                        <DiscordIcon className="size-5" /> Say hi on Discord
                    </a>
                </div>
            </div>
        </section>
    );
}

export default function PrototypeHome({ discord, twitch, heroVideoId, introVideoId, historyVideoId, foundedYear, currentYear }: PrototypeProps) {
    const { divisions } = usePage<SharedPageProps>().props;
    const years = currentYear - foundedYear;

    return (
        <NextLayout title="Angels of Death | Prototype" foundedYear={foundedYear} currentYear={currentYear}>
            <Hero years={years} foundedYear={foundedYear} discord={discord} divisionCount={divisions.length} videoId={heroVideoId} introVideoId={introVideoId} />
            <Legacy foundedYear={foundedYear} />
            <Timeline years={years} videoId={historyVideoId} />
            <Divisions />
            <StreamSection twitch={twitch} />
            <Values />
            <Remembrance />
            <JoinBand foundedYear={foundedYear} />
        </NextLayout>
    );
}
