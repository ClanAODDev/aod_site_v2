import { useEffect, useRef, useState } from 'react';

import { loadYouTubeIframeApi, type YouTubePlayer } from '@/lib/youtube-iframe-api';

const ASPECT_RATIO = 16 / 9;

/**
 * Mounts a muted, looping, autoplaying YouTube player that always covers its
 * container (like `object-fit: cover`, which iframes don't support natively).
 * Attach `containerRef` to the sizing wrapper and `targetRef` to an empty
 * child div inside it - the player replaces that child in the DOM, so the
 * container itself (and the ref used to measure it) stays intact.
 *
 * Pass `enabled: false` to skip loading the API/mounting a player entirely
 * (e.g. showing a static poster on mobile instead of an autoplaying video).
 */
export function useYouTubeCoverVideo(videoId: string, enabled: boolean = true) {
    const containerRef = useRef<HTMLDivElement>(null);
    const targetRef = useRef<HTMLDivElement>(null);
    const [iframe, setIframe] = useState<HTMLIFrameElement | null>(null);

    useEffect(() => {
        const container = containerRef.current;
        const target = targetRef.current;
        if (!container || !target || !enabled) {
            return;
        }

        let player: YouTubePlayer | null = null;
        let cancelled = false;

        loadYouTubeIframeApi().then((YT) => {
            if (cancelled) {
                return;
            }

            player = new YT.Player(target, {
                videoId,
                playerVars: {
                    autoplay: 1,
                    mute: 1,
                    controls: 0,
                    loop: 1,
                    playlist: videoId,
                    playsinline: 1,
                    rel: 0,
                    modestbranding: 1,
                    origin: window.location.origin,
                },
                events: {
                    onReady: (event) => {
                        event.target.mute();
                        event.target.playVideo();
                        setIframe(container.querySelector('iframe'));
                    },
                    onStateChange: (event) => {
                        if (event.data === YT.PlayerState.ENDED) {
                            player?.playVideo();
                        }
                    },
                },
            });
        });

        return () => {
            cancelled = true;
            player?.destroy();
        };
    }, [videoId, enabled]);

    useEffect(() => {
        const container = containerRef.current;
        if (!container || !iframe) {
            return;
        }

        const scale = () => {
            const { width: containerWidth, height: containerHeight } = container.getBoundingClientRect();
            let width = containerWidth;
            let height = containerWidth / ASPECT_RATIO;

            if (height < containerHeight) {
                height = containerHeight;
                width = containerHeight * ASPECT_RATIO;
            }

            iframe.style.width = `${width}px`;
            iframe.style.height = `${height}px`;
        };

        scale();
        const observer = new ResizeObserver(scale);
        observer.observe(container);
        return () => observer.disconnect();
    }, [iframe]);

    return { containerRef, targetRef };
}
