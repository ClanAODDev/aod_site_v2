import { useEffect, useRef, useState } from 'react';

import { DiscordIcon } from '@/components/icons/discord-icon';
import { Dialog, DialogContent, DialogTitle } from '@/components/ui/dialog';
import { useHeroScrollFade } from '@/hooks/use-hero-scroll-fade';
import { useMediaQuery } from '@/hooks/use-media-query';
import { useYouTubeCoverVideo } from '@/hooks/use-youtube-cover-video';

interface HeroProps {
    videoId: string;
    introVideoId: string;
    discordOnline?: number;
    discordTotal?: number;
    isChristmas?: boolean;
}

export function Hero({ videoId, introVideoId, discordOnline, discordTotal, isChristmas }: HeroProps) {
    const canAutoplayVideo = useMediaQuery('(min-width: 768px)');
    const { containerRef, targetRef } = useYouTubeCoverVideo(videoId, canAutoplayVideo);
    const videoWrapperRef = useRef<HTMLDivElement>(null);
    const textRef = useRef<HTMLDivElement>(null);
    const [introOpen, setIntroOpen] = useState(false);

    useHeroScrollFade(videoWrapperRef, textRef);

    useEffect(() => {
        function handleScroll() {
            const el = textRef.current;
            if (!el) {
                return;
            }
            // Sits above the nav (and everything else) only at rest, so the discord link and play
            // button are clickable. The instant any scrolling starts, drop it behind - a fixed,
            // positive z-index block would otherwise get swept over by the nav as it rises toward
            // its sticky position, well before the opacity fade below has a chance to hide it.
            el.style.zIndex = window.scrollY > 4 ? '-10' : '50';
        }
        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    return (
        <>
            <div ref={videoWrapperRef} className="fixed inset-0 -z-10 h-screen w-screen overflow-hidden bg-black transition-opacity duration-300">
                {canAutoplayVideo ? (
                    <div ref={containerRef} className="absolute inset-0">
                        <div ref={targetRef} />
                    </div>
                ) : (
                    <img src="/images/video-poster.jpg" alt="" className="absolute inset-0 size-full object-cover" />
                )}
                <div className="hero-video-overlay pointer-events-none absolute inset-0" />
            </div>

            <div ref={textRef} className="fixed top-[50px] left-1/2 z-50 w-full max-w-4xl -translate-x-1/2 px-4 text-center text-white transition-opacity duration-300">
                <a
                    href="https://discord.gg/clanaod"
                    title="Join the AOD Discord"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="pointer-events-auto mb-4 inline-flex items-center gap-2 rounded-full border border-white/15 bg-black/40 px-4 py-1.5 text-xs font-medium tracking-wide text-white/90 backdrop-blur-sm transition-colors hover:border-white/30 hover:bg-black/60"
                >
                    <DiscordIcon className="size-4 text-[#5865F2]" />
                    JOIN US ON DISCORD
                    {discordOnline !== undefined && discordTotal !== undefined && (
                        <span className="text-white/60">
                            · ONLINE: {discordOnline} / {discordTotal}
                        </span>
                    )}
                </a>

                <img
                    src={isChristmas ? '/images/logo-xmas.png' : '/images/official-logo.png'}
                    alt="Angels of Death"
                    className="mx-auto w-32 drop-shadow-lg md:w-48"
                />
                <h1 className="mt-4 text-3xl font-bold [text-shadow:0_0_2px_rgba(0,0,0,0.4)] md:text-5xl">
                    Game with purpose
                    <br />
                    inspired by community
                </h1>
                <h2 className="mt-2 text-lg text-white/80">What are you waiting for?</h2>
                <button
                    onClick={() => setIntroOpen(true)}
                    aria-label="Play video"
                    className="pointer-events-auto relative z-10 mx-auto mt-6 h-[61px] w-[53px] bg-[url('/images/play-button.png')] bg-no-repeat transition-[filter] duration-500 hover:drop-shadow-[0_0_12px_white]"
                />
            </div>

            <Dialog open={introOpen} onOpenChange={setIntroOpen}>
                <DialogContent showCloseButton className="max-w-4xl border-none bg-black p-0 shadow-none">
                    <DialogTitle className="sr-only">Angels of Death intro video</DialogTitle>
                    {introOpen && (
                        <iframe
                            src={`https://www.youtube.com/embed/${introVideoId}?autoplay=1&showinfo=0&enablejsapi=1&rel=0&modestbranding=1`}
                            allow="autoplay; encrypted-media"
                            allowFullScreen
                            className="aspect-video w-full border-0"
                        />
                    )}
                </DialogContent>
            </Dialog>
        </>
    );
}
