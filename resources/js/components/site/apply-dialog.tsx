import { usePage } from '@inertiajs/react';
import { createContext, useContext, useMemo, useState, type CSSProperties, type ReactNode } from 'react';

import { DiscordIcon } from '@/components/icons/discord-icon';
import { Dialog, DialogContent, DialogTitle } from '@/components/ui/dialog';
import type { SharedPageProps } from '@/types';

const ApplyDialogContext = createContext<(() => void) | null>(null);

/** Matches the original site's 8 fixed slots and slow drift animations for the modal's background
 * division icons - see `.floating-icon:nth-child(n)` and `@keyframes floatDriftN` in the legacy CSS. */
const FLOATING_ICON_POSITIONS: CSSProperties[] = [
    { top: '10%', left: '5%', animation: 'floatDrift1 25s ease-in-out infinite' },
    { top: '5%', right: '10%', animation: 'floatDrift2 30s ease-in-out infinite' },
    { top: '40%', left: '2%', animation: 'floatDrift3 28s ease-in-out infinite' },
    { top: '35%', right: '5%', animation: 'floatDrift4 22s ease-in-out infinite' },
    { bottom: '30%', left: '8%', animation: 'floatDrift5 26s ease-in-out infinite' },
    { bottom: '25%', right: '3%', animation: 'floatDrift6 24s ease-in-out infinite' },
    { bottom: '10%', left: '15%', animation: 'floatDrift7 27s ease-in-out infinite' },
    { bottom: '5%', right: '15%', animation: 'floatDrift8 23s ease-in-out infinite' },
];

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
                    <div aria-hidden className="pointer-events-none absolute inset-0 overflow-hidden">
                        {floatingIcons.map((division, index) => (
                            <img
                                key={division.slug}
                                src={division.icon}
                                alt=""
                                className="floating-icon absolute opacity-[0.06] grayscale blur-[1px]"
                                style={FLOATING_ICON_POSITIONS[index % FLOATING_ICON_POSITIONS.length]}
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
