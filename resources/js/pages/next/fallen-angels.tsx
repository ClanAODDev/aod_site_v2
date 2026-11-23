import { Head } from '@inertiajs/react';
import { ArrowUpRight, Flame, Search } from 'lucide-react';
import { useMemo, useState } from 'react';

import { AodMark } from '@/components/next/aod-mark';
import { NextLayout } from '@/components/next/next-layout';
import { Reveal } from '@/components/reveal';

interface FallenMember {
    name: string;
    date_fallen: string;
    forum_profile?: string;
}

interface FallenAngelsProps {
    fallen: FallenMember[];
    foundedYear: number;
    currentYear: number;
}

const POEM = [
    'To fall from heights, those who’ve ascended,',
    'Seems dire and bleak, so far descended,',
    'Our intentions meant to elevate,',
    'Feel hollow and sullen, the burden great.',
    'Our memories endure, these lives long past,',
    'The hope our adventures were not our last.',
    'With honor we remember these precious things,',
    'The Fallen Angels, now rest their wings.',
];

function fallenOn(date: string): string {
    return !date || date.toLowerCase() === 'unknown' ? 'Date unknown' : date;
}

function Plaque({ member }: { member: FallenMember }) {
    const body = (
        <>
            <Flame className="next-candle size-5" aria-hidden="true" />
            <span className="next-serif block text-2xl leading-tight text-foreground">{member.name}</span>
            <span className="mt-2 block font-mono text-xs tracking-widest text-muted-foreground uppercase">{fallenOn(member.date_fallen)}</span>
            {member.forum_profile && (
                <span className="mt-4 inline-flex items-center gap-1 text-xs text-muted-foreground transition-colors group-hover:text-foreground">
                    Forum profile <ArrowUpRight className="size-3.5" aria-hidden="true" />
                </span>
            )}
        </>
    );

    return member.forum_profile ? (
        <a href={member.forum_profile} target="_blank" rel="noreferrer" className="next-plaque group">
            {body}
        </a>
    ) : (
        <div className="next-plaque group">{body}</div>
    );
}

export default function FallenAngels({ fallen, foundedYear, currentYear }: FallenAngelsProps) {
    const [query, setQuery] = useState('');
    const shown = useMemo(() => {
        const needle = query.trim().toLowerCase();
        return needle === '' ? fallen : fallen.filter((member) => member.name.toLowerCase().includes(needle));
    }, [fallen, query]);

    return (
        <NextLayout title="Fallen Angels | Prototype" foundedYear={foundedYear} currentYear={currentYear}>
            <Head>
                <link rel="preconnect" href="https://fonts.googleapis.com" />
                <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;1,500&display=swap" rel="stylesheet" />
            </Head>

            <section className="next-memorial relative flex flex-col items-center overflow-hidden px-4 pt-32 pb-14 text-center">
                <video
                    src="/images/memoriam-v2.webm"
                    className="next-memorial-video"
                    preload="auto"
                    loop
                    playsInline
                    muted
                    autoPlay
                    aria-hidden="true"
                />
                <div className="relative z-10 flex flex-col items-center">
                    <AodMark className="next-mark-mourning mb-8 size-24 text-foreground/70" title="Angels of Death" />
                    <p className="font-mono text-xs tracking-[0.4em] text-muted-foreground uppercase">In memoriam</p>
                    <h1 className="next-heading mt-3 text-6xl font-bold tracking-wide text-foreground uppercase sm:text-7xl">Fallen Angels</h1>
                    <div className="next-serif mt-10 space-y-1.5 text-xl text-foreground/85 italic sm:text-2xl">
                        {POEM.map((line, index) => (
                            <p key={line} className="next-poem-line" style={{ animationDelay: `${400 + index * 380}ms` }}>
                                {line}
                            </p>
                        ))}
                    </div>
                </div>
            </section>

            <section className="border-t border-border px-4 pt-14 pb-24 sm:px-6">
                <div className="mx-auto max-w-6xl">
                    <div className="mb-12 flex flex-col items-center justify-between gap-6 text-center md:flex-row md:items-end md:text-left">
                        <div>
                            <p className="next-red-text mb-3 font-mono text-xs tracking-[0.3em] uppercase">The wall</p>
                            <h2 className="next-heading text-4xl font-bold text-foreground uppercase sm:text-5xl">Their names stay with us</h2>
                            <p className="mt-3 text-muted-foreground">
                                {fallen.length === 1 ? 'One angel' : `${fallen.length} angels`} remembered by the community since {foundedYear}.
                            </p>
                        </div>
                        {fallen.length > 12 && (
                            <label className="relative block w-full max-w-xs">
                                <span className="sr-only">Find a name</span>
                                <Search
                                    className="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground"
                                    aria-hidden="true"
                                />
                                <input
                                    type="search"
                                    value={query}
                                    onChange={(event) => setQuery(event.target.value)}
                                    placeholder="Find a name"
                                    className="h-11 w-full border border-border bg-transparent pr-3 pl-9 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none"
                                />
                            </label>
                        )}
                    </div>

                    {fallen.length === 0 ? (
                        <p className="text-center text-muted-foreground">The memorial wall is unavailable right now.</p>
                    ) : shown.length === 0 ? (
                        <p className="text-center text-muted-foreground">No names match “{query}”.</p>
                    ) : (
                        <ul className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            {shown.map((member, index) => (
                                <li key={`${member.name}-${member.date_fallen}`}>
                                    <Reveal delay={Math.min(index, 9) * 60}>
                                        <Plaque member={member} />
                                    </Reveal>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>
            </section>

            <section className="next-remembrance border-t border-border px-4 py-20 text-center sm:px-6">
                <p className="next-serif mx-auto max-w-2xl text-2xl text-foreground/85 italic sm:text-3xl">
                    With honor we remember these precious things,
                    <br />
                    The Fallen Angels, now rest their wings.
                </p>
                <a href="/next" className="next-button-ghost mt-10 inline-flex">
                    Return home
                </a>
            </section>
        </NextLayout>
    );
}
