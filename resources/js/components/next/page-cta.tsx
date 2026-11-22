import { ArrowRight } from 'lucide-react';
import type { ReactNode } from 'react';

import { useOpenApplyDialog } from '@/components/site/apply-dialog';

interface PageCtaProps {
    title: string;
    children: ReactNode;
    link: { href: string; label: string };
}

export function PageCta({ title, children, link }: PageCtaProps) {
    const openApply = useOpenApplyDialog();

    return (
        <section className="next-join relative overflow-hidden border-t border-primary/40 px-4 py-20 text-center sm:px-6">
            <h2 className="next-heading text-4xl font-bold uppercase text-foreground sm:text-5xl">{title}</h2>
            <p className="mx-auto mt-3 max-w-2xl text-lg text-muted-foreground">{children}</p>
            <div className="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <button type="button" onClick={openApply} className="next-button next-button-lg">
                    Join AOD <ArrowRight className="size-5" />
                </button>
                <a href={link.href} className="next-button-ghost next-button-lg">
                    {link.label}
                </a>
            </div>
        </section>
    );
}
