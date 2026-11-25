import type { SectionLink } from '@/hooks/use-section-links';

export function SectionLinks({ links }: { links: SectionLink[] }) {
    if (links.length < 2) {
        return null;
    }

    return (
        <nav aria-label="On this page" className="mb-8 flex flex-wrap gap-2">
            {links.map((link) => (
                <a key={link.id} href={`#${link.id}`} className="next-button-ghost min-h-9 px-3 py-1 text-sm">
                    {link.label}
                </a>
            ))}
        </nav>
    );
}
