import { ShieldAlert } from 'lucide-react';

import { NextLayout } from '@/components/next/next-layout';
import { PageCta } from '@/components/next/page-cta';
import { PageHero } from '@/components/next/page-hero';
import { Reveal } from '@/components/reveal';

interface CodeOfConductProps {
    foundedYear: number;
    currentYear: number;
}

const RULES = [
    'Strive to conduct ourselves in an appropriate manner.',
    'Offer help to anyone who seeks it, if it is possible.',
    'Project a positive image of yourself and the AOD clan to others.',
    'Put the needs of the clan first, above personal goals.',
    'Support members of AOD.',
    'Attempt to resolve personal differences directly with the concerned individual(s).',
    'Remind other AOD members of expected conduct in a tactful, non-threatening way, and if possible, in private.',
    'Promote fellowship within the game community.',
    'Do not condemn or humiliate other clan members.',
    'Win and lose games honorably. Show sportsmanship.',
    'Maintain AOD loyalty.',
    'No comments about politics, religion, skin color, sexual preferences, or sexual conduct. We are here to play games.',
];

export default function CodeOfConduct({ foundedYear, currentYear }: CodeOfConductProps) {

    return (
        <NextLayout title="Code of Conduct | Prototype" foundedYear={foundedYear} currentYear={currentYear}>
            <PageHero eyebrow="Code of conduct" title="An honor clan first">
                <p>
                    The Code of Conduct is the face of our clan. It is more than a guideline for behavior: it says what kind of gamers we are, and who we are looking for.
                </p>
            </PageHero>

            <section className="border-t border-border px-4 py-20 sm:px-6">
                <div className="mx-auto max-w-6xl">
                    <Reveal>
                        <div className="next-panel mx-auto flex max-w-3xl flex-col items-center gap-4 p-6 text-center sm:flex-row sm:p-8 sm:text-left">
                            <ShieldAlert className="size-12 shrink-0 text-primary" aria-hidden="true" />
                            <div>
                                <p className="next-heading text-2xl font-bold uppercase tracking-wide text-foreground sm:text-3xl">Zero tolerance</p>
                                <p className="mt-1 text-muted-foreground">for hacking or any other malicious game modding.</p>
                            </div>
                        </div>
                    </Reveal>

                    <ol className="mt-14 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        {RULES.map((rule, index) => (
                            <li key={rule}>
                                <Reveal delay={(index % 3) * 80} className="h-full">
                                    <div className="next-panel next-rule h-full p-6">
                                        <span className="next-heading block text-5xl font-bold leading-none next-red-text" aria-hidden="true">
                                            {String(index + 1).padStart(2, '0')}
                                        </span>
                                        <p className="mt-4 leading-relaxed text-foreground/90">{rule}</p>
                                    </div>
                                </Reveal>
                            </li>
                        ))}
                    </ol>
                </div>
            </section>

            <PageCta title="Agreed on day one" link={{ href: '/next/ranks', label: 'See the ranking structure' }}>
                Every member agrees to the Code of Conduct when they are accepted into the clan, and upholds it at all times.{' '}
                <strong className="text-foreground">Violating it means removal from AOD.</strong>
            </PageCta>
        </NextLayout>
    );
}
