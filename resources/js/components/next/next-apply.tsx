import { usePage } from '@inertiajs/react';

import { DiscordIcon } from '@/components/icons/discord-icon';
import { AodMark } from '@/components/next/aod-mark';
import { DialogContent, DialogDescription, DialogTitle } from '@/components/ui/dialog';
import { DISCORD_REGISTRATION_URL } from '@/lib/registration';
import type { SharedPageProps } from '@/types';

const STEPS = [
    { title: 'Continue with Discord', body: 'Sign in with your Discord account.' },
    { title: 'Choose your name and division', body: 'Pick a forum name, set a password and choose the game you want to play with us.' },
    { title: 'Meet your division', body: "Your division's recruiters take it from there." },
];

export function NextApplyContent() {
    const { divisions } = usePage<SharedPageProps>().props;

    return (
        <DialogContent className="next-root next-apply max-w-[calc(100%-2rem)] gap-0 overflow-hidden rounded-none border-border p-0 sm:max-w-md">
            <div className="relative px-7 pt-9 pb-7 text-center sm:px-9">
                <AodMark className="next-mark-glow mx-auto block size-16" />
                <p className="next-red-text mt-5 font-mono text-xs tracking-[0.3em] uppercase">Join the ranks</p>
                <DialogTitle className="next-heading mt-1 text-3xl font-bold tracking-wide text-foreground uppercase">
                    Join Angels of Death
                </DialogTitle>
                <DialogDescription className="sr-only">
                    Three steps to join: continue with Discord, choose your name and division, then meet your division.
                </DialogDescription>

                {divisions.length > 0 && (
                    <div className="mt-6">
                        <div className="next-apply-marquee" aria-hidden="true">
                            <div className="next-apply-marquee-track" style={{ animationDuration: `${divisions.length * 3}s` }}>
                                {[...divisions, ...divisions].map((division, index) => (
                                    <img key={`${division.slug}-${index}`} src={division.icon} alt="" className="size-10 shrink-0 object-contain" />
                                ))}
                            </div>
                        </div>
                        <p className="mt-2 font-mono text-[11px] tracking-widest text-muted-foreground uppercase">
                            {divisions.length} divisions to choose from
                        </p>
                    </div>
                )}

                <ol className="mt-6 space-y-4 text-left">
                    {STEPS.map((step, index) => (
                        <li key={step.title} className="flex gap-4">
                            <span className="next-apply-step" aria-hidden="true">
                                {index + 1}
                            </span>
                            <span>
                                <span className="next-heading block text-lg leading-tight font-bold text-foreground uppercase">{step.title}</span>
                                <span className="mt-0.5 block text-sm text-muted-foreground">{step.body}</span>
                            </span>
                        </li>
                    ))}
                </ol>

                <a href={DISCORD_REGISTRATION_URL} className="next-button next-button-lg mt-8 w-full px-4 tracking-[0.08em] whitespace-nowrap">
                    <DiscordIcon className="size-5" /> Continue with Discord
                </a>
                <p className="mt-4 text-xs leading-relaxed text-muted-foreground">
                    You'll need a Discord account with an email address, and you must be 13 or older. Already started? The same button picks up where
                    you left off.
                </p>
            </div>
        </DialogContent>
    );
}
