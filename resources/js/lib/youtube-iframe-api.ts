export interface YouTubePlayer {
    destroy(): void;
    mute(): void;
    playVideo(): void;
}

export interface YouTubePlayerEvent {
    target: YouTubePlayer;
    data: number;
}

export interface YouTubePlayerOptions {
    videoId: string;
    playerVars: Record<string, number | string>;
    events: {
        onReady?: (event: YouTubePlayerEvent) => void;
        onStateChange?: (event: YouTubePlayerEvent) => void;
    };
}

export interface YouTubeNamespace {
    Player: new (element: HTMLElement, options: YouTubePlayerOptions) => YouTubePlayer;
    PlayerState: { ENDED: number };
}

declare global {
    interface Window {
        YT?: YouTubeNamespace;
        onYouTubeIframeAPIReady?: () => void;
    }
}

let apiPromise: Promise<YouTubeNamespace> | null = null;

/** Loads the YouTube IFrame API once and shares the result across every caller. */
export function loadYouTubeIframeApi(): Promise<YouTubeNamespace> {
    if (apiPromise) {
        return apiPromise;
    }

    apiPromise = new Promise((resolve) => {
        if (window.YT) {
            resolve(window.YT);
            return;
        }

        const previous = window.onYouTubeIframeAPIReady;
        window.onYouTubeIframeAPIReady = () => {
            previous?.();
            resolve(window.YT as YouTubeNamespace);
        };

        const script = document.createElement('script');
        script.src = 'https://www.youtube.com/iframe_api';
        document.head.appendChild(script);
    });

    return apiPromise;
}
