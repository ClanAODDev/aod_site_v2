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
    const wide = useMediaQuery('(min-width: 768px)');
    const calm = useMediaQuery('(prefers-reduced-motion: reduce)');

    if (!videoId || !wide || calm) {
        return null;
    }

    return <CoverVideoPlayer videoId={videoId} className={className} />;
}

function CoverVideoPlayer({ videoId, className }: { videoId: string; className?: string }) {
    const { ref, inView, seen } = useInView<HTMLDivElement>({ rootMargin: '200px 0px' });
    const visible = usePageVisible();
    const { containerRef, targetRef } = useYouTubeCoverVideo(videoId, seen, inView && visible);

    return (
        <div ref={ref} className={cn('next-cover-video', className)} aria-hidden="true">
            <div ref={containerRef} className="absolute inset-0 grid place-items-center overflow-hidden">
                <div ref={targetRef} />
            </div>
        </div>
    );
}
