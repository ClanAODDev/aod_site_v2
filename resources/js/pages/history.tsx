import { Head } from '@inertiajs/react';

import { EraSection } from '@/components/history/era-section';
import { TimelineBlock } from '@/components/history/timeline-block';
import { SiteLayout } from '@/layouts/site-layout';
import { historyEras } from '@/lib/history-eras';

interface HistoryProps {
    foundationsEraVideoId: string;
    modernEraVideoId: string;
}

export default function History({ foundationsEraVideoId, modernEraVideoId }: HistoryProps) {
    const eras = historyEras({ foundations: foundationsEraVideoId, modern: modernEraVideoId });

    return (
        <SiteLayout>
            <Head title="History of AOD" />

            {eras.map((era) => (
                <EraSection key={era.key} background={era.background}>
                    {era.entries.map((entry) => (
                        <TimelineBlock key={entry.title} {...entry} />
                    ))}
                </EraSection>
            ))}
        </SiteLayout>
    );
}
