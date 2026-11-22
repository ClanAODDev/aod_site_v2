import { Info } from 'lucide-react';
import type { CSSProperties } from 'react';

import { NextLayout } from '@/components/next/next-layout';
import { PageCta } from '@/components/next/page-cta';
import { PageHero } from '@/components/next/page-hero';
import { Reveal } from '@/components/reveal';

interface RanksProps {
    foundedYear: number;
    currentYear: number;
}

interface Rank {
    abbr: string;
    name: string;
    color: string;
    duties: string;
    divisionOptional?: boolean;
}

interface RankGroup {
    label: string;
    summary: string;
    ranks: Rank[];
}

const ENLISTED_COLOR = '#B8C0C8';

const GROUPS: RankGroup[] = [
    {
        label: 'Clan Admin',
        summary: 'Senior leaders who run AOD as a whole.',
        ranks: [
            {
                abbr: 'SgtMaj',
                name: 'Sergeant Major',
                color: '#F09C58',
                duties: 'Overall leader of Clan AOD, responsible for handling issues within the clan and representing AOD when working with other clan leaders. All major decisions, policy changes, and high-ranking promotions must pass through the Sergeant Major.',
            },
            {
                abbr: 'CmdSgt',
                name: 'Command Sergeant',
                color: '#FFFF00',
                duties: 'Clan leader who assists the Sergeants Major in the leadership of AOD. Instructs clan management across all divisions, supports lower-ranking officers with division issues, and is involved in forum administration, division creation and deletion, Sergeant promotions, and policy changes.',
            },
            {
                abbr: '1stSgt',
                name: 'First Sergeant',
                color: '#00FFFF',
                duties: 'Admin who oversees a number of divisions, assisting members of all ranks. First Sergeants are expected to aid in division decisions and leadership, and to participate in clan-wide decision making.',
            },
            {
                abbr: 'MSgt',
                name: 'Master Sergeant',
                color: '#CC00FF',
                duties: 'Active across a number of divisions, serving as liaison and advisor. Master Sergeants also oversee the communication of all Sergeant promotions.',
            },
        ],
    },
    {
        label: 'Officer',
        summary: 'Leaders inside the divisions, from first recruits to CO.',
        ranks: [
            {
                abbr: 'SSgt',
                name: 'Staff Sergeant',
                color: '#2E2EFE',
                duties: 'Commonly serves as CO or XO. Staff Sergeants are expected to aid newer Sergeants and lower-ranking officers, and moderate division requests. If not serving as a CO or XO, a Staff Sergeant should be active in more than one division, acting as an advisor and informant when requested by AOD leadership.',
            },
            {
                abbr: 'Sgt',
                name: 'Sergeant',
                color: '#00FF00',
                duties: 'Experienced member recognized as a strong leader by division and clan leadership. Sergeants serve as leaders in their full-time divisions and assist in moderating all AOD spaces.',
            },
            {
                abbr: 'Cpl',
                name: 'Corporal',
                color: ENLISTED_COLOR,
                duties: 'Often serves as a Platoon or Squad leader. Corporals are responsible for managing division recruits and setting the tone for daily activities.',
            },
            {
                abbr: 'LCpl',
                name: 'Lance Corporal',
                color: ENLISTED_COLOR,
                duties: 'Often serves as a Squad leader. Lance Corporals assist squad and platoon leaders with tasks as needed to help recruits settle into the clan.',
            },
            {
                abbr: 'Tr',
                name: 'Trainer',
                color: ENLISTED_COLOR,
                divisionOptional: true,
                duties: 'A member who has demonstrated individual ability and has been granted preliminary officer roles to begin recruiting. Their primary focus is helping all new members within their division become productive contributors to the clan.',
            },
        ],
    },
    {
        label: 'Enlisted',
        summary: 'Where everyone starts, and where loyalty is proven.',
        ranks: [
            {
                abbr: 'Spec',
                name: 'Specialist',
                color: ENLISTED_COLOR,
                duties: 'Member with demonstrated skill and game knowledge. A well-tenured member with broad clan experience, and the rank most called upon to mentor others within their division.',
            },
            {
                abbr: 'Pfc',
                name: 'Private First Class',
                color: ENLISTED_COLOR,
                duties: 'Expected to help fellow clan members and set an example for incoming members. Rank is based on merit and time served. At this stage, a member should know and follow the Code of Conduct and strive to be the best representation of AOD they can be.',
            },
            {
                abbr: 'Pvt',
                name: 'Private',
                color: ENLISTED_COLOR,
                duties: 'Rank based on merit and time in AOD. A Private should be regularly active on Discord and consistently demonstrate clan loyalty and honor.',
            },
            {
                abbr: 'Cdt',
                name: 'Cadet',
                color: ENLISTED_COLOR,
                duties: 'Active member who has demonstrated loyalty and honor in their first months in the clan.',
            },
            {
                abbr: 'Rct',
                name: 'Recruit',
                color: ENLISTED_COLOR,
                duties: "New member of AOD. Should begin learning the Code of Conduct and the clan rank system, and be active in both the division's AOD server and on the forums.",
            },
        ],
    },
];

