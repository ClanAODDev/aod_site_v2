import { Play } from 'lucide-react';
import { useState } from 'react';

import { Dialog, DialogContent, DialogTitle } from '@/components/ui/dialog';

export function IntroVideo({ videoId }: { videoId: string | null }) {
    const [open, setOpen] = useState(false);

    if (!videoId) {
        return null;
    }

    return (
        <>
            <button type="button" onClick={() => setOpen(true)} className="next-intro-button group" aria-label="Watch the AOD intro video">
                <span className="next-intro-ring" aria-hidden="true">
                    <Play className="size-5 translate-x-0.5 fill-current" />
                </span>
                <span className="next-heading text-sm font-bold uppercase tracking-[0.2em] text-foreground/90 group-hover:text-foreground">Watch the intro</span>
            </button>
            <Dialog open={open} onOpenChange={setOpen}>
                <DialogContent className="next-root max-w-[min(64rem,calc(100%-2rem))] gap-0 overflow-hidden rounded-none border-border bg-black p-0 sm:max-w-[min(64rem,calc(100%-2rem))]">
                    <DialogTitle className="sr-only">Angels of Death intro video</DialogTitle>
                    {open && (
                        <iframe
                            src={`https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1`}
                            title="Angels of Death intro video"
                            allow="autoplay; encrypted-media; picture-in-picture; fullscreen"
                            allowFullScreen
                            className="aspect-video w-full"
                        />
                    )}
                </DialogContent>
            </Dialog>
        </>
    );
}
