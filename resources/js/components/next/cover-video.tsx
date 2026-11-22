import { useMediaQuery } from '@/hooks/use-media-query';
import { useYouTubeCoverVideo } from '@/hooks/use-youtube-cover-video';
import { cn } from '@/lib/utils';

interface CoverVideoProps {
    videoId: string | null | undefined;
    className?: string;
}

export function CoverVideo({ videoId, className }: CoverVideoProps) {
    const wide = useMediaQuery('(min-width: 768px)');
    const calm = useMediaQuery('(prefers-reduced-motion: reduce)');
    const enabled = Boolean(videoId) && wide && !calm;
    const { containerRef, targetRef } = useYouTubeCoverVideo(videoId ?? '', enabled);

    if (!enabled) {
        return null;
    }

    return (
        <div className={cn('next-cover-video', className)} aria-hidden="true">
            <div ref={containerRef} className="absolute inset-0 grid place-items-center overflow-hidden">
                <div ref={targetRef} />
            </div>
        </div>
    );
}
