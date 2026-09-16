import { ContinuousCarousel } from '@/components/home/continuous-carousel';

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

export function MerchSection({ items, storeUrl, imageBaseUrl, imageSuffix }: MerchSectionProps) {
    return (
        <section className="bg-gradient-to-b from-[#0a0a0a] via-[#151515] to-[#0a0a0a] px-4 py-20">
            <div className="mx-auto max-w-6xl text-center">
                <h2 className="text-2xl font-bold md:text-3xl">Rep the Angels of Death</h2>
                <p className="mx-auto mt-3 max-w-2xl text-foreground/70">
                    Show your AOD pride with official merchandise. From premium apparel to gaming gear, we&apos;ve got you covered.
                </p>

                <ContinuousCarousel
                    items={items}
                    keyFor={(item) => item.slug}
                    speed={0.5}
                    gap={25}
                    navHoverClassName="hover:border-primary/60 hover:bg-primary/30"
                    renderItem={(item) => (
                        <a
                            href={`${storeUrl}/${item.slug}`}
                            target="_blank"
                            rel="noreferrer"
                            className="flex w-55 flex-col items-center rounded-xl border border-border bg-white/3 p-5 text-center transition-all hover:border-primary/60 hover:bg-primary/10 hover:shadow-[0_0_25px_var(--primary-glow)]"
                        >
                            <img
                                src={`${imageBaseUrl}${item.image_id}${imageSuffix}`}
                                alt={item.name}
                                className="mb-4 h-55 w-full rounded-lg object-contain drop-shadow-[0_4px_8px_rgba(0,0,0,0.4)]"
                            />
                            <span className="text-xs tracking-wide text-foreground/90 uppercase">{item.name}</span>
                        </a>
                    )}
                />

                <a
                    href={storeUrl}
                    target="_blank"
                    rel="noreferrer"
                    className="mt-2 inline-block rounded-md border border-white/30 px-8 py-3.5 text-sm tracking-widest text-foreground uppercase transition-all hover:-translate-y-0.5 hover:border-white/60 hover:bg-white/10"
                >
                    Shop All Merchandise [EXCLAIM.gg]
                </a>
            </div>
        </section>
    );
}
