import { cn } from '@/lib/utils';

interface AodMarkProps {
    className?: string;
    title?: string;
}

export function AodMark({ className, title = 'Angels of Death' }: AodMarkProps) {
    return <span role="img" aria-label={title} className={cn('next-mark text-primary', className)} />;
}
