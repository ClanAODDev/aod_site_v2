import { cn } from '@/lib/utils';

interface AodMarkProps {
    className?: string;
    title?: string;
}

const GAP = '#0c0c0c';

export function AodMark({ className, title = 'Angels of Death' }: AodMarkProps) {
    return (
        <svg viewBox="0 0 200 200" className={cn('text-primary', className)} role="img" aria-label={title}>
            <path d="M100 8 L194 184 L6 184 Z" fill="currentColor" />
            <circle cx="100" cy="112" r="70" fill={GAP} stroke={GAP} strokeWidth="28" />
            <circle cx="100" cy="112" r="70" fill="none" stroke="currentColor" strokeWidth="14" />
            <ellipse cx="100" cy="101" rx="31" ry="52" fill="none" stroke={GAP} strokeWidth="22" />
            <ellipse cx="100" cy="101" rx="31" ry="52" fill="none" stroke="currentColor" strokeWidth="11" />
            <path d="M36 114 C48 180 152 180 164 114 C140 154 60 154 36 114 Z" fill="currentColor" stroke={GAP} strokeWidth="7" strokeLinejoin="round" />
        </svg>
    );
}
