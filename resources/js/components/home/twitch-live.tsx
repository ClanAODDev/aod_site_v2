import { VolumeX } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';

import { TwitchIcon } from '@/components/icons/twitch-icon';
import { loadTwitchEmbedApi, type TwitchPlayer } from '@/lib/twitch-embed-api';

interface TwitchLiveProps {
    channel: string;
    title?: string;
    gameName?: string;
}

export function TwitchLive({ channel, title, gameName }: TwitchLiveProps) {
    const embedRef = useRef<HTMLDivElement>(null);
    const playerRef = useRef<TwitchPlayer | null>(null);
    const [muted, setMuted] = useState(true);

    useEffect(() => {
        const el = embedRef.current;
        if (!el) {
            return;
        }
        el.id = 'twitch-embed';

        let cancelled = false;

        loadTwitchEmbedApi().then((Twitch) => {
            if (cancelled) {
                return;
            }

            const embed = new Twitch.Embed('twitch-embed', {
                width: '100%',
                height: '100%',
                channel,
                layout: 'video',
                autoplay: true,
                muted: true,
                parent: [window.location.hostname],
            });

            embed.addEventListener(Twitch.Embed.VIDEO_READY, () => {
                const player = embed.getPlayer();
                player.setMuted(true);
                player.play();
                playerRef.current = player;
            });
        });

        return () => {
            cancelled = true;
        };
    }, [channel]);

    return (
        <section className="bg-gradient-to-b from-[#0a0a0a] via-[#1a0a1a] to-[#0a0a0a] px-4 py-20">
            <div className="mx-auto max-w-5xl text-center">
                <div className="mb-5 inline-flex items-center gap-2.5 rounded-full border border-[#9146FF]/50 bg-gradient-to-br from-[#9146FF]/30 to-[#9146FF]/50 px-5 py-2 text-xs font-medium tracking-widest text-white uppercase">
                    <span className="size-2.5 animate-pulse rounded-full bg-red-600" />
                    Live Now
                </div>

                <h2 className="text-2xl font-bold [text-shadow:0_2px_10px_rgba(0,0,0,0.5)] md:text-3xl">{title || 'ClanAOD is Live!'}</h2>
                {gameName && <p className="mt-2 mb-6 text-[#9146FF]/90">Playing {gameName}</p>}

                <div className="relative mx-auto mb-8 aspect-video w-full max-w-3xl overflow-hidden rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.5),0_0_0_1px_rgba(145,70,255,0.3)]">
                    <div ref={embedRef} className="absolute inset-0" />
                    {muted && (
                        <button
                            onClick={() => {
                                playerRef.current?.setMuted(false);
                                setMuted(false);
                            }}
                            className="absolute bottom-5 left-1/2 z-10 flex -translate-x-1/2 items-center gap-2.5 rounded-md bg-[#9146FF]/90 px-6 py-3 text-sm font-medium tracking-wide text-white uppercase transition-transform hover:scale-105 hover:bg-[#9146FF]"
                        >
                            <VolumeX className="size-[18px]" />
                            Click to Unmute
                        </button>
                    )}
                </div>

                <a
                    href={`https://www.twitch.tv/${channel}`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-flex items-center gap-2.5 rounded-md bg-gradient-to-br from-[#9146FF] to-[#7c3aed] px-8 py-3.5 text-sm font-medium tracking-widest text-white uppercase transition-all hover:-translate-y-1 hover:shadow-[0_8px_25px_rgba(145,70,255,0.4)]"
                >
                    <TwitchIcon className="size-[18px]" />
                    Watch on Twitch
                </a>
            </div>
        </section>
    );
}
