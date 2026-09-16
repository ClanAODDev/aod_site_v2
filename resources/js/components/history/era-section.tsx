import type { ReactNode } from 'react';

import { EraBackgroundVideo } from '@/components/history/era-background-video';
import { useInView } from '@/hooks/use-in-view';

type EraBackground = { type: 'video'; videoId: string } | { type: 'image'; src: string } | { type: 'none' };

interface EraSectionProps {
    background: EraBackground;
    children: ReactNode;
}

export function EraSection({ background, children }: EraSectionProps) {
    const { ref, inView } = useInView<HTMLDivElement>({ rootMargin: '-30% 0px -30% 0px' });

    return (
        <section ref={ref} data-era-visible={inView} className="relative flex min-h-screen flex-col items-center justify-center overflow-hidden py-24">
            {background.type !== 'none' && (
                <div
                    className="era-background"
                    style={background.type === 'image' ? { backgroundImage: `url(${background.src})` } : undefined}
                >
                    {background.type === 'video' && <EraBackgroundVideo videoId={background.videoId} />}
                </div>
            )}
            {children}
        </section>
    );
}
