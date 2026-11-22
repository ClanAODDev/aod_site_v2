import { ArrowUpRight } from 'lucide-react';

import { Reveal } from '@/components/reveal';

export interface MerchData {
    storeUrl: string;
    items: { name: string; href: string; image: string }[];
}

export function MerchSection({ merch }: { merch: MerchData }) {
    if (merch.items.length === 0) {
        return null;
    }

    return (
        <section id="merch" className="border-t border-border px-4 py-24 sm:px-6">
            <div className="mx-auto max-w-6xl">
                <div className="mb-10 flex flex-col items-center justify-between gap-6 text-center md:flex-row md:items-end md:text-left">
                    <div>
                        <p className="mb-3 font-mono text-xs uppercase tracking-[0.3em] next-red-text">The armory</p>
                        <h2 className="next-heading text-4xl font-bold uppercase tracking-wide text-foreground sm:text-5xl">Wear the crest</h2>
                        <p className="mt-3 max-w-xl text-muted-foreground">Official AOD apparel and gear, from hoodies and jerseys to mouse pads and mugs.</p>
                    </div>
                    <a href={merch.storeUrl} target="_blank" rel="noreferrer" className="next-button-ghost shrink-0">
                        Shop the store <ArrowUpRight className="size-4" />
                    </a>
                </div>

                <ul className="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
                    {merch.items.map((item, index) => (
                        <li key={item.href}>
                            <Reveal delay={(index % 4) * 70} className="h-full">
                                <a href={item.href} target="_blank" rel="noreferrer" className="next-panel next-merch group flex h-full flex-col">
                                    <span className="next-merch-stage">
                                        <img src={item.image} alt="" loading="lazy" className="size-full object-contain p-5 transition-transform duration-500 group-hover:scale-105" />
                                    </span>
                                    <span className="flex items-start justify-between gap-2 border-t border-border px-4 py-3">
                                        <span className="text-sm leading-snug text-foreground">{item.name}</span>
                                        <ArrowUpRight className="mt-0.5 size-4 shrink-0 text-muted-foreground transition-colors group-hover:text-primary" aria-hidden="true" />
                                    </span>
                                </a>
                            </Reveal>
                        </li>
                    ))}
                </ul>

                <p className="mt-6 text-center font-mono text-[11px] uppercase tracking-widest text-muted-foreground">Sold and shipped by EXCLAIM.gg</p>
            </div>
        </section>
    );
}
