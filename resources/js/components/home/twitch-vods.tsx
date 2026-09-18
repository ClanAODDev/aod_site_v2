import { Eye } from 'lucide-react';

import { ContinuousCarousel } from '@/components/home/continuous-carousel';
import { TwitchIcon } from '@/components/icons/twitch-icon';
import { SectionTitle } from '@/components/section-title';
import type { Division } from '@/types';

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
    divisions: Division[];
}

/** Best-effort game tag: most stream titles end in "... - Game Name". Matched against the known
 * division list so we can show its icon; falls back to a plain text pill with no icon. */
function extractGameTag(title: string, divisions: Division[]): { label: string; icon: string | null } | null {
    const segments = title.split(' - ');
    if (segments.length < 2) {
        return null;
    }

    const candidate = segments[segments.length - 1].trim();
    if (!candidate || candidate.length > 28) {
        return null;
    }

    const match = divisions.find(
        (division) => candidate.toLowerCase().includes(division.name.toLowerCase()) || division.name.toLowerCase().includes(candidate.toLowerCase()),
    );

    return { label: candidate, icon: match?.icon ?? null };
}

function VodCard({ vod, divisions }: { vod: Vod; divisions: Division[] }) {
    const gameTag = extractGameTag(vod.title, divisions);

    return (
        <a
            href={vod.url}
            target="_blank"
            rel="noopener noreferrer"
            className="group flex h-full w-70 flex-col overflow-hidden rounded-xl border border-border bg-white/3 text-left transition-all hover:border-[#9146FF]/60 hover:bg-[#9146FF]/10 hover:shadow-[0_0_25px_rgba(145,70,255,0.3)]"
        >
            <div className="relative aspect-video overflow-hidden bg-black">
                <img
                    src={vod.thumbnail_url.replace('%{width}', '640').replace('%{height}', '360')}
                    alt={vod.title}
                    className="absolute inset-0 size-full object-cover transition-transform group-hover:scale-105"
                />

                {gameTag && (
                    <span className="absolute top-2 left-2 inline-flex items-center gap-1.5 rounded-full bg-black/85 py-0.5 pr-2.5 pl-1.5 text-[11px] font-medium tracking-wide text-white/90 uppercase">
                        {gameTag.icon && <img src={gameTag.icon} alt="" className="size-4 object-contain" />}
                        {gameTag.label}
                    </span>
                )}

                <div className="absolute inset-x-0 bottom-0 flex items-center justify-end bg-gradient-to-r from-[#9146FF]/90 to-[#7c3aed]/90 px-2 py-1">
                    <span className="text-[11px] font-medium text-white">{vod.duration}</span>
                </div>
            </div>
            <div className="flex flex-1 flex-col p-4">
                <span className="line-clamp-2 text-sm tracking-wide text-foreground/90 uppercase">{vod.title}</span>
                <span className="mt-auto flex items-center gap-1 pt-2 text-xs text-foreground/50">
                    <Eye className="size-3" /> {vod.view_count.toLocaleString()} views
                </span>
            </div>
        </a>
    );
}

export function TwitchVods({ vods, channel, divisions }: TwitchVodsProps) {
    return (
        <section className="bg-gradient-to-b from-[#0a0a0a] via-[#1a0a1a] to-[#0a0a0a] px-4 py-20">
            <div className="mx-auto max-w-6xl text-center">
                <SectionTitle>Recent Streams</SectionTitle>
                <p className="mx-auto mt-3 max-w-2xl text-foreground/70">Catch up on our latest broadcasts from the Angels of Death community.</p>

                {vods.length > 0 && (
                    <ContinuousCarousel
                        items={vods}
                        keyFor={(vod) => vod.url}
                        speed={0.3}
                        gap={20}
                        navHoverClassName="hover:border-[#9146FF]/60 hover:bg-[#9146FF]/30"
                        renderItem={(vod) => <VodCard vod={vod} divisions={divisions} />}
                    />
                )}

                <a
                    href={`https://www.twitch.tv/${channel}/videos`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="mt-8 inline-flex items-center gap-2.5 rounded-md bg-gradient-to-br from-[#9146FF] to-[#7c3aed] px-8 py-3.5 text-sm font-medium tracking-widest text-white uppercase transition-all hover:-translate-y-1 hover:shadow-[0_8px_25px_rgba(145,70,255,0.4)]"
                >
                    <TwitchIcon className="size-[18px]" />
                    View All Videos on Twitch
                </a>
            </div>
        </section>
    );
}
