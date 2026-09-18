import { Head, usePage } from '@inertiajs/react';

import { SiteLayout } from '@/layouts/site-layout';
import type { SharedPageProps } from '@/types';

export default function DivisionIndex() {
    const { divisions } = usePage<SharedPageProps>().props;

    return (
        <SiteLayout>
            <Head title="Gaming Divisions" />

            <section className="divisions-lobby-bg">
                <div className="mx-auto max-w-6xl px-4 py-16">
                    <div className="max-w-xl text-right md:ml-auto">
                        <h1 className="text-3xl font-bold text-foreground">Gaming Divisions</h1>
                        <p className="mt-4 text-foreground/80">
                            Our gaming divisions are the lifeblood of the Angels of Death community. A great deal of effort goes into vetting each
                            division request to ensure the game is a good fit and the new division will have the right leadership to support its
                            progress.
                        </p>
                    </div>

                    {divisions.length === 0 ? (
                        <p className="mt-40 text-center text-muted-foreground">No divisions to display</p>
                    ) : (
                        <div className="mt-40 flex flex-wrap justify-center gap-5">
                            {divisions.map((division, index) => (
                                <a
                                    key={division.slug}
                                    href={division.href}
                                    style={{ animationDelay: `${Math.min(index, 12) * 60}ms` }}
                                    className="animate-in fade-in slide-in-from-bottom-4 group relative flex flex-[0_0_calc(25%-1.25rem)] items-center overflow-hidden rounded-xl border border-white/8 bg-gradient-to-br from-[#1a1a2e]/80 to-[#0d0d1a]/90 p-5 transition-all duration-300 hover:-translate-y-1 hover:scale-[1.02] hover:border-primary/30 hover:shadow-[0_12px_40px_rgba(0,0,0,0.4),0_0_30px_var(--primary-glow)] max-lg:flex-[0_0_calc(50%-1.25rem)] max-md:flex-[0_0_100%] fill-mode-both"
                                >
                                    <div className="mr-5 shrink-0">
                                        <img
                                            src={division.icon}
                                            alt={division.name}
                                            loading="lazy"
                                            className="size-16 object-contain opacity-70 transition-all duration-300 group-hover:scale-110 group-hover:opacity-100 group-hover:drop-shadow-[0_0_8px_var(--primary-glow)] max-md:size-12"
                                        />
                                    </div>
                                    <div className="leading-relaxed">
                                        <div className="font-semibold text-foreground transition-colors group-hover:text-primary">
                                            {division.name}
                                        </div>
                                        <div className="mt-1 text-xs text-foreground/50">{division.members_count} Members</div>
                                    </div>
                                </a>
                            ))}
                        </div>
                    )}
                </div>
            </section>
        </SiteLayout>
    );
}
