import { cn } from '@/lib/utils';

export function SantaHat({ className }: { className?: string }) {
    return (
        <svg viewBox="0 0 120 100" className={cn('pointer-events-none', className)} aria-hidden="true">
            <path d="M20 72 C26 34 56 10 90 14 C108 16 114 30 108 42 C100 34 88 32 82 38 C76 48 92 60 98 72 Z" fill="#d20000" />
            <path d="M58 26 C72 18 92 16 104 24 C96 22 82 24 72 32 C66 38 66 52 74 66 C58 56 52 38 58 26 Z" fill="#6d0202" opacity="0.55" />
            <circle cx="107" cy="44" r="10" fill="#f4f1ee" />
            <rect x="10" y="66" width="100" height="22" rx="11" fill="#f4f1ee" />
            <path d="M16 74 H104" stroke="#d9d3cd" strokeWidth="3" strokeLinecap="round" strokeDasharray="1 7" />
        </svg>
    );
}
