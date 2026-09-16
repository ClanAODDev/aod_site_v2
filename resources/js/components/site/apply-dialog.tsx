import { usePage } from '@inertiajs/react';
import { createContext, useContext, useMemo, useState, type ReactNode } from 'react';

import { DiscordIcon } from '@/components/icons/discord-icon';
import { Dialog, DialogContent, DialogTitle } from '@/components/ui/dialog';
import type { SharedPageProps } from '@/types';

const ApplyDialogContext = createContext<(() => void) | null>(null);

export function useOpenApplyDialog() {
    const open = useContext(ApplyDialogContext);
    if (!open) {
        throw new Error('useOpenApplyDialog must be used within an ApplyDialogProvider');
    }
    return open;
}

export function ApplyDialogProvider({ children }: { children: ReactNode }) {
    const [open, setOpen] = useState(false);
    const { divisions } = usePage<SharedPageProps>().props;

    const floatingIcons = useMemo(
        () =>
            [...divisions]
                .sort(() => Math.random() - 0.5)
                .slice(0, 8),
        [divisions],
    );

    return (
        <ApplyDialogContext.Provider value={() => setOpen(true)}>
            {children}
            <Dialog open={open} onOpenChange={setOpen}>
                <DialogContent className="overflow-hidden sm:max-w-md">
                    <div aria-hidden className="pointer-events-none absolute inset-0 overflow-hidden opacity-20">
                        {floatingIcons.map((division, index) => (
                            <img
                                key={division.slug}
                                src={division.icon}
                                alt=""
                                className="absolute size-10 animate-bounce"
                                style={{
                                    left: `${(index * 37) % 100}%`,
                                    top: `${(index * 53) % 100}%`,
                                    animationDelay: `${index * 0.5}s`,
                                    animationDuration: '3s',
                                }}
                            />
                        ))}
                    </div>

                    <div className="relative flex flex-col items-center gap-4 py-4 text-center">
                        <DialogTitle className="text-xl">Register an account</DialogTitle>
                        <p className="text-sm text-muted-foreground">
                            You must have an account in order to apply for one of our divisions.
                        </p>
                        <a
                            href="https://tracker.clanaod.net/auth/discord"
                            target="_blank"
                            rel="noreferrer"
                            className="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90"
                        >
                            <DiscordIcon className="size-4" />
                            Register with Discord
                        </a>
                    </div>
                </DialogContent>
            </Dialog>
        </ApplyDialogContext.Provider>
    );
}
