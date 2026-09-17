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
    const discordRef = useRef<HTMLAnchorElement>(null);
    const [introOpen, setIntroOpen] = useState(false);

    useHeroScrollFade(videoWrapperRef, textRef, discordRef);

    useEffect(() => {
        function handleScroll() {
            // Sits above the nav (and everything else) only at rest, so the discord link and play
            // button are clickable. The instant any scrolling starts, drop it behind - a fixed,
            // positive z-index block would otherwise get swept over by the nav as it rises toward
            // its sticky position, well before the opacity fade below has a chance to hide it.
            const zIndex = window.scrollY > 4 ? '-10' : '50';
            if (textRef.current) {
                textRef.current.style.zIndex = zIndex;
            }
            if (discordRef.current) {
                discordRef.current.style.zIndex = zIndex;
            }
        }
        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    return (
        <>
            {/* Only the top 55vh of this h-screen box ever stays visible - the nav/content below
                cover the rest. Shifting it up by half of what's covered (45vh / 2) brings the
                vertical middle of the footage into that visible window instead of its top. */}
            <div
                ref={videoWrapperRef}
                className="fixed inset-0 -z-10 h-screen w-screen -translate-y-[22.5vh] overflow-hidden bg-black transition-opacity duration-300"
            >
                {canAutoplayVideo ? (
                    <div ref={containerRef} className="absolute inset-0">
                        <div ref={targetRef} />
                    </div>
                ) : (
                    <img src="/images/video-poster.jpg" alt="" className="absolute inset-0 size-full object-cover" />
                )}
            </div>

            {/* Kept separate from the video wrapper above (and NOT shifted with it) - this fade
                graphic is calibrated to fade out right where the nav/content take over, which is
                a fixed point in the viewport regardless of which part of the video is showing. */}
            <div
                aria-hidden
                className="hero-video-overlay pointer-events-none fixed inset-0 -z-10 h-screen w-screen"
            />

            <a
                ref={discordRef}
                href="https://discord.gg/clanaod"
                title="Join the AOD Discord"
                target="_blank"
                rel="noopener noreferrer"
                className="pointer-events-auto fixed top-6 left-1/2 z-50 -translate-x-1/2 inline-flex items-center gap-2 rounded-full border border-white/15 bg-black/40 px-4 py-1.5 text-xs font-medium tracking-wide text-white/90 backdrop-blur-sm transition-all duration-300 hover:border-white/30 hover:bg-black/60"
            >
                <DiscordIcon className="size-4 text-[#5865F2]" />
                JOIN US ON DISCORD
                {discordOnline !== undefined && discordTotal !== undefined && (
                    <span className="text-white/60">
                        · ONLINE: {discordOnline} / {discordTotal}
                    </span>
                )}
            </a>

            {/* top-[27.5vh] centers this within the hero space - half of the 55vh spacer in
                home.tsx that separates the hero from the nav/content below. Keep the two in sync. */}
            <div
                ref={textRef}
                className="fixed top-[27.5vh] left-1/2 z-50 w-full max-w-4xl -translate-x-1/2 -translate-y-1/2 px-4 text-center text-white transition-opacity duration-300"
            >
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
