import { useEffect, useRef, useState } from 'react';

import { loadYouTubeIframeApi, type YouTubePlayer } from '@/lib/youtube-iframe-api';

interface EraBackgroundVideoProps {
    videoId: string;
}

const ASPECT_RATIO = 16 / 9;

export function EraBackgroundVideo({ videoId }: EraBackgroundVideoProps) {
    const containerRef = useRef<HTMLDivElement>(null);
    const [iframe, setIframe] = useState<HTMLIFrameElement | null>(null);

    useEffect(() => {
        const container = containerRef.current;
        if (!container) {
            return;
        }

        let player: YouTubePlayer | null = null;
        let cancelled = false;

        loadYouTubeIframeApi().then((YT) => {
            if (cancelled) {
                return;
            }

            player = new YT.Player(container, {
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
    }, [videoId]);

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

    return <div ref={containerRef} className="era-video" />;
}
