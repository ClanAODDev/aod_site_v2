export interface TwitchPlayer {
    setMuted(muted: boolean): void;
    play(): void;
}

export interface TwitchEmbed {
    addEventListener(event: string, callback: () => void): void;
    getPlayer(): TwitchPlayer;
}

export interface TwitchEmbedOptions {
    width: string | number;
    height: string | number;
    channel: string;
    layout?: 'video';
    autoplay?: boolean;
    muted?: boolean;
    parent: string[];
}

interface TwitchNamespace {
    Embed: {
        new (elementId: string, options: TwitchEmbedOptions): TwitchEmbed;
        VIDEO_READY: string;
    };
}

declare global {
    interface Window {
        Twitch?: TwitchNamespace;
    }
}

let apiPromise: Promise<TwitchNamespace> | null = null;

/** Loads the Twitch embed SDK once and shares the result across every caller. */
export function loadTwitchEmbedApi(): Promise<TwitchNamespace> {
    if (apiPromise) {
        return apiPromise;
    }

    apiPromise = new Promise((resolve) => {
        if (window.Twitch) {
            resolve(window.Twitch);
            return;
        }

        const script = document.createElement('script');
        script.src = 'https://embed.twitch.tv/embed/v1.js';
        script.onload = () => resolve(window.Twitch as TwitchNamespace);
        document.head.appendChild(script);
    });

    return apiPromise;
}
