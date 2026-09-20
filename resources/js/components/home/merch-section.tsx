import { useMemo } from 'react';

import { HudCorners } from '@/components/hud-corners';
import { SectionTitle } from '@/components/section-title';
import { cn } from '@/lib/utils';

interface MerchItem {
    name: string;
    slug: string;
    image_id: string;
}

interface MerchSectionProps {
    items: MerchItem[];
    storeUrl: string;
    imageBaseUrl: string;
    imageSuffix: string;
}

const MAX_DISPLAY_COUNT = 12;
const FEATURED_COUNT = 3;

/** Reveals more tiles as the viewport widens, matching the grid's own column breakpoints
 * below - 6 on mobile, 8 from `sm`, all 12 from `lg` - instead of a fixed item count. */
function visibilityClass(index: number): string | undefined {
    if (index < 6) return undefined;
    if (index < 8) return 'hidden sm:block';
    return 'hidden lg:block';
}

function pickRandom<T>(items: T[], count: number): T[] {
    const shuffled = [...items];
    for (let i = shuffled.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
    }
    return shuffled.slice(0, count);
}

export function MerchSection({ items: allItems, storeUrl, imageBaseUrl, imageSuffix }: MerchSectionProps) {
    const items = useMemo(() => pickRandom(allItems, MAX_DISPLAY_COUNT), [allItems]);
    const featuredIndices = useMemo(
        () => new Set(pickRandom([...items.keys()], FEATURED_COUNT)),
        [items],
    );

    return (
        <section className="bg-gradient-to-b from-[#0a0a0a] via-[#151515] to-[#0a0a0a] px-4 py-20">
            <div className="mx-auto max-w-6xl text-center">
                <SectionTitle>Rep the Angels of Death</SectionTitle>
                <p className="mx-auto mt-3 max-w-2xl text-foreground/70">
                    Show your AOD pride with official merchandise. From premium apparel to gaming gear, we&apos;ve got you covered.
                </p>

                <div className="mt-10 grid grid-cols-2 [grid-auto-flow:dense] auto-rows-[130px] gap-3 sm:grid-cols-4 sm:auto-rows-[150px] lg:grid-cols-6 lg:auto-rows-[170px]">
                    {items.map((item, i) => {
                        const featured = featuredIndices.has(i);
                        return (
                            <a
                                key={item.slug}
                                href={`${storeUrl}/${item.slug}`}
                                target="_blank"
                                rel="noreferrer"
                                className={cn(
                                    'tron-hatch-bold group relative overflow-hidden rounded-lg border border-border bg-white/3 transition-colors hover:border-primary/50',
                                    featured && 'col-span-2 row-span-2',
                                    visibilityClass(i),
                                )}
                            >
                                <HudCorners className="z-10 border-border-strong/0 transition-colors duration-300 group-hover:border-primary" />

                                <img
                                    src={`${imageBaseUrl}${item.image_id}${imageSuffix}`}
                                    alt={item.name}
                                    loading="lazy"
                                    className="absolute inset-0 size-full object-contain p-4 transition-transform duration-500 group-hover:scale-105"
                                />

                                <div className="absolute inset-x-0 bottom-0 flex translate-y-1/2 items-end bg-gradient-to-t from-black/90 via-black/60 to-transparent px-3 pt-8 pb-2 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                    <span
                                        className={cn(
                                            'tracking-wide text-foreground uppercase',
                                            featured ? 'text-sm' : 'text-[11px]',
                                        )}
                                    >
                                        {item.name}
                                    </span>
                                </div>
                            </a>
                        );
                    })}
                </div>

                <a
                    href={storeUrl}
                    target="_blank"
                    rel="noreferrer"
                    className="mt-10 inline-block rounded-md border border-white/30 px-8 py-3.5 text-sm tracking-widest text-foreground uppercase transition-all hover:-translate-y-0.5 hover:border-white/60 hover:bg-white/10"
                >
                    Shop All Merchandise [EXCLAIM.gg]
                </a>
            </div>
        </section>
    );
}
