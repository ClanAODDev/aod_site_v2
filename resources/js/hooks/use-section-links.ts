import { useEffect, useRef, useState } from 'react';

export interface SectionLink {
    id: string;
    label: string;
}

export function useSectionLinks(content?: string | null) {
    const ref = useRef<HTMLDivElement>(null);
    const [links, setLinks] = useState<SectionLink[]>([]);

    useEffect(() => {
        const headings = Array.from(ref.current?.querySelectorAll('h2') ?? []);
        setLinks(
            headings.map((heading, index) => {
                heading.id ||= `section-${index}`;
                return { id: heading.id, label: heading.textContent ?? '' };
            }),
        );
    }, [content]);

    return { ref, links };
}