const ROLES = [
    {
        abbr: 'CO',
        label: 'Commanding Officer',
        minimum: 'Sergeant',
        body: "Awarded to members accepted to lead a division. COs run their division as they see fit within AOD's Code of Conduct and policies. This title carries no extra authority outside of the officer's own division.",
    },
    {
        abbr: 'XO',
        label: 'Executive Officer',
        minimum: 'Corporal',
        body: "Nominated by the division CO and approved by clan leadership to assist in leading a division. XOs support the CO in all aspects of division leadership and take command in the CO's absence.",
    },
];

function RankRow({ rank, delay }: { rank: Rank; delay: number }) {
    return (
        <li className="next-ladder-row" style={{ '--rank-color': rank.color } as CSSProperties}>
            <span className="next-ladder-track" aria-hidden="true">
                <span className="next-ladder-node" />
            </span>
            <Reveal delay={delay}>
                <article className="next-panel p-5 sm:p-6">
                    <div className="flex flex-wrap items-center gap-3">
                        <span className="next-rank">{rank.abbr}</span>
                        <h3 className="next-heading text-2xl font-bold uppercase tracking-wide text-foreground">{rank.name}</h3>
                        {rank.divisionOptional && <span className="font-mono text-[11px] uppercase tracking-widest text-muted-foreground">Division optional</span>}
                    </div>
                    <p className="mt-3 text-sm leading-relaxed text-muted-foreground sm:text-base">{rank.duties}</p>
                </article>
            </Reveal>
        </li>
    );
}

export default function Ranks({ foundedYear, currentYear }: RanksProps) {
    const total = GROUPS.reduce((count, group) => count + group.ranks.length, 0);

    return (
        <NextLayout title="Ranking Structure | Prototype" foundedYear={foundedYear} currentYear={currentYear}>
            <PageHero eyebrow="Ranking structure" title="Earned, not given">
                <p>
                    Rank in AOD comes from tenure and service, not a title handed out for authority. {total} ranks form one continuous line, from a recruit's first day to the
                    leadership of the clan.
                </p>
            </PageHero>

            <section className="border-t border-border px-4 py-20 sm:px-6">
                <div className="mx-auto grid max-w-6xl gap-12 lg:grid-cols-[1fr_20rem]">
                    <ol className="next-ladder" aria-label="AOD ranks, highest first">
                        {GROUPS.map((group) => (
                            <li key={group.label}>
                                <div className="next-ladder-row next-ladder-group">
                                    <span className="next-ladder-track" aria-hidden="true">
                                        <span className="next-ladder-group-node" />
                                    </span>
                                    <div className="pb-4 pt-1">
                                        <h2 className="next-heading text-3xl font-bold uppercase tracking-wide text-foreground">{group.label}</h2>
                                        <p className="font-mono text-xs uppercase tracking-widest text-muted-foreground">{group.summary}</p>
                                    </div>
                                </div>
                                <ol>
                                    {group.ranks.map((rank, index) => (
                                        <RankRow key={rank.abbr} rank={rank} delay={Math.min(index, 4) * 60} />
                                    ))}
                                </ol>
                            </li>
                        ))}
                    </ol>

                    <aside className="space-y-4 lg:sticky lg:top-28 lg:self-start">
                        <p className="font-mono text-xs uppercase tracking-[0.3em] next-red-text">Division roles</p>
                        {ROLES.map((role) => (
                            <article key={role.abbr} className="next-panel p-5">
                                <div className="flex items-baseline gap-3">
                                    <span className="next-heading text-3xl font-bold text-primary">{role.abbr}</span>
                                    <h3 className="next-heading text-xl font-bold uppercase text-foreground">{role.label}</h3>
                                </div>
                                <p className="mt-2 text-sm leading-relaxed text-muted-foreground">{role.body}</p>
                                <p className="mt-3 font-mono text-xs uppercase tracking-widest text-muted-foreground">
                                    Minimum rank <span className="text-foreground">{role.minimum}</span>
                                </p>
                            </article>
                        ))}
                        <p className="text-sm leading-relaxed text-muted-foreground">
                            Division roles carry authority inside one division, are independent of rank, and need nomination and approval by clan leadership.
                        </p>
                        <div className="flex gap-3 border-l-2 border-primary bg-primary/5 p-4 text-sm leading-relaxed text-foreground/85">
                            <Info className="mt-0.5 size-4 shrink-0 text-primary" aria-hidden="true" />
                            <p>
                                Only Sergeants and above may issue promotions or demotions, and only for good service to AOD. CO and XO appointments and every Sergeant-level promotion
                                need approval from clan leadership.
                            </p>
                        </div>
                    </aside>
                </div>
            </section>

            <PageCta title="Every rank starts at Recruit" link={{ href: '/next/code-of-conduct', label: 'Read the code of conduct' }}>
                And every member, at every rank, holds to the same code.
            </PageCta>
        </NextLayout>
    );
}
