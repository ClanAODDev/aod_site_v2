import { cn } from '@/lib/utils';
import { useInView } from '@/hooks/use-in-view';

export interface TimelineTag {
    label: string;
    highlight?: boolean;
}

export interface TimelineEntry {
    title: string;
    dateRange: string;
    description: string;
    tags: TimelineTag[];
}

export function TimelineBlock({ title, dateRange, description, tags }: TimelineEntry) {
    const { ref, inView } = useInView<HTMLDivElement>({ once: true, rootMargin: '0px 0px -15% 0px' });

    return (
        <div ref={ref} className="relative mx-auto mb-20 max-w-3xl px-4 md:mb-28">
            <div
                data-visible={inView}
                className="timeline-bullet absolute top-2 left-1/2 z-10 flex size-16 items-center justify-center rounded-full border-2 border-primary/60 bg-primary/80 shadow-[0_0_20px_var(--primary-glow)] md:top-5 md:size-20"
            >
                <img src="/images/cd-icon-location.svg" alt="" className="size-8 md:size-10" />
            </div>

            <div
                data-visible={inView}
                className="timeline-content tron-hatch mt-24 rounded-xl border border-border bg-card/70 p-6 shadow-lg backdrop-blur-md md:mt-28 md:p-10"
            >
                <h2 className="timeline-content-field text-2xl font-bold text-foreground [text-shadow:2px_2px_4px_rgba(0,0,0,0.5)] md:text-4xl">
                    {title}
                </h2>
                <p
                    className="timeline-content-field mb-6 text-lg font-bold text-primary [text-shadow:1px_1px_2px_rgba(0,0,0,0.5)]"
                    style={{ transitionDelay: '0.15s' }}
                >
                    {dateRange}
                </p>
                <p className="timeline-content-field text-base leading-relaxed text-foreground/90" style={{ transitionDelay: '0.3s' }}>
                    {description}
                </p>
                <div className="timeline-content-field mt-6 flex flex-wrap gap-2" style={{ transitionDelay: '0.45s' }}>
                    {tags.map((tag) => (
                        <span
                            key={tag.label}
                            className={cn(
                                'rounded border px-4 py-2 text-sm backdrop-blur-sm transition-all hover:-translate-y-0.5 hover:shadow-lg',
                                tag.highlight
                                    ? 'border-primary/60 bg-primary/40 font-semibold text-foreground hover:bg-primary/60'
                                    : 'border-border-strong bg-white/8 text-foreground/95 hover:bg-white/15',
                            )}
                        >
                            {tag.label}
                        </span>
                    ))}
                </div>
            </div>
        </div>
    );
}
