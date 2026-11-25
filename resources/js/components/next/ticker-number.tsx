import type { CSSProperties } from 'react';

import { useInView } from '@/hooks/use-in-view';
import { cn } from '@/lib/utils';

const REEL = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

interface TickerNumberProps {
    value: number | undefined;
    delay?: number;
    className?: string;
}

export function TickerNumber({ value, delay = 0, className }: TickerNumberProps) {
    const { ref, seen } = useInView<HTMLSpanElement>({ once: true });

    if (typeof value !== 'number') {
        return <span className={className}>—</span>;
    }

    const text = value.toLocaleString('en-US');
    let digitIndex = 0;

    return (
        <span ref={ref} className={cn('next-ticker', className)}>
            <span className="sr-only">{text}</span>
            <span aria-hidden="true" className="inline-flex">
                {[...text].map((char, position) => {
                    if (!/\d/.test(char)) {
                        return <span key={position}>{char}</span>;
                    }
                    const order = digitIndex++;
                    const style = {
                        '--ticker-stop': seen ? 10 + Number(char) : 0,
                        transitionDelay: `${delay + order * 90}ms`,
                    } as CSSProperties;

                    return (
                        <span key={position} className="next-ticker-window">
                            <span className="next-ticker-reel" style={style}>
                                {REEL.map((digit, index) => (
                                    <span key={index}>{digit}</span>
                                ))}
                            </span>
                        </span>
                    );
                })}
            </span>
        </span>
    );
}
