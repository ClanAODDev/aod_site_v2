import { Eye } from 'lucide-react';

import { TwitchIcon } from '@/components/icons/twitch-icon';
import { ContinuousCarousel } from '@/components/home/continuous-carousel';
import { SectionTitle } from '@/components/section-title';

interface Vod {
    url: string;
    title: string;
    thumbnail_url: string;
    duration: string;
    view_count: number;
}

interface TwitchVodsProps {
    vods: Vod[];
    channel: string;
}

export function TwitchVods({ vods, channel }: TwitchVodsProps) {
    return (
        <section className="bg-gradient-to-b from-[#0a0a0a] via-[#1a0a1a] to-[#0a0a0a] px-4 py-20">
            <div className="mx-auto max-w-6xl text-center">
                <SectionTitle>Recent Streams</SectionTitle>
                <p className="mx-auto mt-3 max-w-2xl text-foreground/70">Catch up on our latest broadcasts from the Angels of Death community.</p>

                <ContinuousCarousel
                    items={vods}
                    keyFor={(vod) => vod.url}
                    speed={0.3}
                    gap={20}
                    navHoverClassName="hover:border-[#9146FF]/60 hover:bg-[#9146FF]/30"
                    renderItem={(vod) => (
                        <a
                            href={vod.url}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="group flex w-70 flex-col overflow-hidden rounded-xl border border-border bg-white/3 text-left transition-all hover:border-[#9146FF]/60 hover:bg-[#9146FF]/10 hover:shadow-[0_0_25px_rgba(145,70,255,0.3)]"
                        >
                            <div className="relative overflow-hidden">
                                <img
                                    src={vod.thumbnail_url.replace('%{width}', '320').replace('%{height}', '180')}
                                    alt={vod.title}
                                    className="h-[158px] w-full object-cover transition-transform group-hover:scale-105"
                                />
                                <span className="absolute right-2 bottom-2 rounded bg-black/85 px-1.5 py-0.5 text-xs text-white">{vod.duration}</span>
                            </div>
                            <div className="flex flex-1 flex-col p-4">
                                <span className="line-clamp-2 text-sm tracking-wide text-foreground/90 uppercase">{vod.title}</span>
                                <span className="mt-auto flex items-center gap-1 pt-2 text-xs text-foreground/50">
                                    <Eye className="size-3" /> {vod.view_count.toLocaleString()} views
                                </span>
                            </div>
                        </a>
                    )}
                />

                <a
                    href={`https://www.twitch.tv/${channel}/videos`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="mt-2 inline-flex items-center gap-2.5 rounded-md bg-gradient-to-br from-[#9146FF] to-[#7c3aed] px-8 py-3.5 text-sm font-medium tracking-widest text-white uppercase transition-all hover:-translate-y-1 hover:shadow-[0_8px_25px_rgba(145,70,255,0.4)]"
                >
                    <TwitchIcon className="size-[18px]" />
                    View All Videos on Twitch
                </a>
            </div>
        </section>
    );
}
