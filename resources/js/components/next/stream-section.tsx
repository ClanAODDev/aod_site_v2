import { ArrowRight, Eye, Play, Radio, Users } from 'lucide-react';
import { useEffect, useRef } from 'react';

import { TwitchIcon } from '@/components/icons/twitch-icon';
import { Reveal } from '@/components/reveal';
import { useInView } from '@/hooks/use-in-view';
import { loadTwitchEmbedApi } from '@/lib/twitch-embed-api';
import { cn } from '@/lib/utils';

export interface StreamVod {
    url: string;
    title: string;
    thumbnail_url: string;
    duration: string;
    view_count: number;
    created_at?: string;
}

export interface LiveStream {
    title?: string;
    game_name?: string;
    viewer_count?: number;
}

export interface TwitchData {
    is_live: boolean;
    stream: LiveStream | null;
    vods: StreamVod[];
    channel: string;
}

function thumbnail(vod: StreamVod, width: number, height: number): string {
    return vod.thumbnail_url.replace('%{width}', `${width}`).replace('%{height}', `${height}`);
}

function splitTitle(title: string): { title: string; game: string | null } {
    const segments = title.split(' - ');
    if (segments.length < 2 || segments[segments.length - 1].length > 32) {
        return { title, game: null };
    }
    return { title: segments.slice(0, -1).join(' - '), game: segments[segments.length - 1] };
}

function formatDuration(duration: string): string {
    const match = duration.match(/(?:(\d+)h)?(?:(\d+)m)?/);
    if (!match || (!match[1] && !match[2])) {
        return duration;
    }
    return [match[1] && `${match[1]}h`, match[2] && `${match[2]}m`].filter(Boolean).join(' ');
}

function LivePlayer({ channel }: { channel: string }) {
    const embedRef = useRef<HTMLDivElement>(null);
    const { ref, inView } = useInView<HTMLDivElement>({ once: true, rootMargin: '0px 0px -10% 0px' });

    useEffect(() => {
        const el = embedRef.current;
        if (!el || !inView) {
            return;
        }
        el.id = 'next-twitch-embed';
        let cancelled = false;

        loadTwitchEmbedApi().then((Twitch) => {
            if (cancelled) {
                return;
            }
            const embed = new Twitch.Embed('next-twitch-embed', {
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
            });
        });

        return () => {
            cancelled = true;
        };
    }, [channel, inView]);

    return (
        <div ref={ref} className="next-panel aspect-video overflow-hidden bg-black">
            <div ref={embedRef} className="size-full" />
        </div>
    );
}

function VodCard({ vod, featured = false }: { vod: StreamVod; featured?: boolean }) {
    const { title, game } = splitTitle(vod.title);

    return (
        <a href={vod.url} target="_blank" rel="noreferrer" className={cn('next-vod group', featured && 'is-featured')}>
            <span className={cn('relative block aspect-video overflow-hidden bg-black', !featured && 'lg:w-1/2 lg:shrink-0')}>
                <img
                    src={thumbnail(vod, featured ? 1280 : 640, featured ? 720 : 360)}
                    alt=""
                    loading="lazy"
                    className="absolute inset-0 size-full object-cover transition-transform duration-500 group-hover:scale-105"
                />
                <span className="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent" aria-hidden="true" />
                <span className="next-vod-play" aria-hidden="true">
                    <Play className="size-5 fill-current" />
                </span>
                <span className="absolute right-2 bottom-2 bg-black/80 px-1.5 py-0.5 font-mono text-[11px] text-white">
                    {formatDuration(vod.duration)}
                </span>
                {game && (
                    <span className="absolute top-2 left-2 bg-black/80 px-2 py-0.5 font-mono text-[11px] tracking-wide text-white/90 uppercase">
                        {game}
                    </span>
                )}
            </span>
            <span className="flex flex-1 flex-col gap-2 p-4">
                <span
                    className={cn(
                        'next-heading leading-tight font-bold text-foreground uppercase',
                        featured ? 'text-2xl sm:text-3xl' : 'line-clamp-2 text-lg',
                    )}
                >
                    {title}
                </span>
                <span className="mt-auto flex items-center gap-1.5 font-mono text-xs text-muted-foreground">
                    <Eye className="size-3.5" aria-hidden="true" /> {vod.view_count.toLocaleString('en-US')} views
                </span>
            </span>
        </a>
    );
}

export function StreamSection({ twitch }: { twitch: TwitchData }) {
    const channelUrl = `https://www.twitch.tv/${twitch.channel}`;
    const live = twitch.is_live && twitch.stream;
    const [featured, ...rest] = twitch.vods;

    return (
        <section id="stream" className="next-stream border-t border-border px-4 py-24 sm:px-6">
            <div className="mx-auto max-w-6xl">
                <div className="mb-10 flex flex-col items-start justify-between gap-6 md:flex-row md:items-end">
                    <div>
                        <p className="next-red-text mb-3 flex items-center gap-2 font-mono text-xs tracking-[0.3em] uppercase">
                            {live ? <span className="next-live-badge">Live now</span> : <Radio className="size-4" aria-hidden="true" />}
                            {live ? 'On the channel' : 'AOD on Twitch'}
                        </p>
                        <h2
                            className={cn(
                                'next-heading font-bold tracking-wide text-foreground uppercase',
                                live ? 'line-clamp-2 max-w-3xl text-3xl sm:text-4xl' : 'text-4xl sm:text-5xl',
                            )}
                        >
                            {live ? (twitch.stream?.title ?? 'We are live') : 'Catch the stream'}
                        </h2>
                        <p className="mt-3 max-w-xl text-muted-foreground">
                            {live
                                ? `Streaming ${twitch.stream?.game_name ?? 'now'}. Jump in, say hi in chat.`
                                : 'Community nights, division events and tournaments, broadcast by members. Catch up on recent streams below.'}
                        </p>
                    </div>
                    <div className="flex shrink-0 items-center gap-4 whitespace-nowrap">
                        {live && typeof twitch.stream?.viewer_count === 'number' && (
                            <span className="flex items-center gap-1.5 font-mono text-sm text-muted-foreground">
                                <Users className="size-4" aria-hidden="true" /> {twitch.stream.viewer_count.toLocaleString('en-US')} watching
                            </span>
                        )}
                        <a href={channelUrl} target="_blank" rel="noreferrer" className="next-button-ghost">
                            <TwitchIcon className="size-4" /> {live ? 'Watch on Twitch' : 'Follow the channel'}
                        </a>
                    </div>
                </div>

                {live ? (
                    <Reveal>
                        <LivePlayer channel={twitch.channel} />
                    </Reveal>
                ) : featured ? (
                    <div className="grid gap-4 lg:grid-cols-[3fr_2fr]">
                        <Reveal from="left">
                            <VodCard vod={featured} featured />
                        </Reveal>
                        <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                            {rest.slice(0, 2).map((vod, index) => (
                                <Reveal key={vod.url} from="right" delay={index * 100}>
                                    <VodCard vod={vod} />
                                </Reveal>
                            ))}
                        </div>
                    </div>
                ) : (
                    <a
                        href={channelUrl}
                        target="_blank"
                        rel="noreferrer"
                        className="next-panel flex items-center justify-between gap-4 p-8 text-foreground"
                    >
                        <span className="next-heading text-2xl font-bold uppercase">
                            The channel is quiet right now. Follow to hear when we go live.
                        </span>
                        <ArrowRight className="size-6 shrink-0 text-primary" />
                    </a>
                )}
            </div>
        </section>
    );
}
