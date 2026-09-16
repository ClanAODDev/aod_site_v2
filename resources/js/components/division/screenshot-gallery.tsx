import { ChevronLeft, ChevronRight, Search } from 'lucide-react';
import { useEffect, useState } from 'react';

import { Dialog, DialogContent, DialogTitle } from '@/components/ui/dialog';

interface Screenshot {
    url: string;
    caption?: string;
}

export function ScreenshotGallery({ screenshots }: { screenshots: Screenshot[] }) {
    const [openIndex, setOpenIndex] = useState<number | null>(null);

    useEffect(() => {
        if (openIndex === null) {
            return;
        }

        function handleKeydown(event: KeyboardEvent) {
            if (event.key === 'ArrowLeft') {
                setOpenIndex((current) => (current === null ? current : (current - 1 + screenshots.length) % screenshots.length));
            } else if (event.key === 'ArrowRight') {
                setOpenIndex((current) => (current === null ? current : (current + 1) % screenshots.length));
            }
        }

        window.addEventListener('keydown', handleKeydown);
        return () => window.removeEventListener('keydown', handleKeydown);
    }, [openIndex, screenshots.length]);

    if (screenshots.length === 0) {
        return null;
    }

    const current = openIndex !== null ? screenshots[openIndex] : null;

    return (
        <div className="my-10">
            <h2 className="mb-5 text-xl font-semibold text-foreground uppercase">Screenshots</h2>

            <div className="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                {screenshots.map((screenshot, index) => (
                    <button
                        key={screenshot.url}
                        onClick={() => setOpenIndex(index)}
                        className="group relative aspect-video overflow-hidden rounded-lg border border-border transition-colors hover:border-white/50"
                    >
                        <img
                            src={screenshot.url}
                            alt={screenshot.caption || 'Division screenshot'}
                            loading="lazy"
                            className="size-full object-cover"
                        />
                        <div className="absolute inset-0 flex items-center justify-center bg-black/0 text-white/0 transition-all group-hover:bg-black/50 group-hover:text-white/90">
                            <Search className="size-6" />
                        </div>
                    </button>
                ))}
            </div>

            <Dialog open={openIndex !== null} onOpenChange={(open) => setOpenIndex(open ? openIndex : null)}>
                <DialogContent showCloseButton className="max-w-4xl border-none bg-transparent p-0 shadow-none">
                    <DialogTitle className="sr-only">{current?.caption || 'Screenshot'}</DialogTitle>
                    {current && (
                        <div className="relative text-center">
                            <img src={current.url} alt={current.caption || ''} className="mx-auto max-h-[80vh] rounded" />
                            {current.caption && <p className="mt-3 text-sm text-white/80">{current.caption}</p>}
                            <p className="mt-1 text-xs text-white/50">
                                {(openIndex ?? 0) + 1} / {screenshots.length}
                            </p>

                            {screenshots.length > 1 && (
                                <>
                                    <button
                                        onClick={() => setOpenIndex((openIndex! - 1 + screenshots.length) % screenshots.length)}
                                        aria-label="Previous"
                                        className="absolute top-1/2 left-2 -translate-y-1/2 rounded-full p-2 text-white/70 hover:text-white"
                                    >
                                        <ChevronLeft className="size-8" />
                                    </button>
                                    <button
                                        onClick={() => setOpenIndex((openIndex! + 1) % screenshots.length)}
                                        aria-label="Next"
                                        className="absolute top-1/2 right-2 -translate-y-1/2 rounded-full p-2 text-white/70 hover:text-white"
                                    >
                                        <ChevronRight className="size-8" />
                                    </button>
                                </>
                            )}
                        </div>
                    )}
                </DialogContent>
            </Dialog>
        </div>
    );
}
