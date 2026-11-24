import { useState } from 'react';

import { useInView } from '@/hooks/use-in-view';
import { useMediaQuery } from '@/hooks/use-media-query';
import { usePageVisible } from '@/hooks/use-page-visible';
import { useYouTubeCoverVideo } from '@/hooks/use-youtube-cover-video';
import { cn } from '@/lib/utils';

interface CoverVideoProps {
    videoId: string | null | undefined;
    className?: string;
}

export function CoverVideo({ videoId, className }: CoverVideoProps) {
    if (!videoId) {
        return null;
    }

    return <CoverVideoFrame videoId={videoId} className={className} />;
}

function CoverVideoFrame({ videoId, className }: { videoId: string; className?: string }) {
    const wide = useMediaQuery('(min-width: 768px)');
    const calm = useMediaQuery('(prefers-reduced-motion: reduce)');
    const visible = usePageVisible();
    const [poster, setPoster] = useState('maxresdefault');
    const { ref, inView, seen } = useInView<HTMLDivElement>({ rootMargin: '200px 0px' });
    const { containerRef, targetRef } = useYouTubeCoverVideo(videoId, seen && wide && !calm, inView && visible);

    return (
        <div ref={ref} className={cn('next-cover-video', className)} aria-hidden="true">
            {seen && (
                <img
                    src={`https://i.ytimg.com/vi/${videoId}/${poster}.jpg`}
                    alt=""
                    decoding="async"
                    onError={() => setPoster('hqdefault')}
                    className="absolute inset-0 size-full scale-110 object-cover"
                />
            )}
            <div ref={containerRef} className="absolute inset-0 grid place-items-center overflow-hidden">
                <div ref={targetRef} />
            </div>
        </div>
    );
}
