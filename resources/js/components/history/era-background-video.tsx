import { useYouTubeCoverVideo } from '@/hooks/use-youtube-cover-video';

interface EraBackgroundVideoProps {
    videoId: string;
}

export function EraBackgroundVideo({ videoId }: EraBackgroundVideoProps) {
    const { containerRef, targetRef } = useYouTubeCoverVideo(videoId);

    return (
        <div ref={containerRef} className="era-video">
            <div ref={targetRef} />
        </div>
    );
}
