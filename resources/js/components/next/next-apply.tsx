import { DiscordIcon } from '@/components/icons/discord-icon';
import { AodMark } from '@/components/next/aod-mark';
import { DialogContent, DialogDescription, DialogTitle } from '@/components/ui/dialog';
import { DISCORD_REGISTRATION_URL } from '@/lib/registration';
import type { Division } from '@/types';

const STEPS = [
    { title: 'Continue with Discord', body: 'Sign in with your Discord account.' },
    { title: 'Choose your name and division', body: 'Pick a forum name, set a password and choose the game you want to play with us.' },
    { title: 'Meet your division', body: "Your division's recruiters take it from there." },
];

const ICON_SPOTS = ['left-[6%] top-[7%]', 'right-[6%] top-[9%]', 'left-[3%] top-[40%]', 'right-[3%] top-[44%]'];

export function NextApplyContent({ icons }: { icons: Division[] }) {
    return (
        <DialogContent className="next-root next-apply max-w-[calc(100%-2rem)] gap-0 overflow-hidden rounded-none border-border p-0 sm:max-w-md">
            <div aria-hidden="true" className="next-apply-icons pointer-events-none absolute inset-0">
                {icons.slice(0, ICON_SPOTS.length).map((division, index) => (
                    <img key={division.slug} src={division.icon} alt="" className={`absolute size-14 object-contain ${ICON_SPOTS[index]}`} />
                ))}
            </div>

            <div className="relative px-7 pb-7 pt-9 text-center sm:px-9">
                <AodMark className="next-mark-glow mx-auto block size-16" />
                <p className="mt-5 font-mono text-xs uppercase tracking-[0.3em] next-red-text">Join the ranks</p>
                <DialogTitle className="next-heading mt-1 text-3xl font-bold uppercase tracking-wide text-foreground">Join Angels of Death</DialogTitle>
                <DialogDescription className="sr-only">Three steps to join: continue with Discord, choose your name and division, then meet your division.</DialogDescription>

                <ol className="mt-7 space-y-4 text-left">
                    {STEPS.map((step, index) => (
                        <li key={step.title} className="flex gap-4">
                            <span className="next-apply-step" aria-hidden="true">
                                {index + 1}
                            </span>
                            <span>
                                <span className="next-heading block text-lg font-bold uppercase leading-tight text-foreground">{step.title}</span>
                                <span className="mt-0.5 block text-sm text-muted-foreground">{step.body}</span>
                            </span>
                        </li>
                    ))}
                </ol>

                <a href={DISCORD_REGISTRATION_URL} className="next-button next-button-lg mt-8 w-full whitespace-nowrap px-4 tracking-[0.08em]">
                    <DiscordIcon className="size-5" /> Continue with Discord
                </a>
                <p className="mt-4 text-xs leading-relaxed text-muted-foreground">
                    You'll need a Discord account with an email address, and you must be 13 or older. Already started? The same button picks up where you left off.
                </p>
            </div>
        </DialogContent>
    );
}
