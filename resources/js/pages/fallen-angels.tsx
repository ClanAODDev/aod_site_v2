import { Head } from '@inertiajs/react';

import { SiteLayout } from '@/layouts/site-layout';

interface FallenMember {
    name: string;
    date_fallen: string;
    forum_profile?: string;
}

interface FallenAngelsProps {
    fallen: FallenMember[];
}

export default function FallenAngels({ fallen }: FallenAngelsProps) {
    return (
        <SiteLayout>
            <Head title="Fallen Angels" />

            <section className="relative min-h-[800px] overflow-hidden">
                <video
                    src="/images/memoriam-v2.webm"
                    className="fallen-angel-video"
                    preload="auto"
                    loop
                    playsInline
                    muted
                    autoPlay
                />

                <div className="epitaph-container">
                    <div className="absolute top-[20%] left-1/2 w-[55%] max-lg:relative max-lg:top-0 max-lg:left-0 max-lg:mx-auto max-lg:min-w-[600px] max-md:min-w-full max-md:w-full max-md:px-4 max-md:py-8 text-center">
                        <h1 className="font-serif text-3xl [font-variant:small-caps] md:text-4xl">Our Fallen Angels</h1>
                        <p className="mt-6 font-serif text-base [font-variant:small-caps] leading-relaxed [text-shadow:1px_1px_0_var(--background)] md:text-2xl md:leading-[40px]">
                            To fall from heights, those who&apos;ve ascended,
                            <br />
                            Seems dire and bleak, so far descended,
                            <br />
                            Our intentions meant to elevate,
                            <br />
                            Feel hollow and sullen, the burden great.
                            <br />
                            Our memories endure, these lives long past,
                            <br />
                            The hope our adventures were not our last.
                            <br />
                            With honor we remember these precious things,
                            <br />
                            The Fallen Angels, now rest their wings.
                        </p>
                    </div>
                </div>
            </section>

            <div className="relative -mt-[175px] w-full border-t border-border bg-black/40 px-4 pb-12 text-center">
                <h3 className="py-4 text-lg tracking-wide">&mdash; IN MEMORIAM &mdash;</h3>
                <div className="mx-auto flex max-w-5xl flex-row flex-wrap justify-center">
                    {fallen.map((member) => (
                        <a
                            key={member.name}
                            href={member.forum_profile || '#'}
                            target="_blank"
                            rel="noreferrer"
                            className="block flex-[0_0_47%] px-4 py-6 text-center text-base text-foreground/90 transition-colors hover:text-primary hover:underline max-md:flex-[0_0_100%] max-md:px-2 max-md:py-3"
                        >
                            {member.name} &mdash; {member.date_fallen}
                        </a>
                    ))}
                </div>
            </div>
        </SiteLayout>
    );
}
