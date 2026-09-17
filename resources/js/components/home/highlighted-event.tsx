import { ArrowRight, Snowflake } from 'lucide-react';
import type { ComponentType, SVGProps } from 'react';

import { cn } from '@/lib/utils';

/** Maps the Font Awesome class strings still stored in config/aod.php to a lucide icon. */
const ICONS: Record<string, ComponentType<SVGProps<SVGSVGElement>>> = {
    'fas fa-snowflake': Snowflake,
    'fas fa-arrow-right': ArrowRight,
};

interface HighlightedEventData {
    theme: 'holiday' | 'esports' | 'community' | 'default';
    show_snowflakes?: boolean;
    badge?: { icon?: string; text: string };
    title: string;
    description?: string;
    video?: { type: 'youtube' | 'twitch'; id: string; title?: string };
    cta?: { text: string; url: string; icon?: string };
}

const SNOWFLAKE_POSITIONS = [
    { left: '5%', fontSize: '1.4rem', duration: '15s', delay: '0s', opacity: 0.6 },
    { left: '15%', fontSize: '2.2rem', duration: '12s', delay: '2s', opacity: 0.8 },
    { left: '25%', fontSize: '1rem', duration: '18s', delay: '4s', opacity: 0.5 },
    { left: '35%', fontSize: '1.8rem', duration: '14s', delay: '1s', opacity: 0.7 },
    { left: '45%', fontSize: '1.5rem', duration: '16s', delay: '3s', opacity: 0.6 },
    { left: '55%', fontSize: '2rem', duration: '13s', delay: '5s', opacity: 0.8 },
    { left: '65%', fontSize: '1.2rem', duration: '17s', delay: '2.5s', opacity: 0.5 },
    { left: '75%', fontSize: '1.8rem', duration: '15s', delay: '1.5s', opacity: 0.7 },
    { left: '85%', fontSize: '1.4rem', duration: '14s', delay: '4.5s', opacity: 0.6 },
    { left: '95%', fontSize: '2.4rem', duration: '11s', delay: '0.5s', opacity: 0.8 },
];

export function HighlightedEvent({ event }: { event: HighlightedEventData }) {
    const BadgeIcon = event.badge?.icon ? ICONS[event.badge.icon] : undefined;
    const CtaIcon = event.cta?.icon ? ICONS[event.cta.icon] : undefined;

    return (
        <section className={cn('relative overflow-hidden px-4 py-20', `highlighted-event-${event.theme}`)}>
            {event.show_snowflakes && (
                <div aria-hidden className="pointer-events-none absolute inset-0 overflow-hidden">
                    {SNOWFLAKE_POSITIONS.map((snow, index) => (
                        <span
                            key={index}
                            className="snowflake"
                            style={{
                                left: snow.left,
                                fontSize: snow.fontSize,
                                animationDuration: snow.duration,
                                animationDelay: snow.delay,
                                opacity: snow.opacity,
                            }}
                        >
                            ❄
                        </span>
                    ))}
                </div>
            )}

            <div className="relative mx-auto max-w-3xl text-center">
                {event.badge && (
                    <div
                        className={cn(
                            'mb-6 inline-flex items-center gap-3 rounded-full border border-red-400/30 bg-gradient-to-br from-[#8b1e1e]/80 to-[#501414]/90 px-6 py-2.5 text-xs font-medium tracking-widest text-white uppercase',
                            event.theme === 'holiday' && 'highlighted-event-badge-holiday',
                        )}
                    >
                        {BadgeIcon && <BadgeIcon className="size-4" />}
                        <span>{event.badge.text}</span>
                        {BadgeIcon && <BadgeIcon className="size-4" />}
                    </div>
                )}

                <h2
                    className="font-mono text-2xl font-medium tracking-[0.06em] uppercase [text-shadow:0_2px_10px_rgba(0,0,0,0.5)] md:text-4xl"
                    dangerouslySetInnerHTML={{ __html: event.title }}
                />

                {event.description && <p className="mx-auto mt-5 max-w-2xl text-foreground/85">{event.description}</p>}

                {event.video && (
                    <div className="relative mx-auto mt-8 aspect-video w-full max-w-2xl overflow-hidden rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.5),0_0_0_1px_rgba(255,100,100,0.2)]">
                        <iframe
                            src={
                                event.video.type === 'youtube'
                                    ? `https://www.youtube.com/embed/${event.video.id}`
                                    : `https://player.twitch.tv/?video=${event.video.id}&parent=${window.location.hostname}`
                            }
                            title={event.video.title || event.title}
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowFullScreen
                            className="absolute inset-0 size-full border-0"
                        />
                    </div>
                )}

                {event.cta && (
                    <a
                        href={event.cta.url}
                        target="_blank"
                        rel="noreferrer"
                        className="mt-8 inline-flex items-center gap-2.5 rounded-md bg-gradient-to-br from-primary to-primary/80 px-8 py-3.5 text-sm font-medium tracking-widest text-primary-foreground uppercase transition-all hover:-translate-y-1 hover:shadow-[0_8px_25px_var(--primary-glow)]"
                    >
                        {CtaIcon && <CtaIcon className="size-4" />}
                        {event.cta.text}
                    </a>
                )}
            </div>
        </section>
    );
}
