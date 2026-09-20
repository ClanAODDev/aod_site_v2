import { Head } from '@inertiajs/react';

import { EraSection } from '@/components/history/era-section';
import { TimelineBlock, type TimelineEntry } from '@/components/history/timeline-block';
import { SiteLayout } from '@/layouts/site-layout';

interface Era {
    key: string;
    background: { type: 'video'; videoId: string } | { type: 'image'; src: string } | { type: 'none' };
    entries: TimelineEntry[];
}

interface HistoryProps {
    foundationsEraVideoId: string;
    modernEraVideoId: string;
}

export default function History({ foundationsEraVideoId, modernEraVideoId }: HistoryProps) {
    const eras: Era[] = [
        {
            key: 'foundations',
            background: { type: 'video', videoId: foundationsEraVideoId },
            entries: [
                {
                    title: 'The Early Years',
                    dateRange: '1999-2003',
                    description:
                        'In the beginning there was only Liquid_Smoke and Lividum. Thankfully they were good at making friends and motivating others leading to expansion across the following titles:',
                    tags: [
                        { label: 'SWAT 3' },
                        { label: 'Red Faction' },
                        { label: 'Medal of Honor: Allied Assault' },
                        { label: 'Jedi Knight' },
                        { label: 'Nascar 2003' },
                        { label: 'Star Wars: Galaxies' },
                        { label: 'PlanetSide' },
                        { label: 'Team Fortress Classic' },
                    ],
                },
                {
                    title: 'Taking Flight',
                    dateRange: '2004-2007',
                    description:
                        'These were the years where we learned to fly leveraging a people-focused culture supported by strong and reliable leadership.',
                    tags: [
                        { label: 'Counter Strike: Source' },
                        { label: 'Everquest 2' },
                        { label: 'Joint Operations Typhoon Rising' },
                        { label: 'World of Warcraft' },
                        { label: 'Age of Empires III' },
                        { label: 'Battlefront 2' },
                        { label: 'Call of Duty 2' },
                        { label: 'Day of Defeat: Source' },
                        { label: 'Guild Wars' },
                        { label: 'Battlefield 2' },
                        { label: 'Battlefield 2142' },
                        { label: 'Call of Duty 4: Modern Warfare' },
                        { label: 'Enemy Territory: Quake Wars' },
                        { label: 'Team Fortress 2' },
                        { label: 'WarRock' },
                    ],
                },
                {
                    title: 'Explosive Expansion',
                    dateRange: '2009-2012',
                    description:
                        "If there's one thing that will test a system, it's too much success. Transitioning from a medium sized group of hundreds of members to thousands across the globe came with challenges in addition to the exhilaration. The redundancies and safeguards instituted years prior paved the way out of our valley.",
                    tags: [
                        { label: 'Darkfall' },
                        { label: 'Battlefield Bad Company 2' },
                        { label: 'EVE Online' },
                        { label: 'Global Agenda' },
                        { label: 'World of Tanks – World Champions', highlight: true },
                        { label: 'DC Universe' },
                        { label: 'Section 8 – Prejudice' },
                        { label: 'Star Wars The Old Republic' },
                        { label: 'Battlefield 3' },
                        { label: 'WarZ' },
                        { label: 'Guild Wars 2' },
                        { label: 'PlanetSide 2' },
                    ],
                },
            ],
        },
        {
            key: 'evolution',
            background: { type: 'image', src: '/images/bf4.jpg' },
            entries: [
                {
                    title: 'Finding Our Center',
                    dateRange: '2013-2014',
                    description:
                        'Success looks different now, more than a decade from our start. We number thousands full of passion for the chance to belong – and contribute to – something altogether remarkable.',
                    tags: [
                        { label: 'Archeage' },
                        { label: 'Defiance' },
                        { label: 'Mech Warrior Online' },
                        { label: 'Warframe' },
                        { label: 'War Thunder' },
                        { label: 'Battlefield 4' },
                        { label: 'Arma 3' },
                        { label: 'DayZ' },
                        { label: 'FireFall' },
                        { label: 'Ghost Recon: Phantoms' },
                        { label: 'The Repopulation' },
                    ],
                },
                {
                    title: 'Grounding Vision',
                    dateRange: '2015-2017',
                    description:
                        'Coming up on 20 years, the world of gaming and gaming communities has changed. New games come with new challenges. Navigating this new universe requires foundational improvements, strong leadership, and new tools. Adaptation is the pillar of survival.',
                    tags: [
                        { label: 'Armored Warfare' },
                        { label: 'ARK: Survival Evolved' },
                        { label: 'H1Z1' },
                        { label: 'Project Cars' },
                        { label: 'Skyforge' },
                        { label: 'Star Wars: Battlefront' },
                        { label: 'Rainbow Six Siege' },
                        { label: 'Ghost Recon: Wildlands' },
                        { label: 'Black Desert Online' },
                        { label: 'Overwatch' },
                        { label: "Tom Clancy's The Division" },
                        { label: 'Warhammer 40K: Eternal Crusade' },
                        { label: 'Titanfall 2' },
                        { label: 'Battlefield 1' },
                        { label: "PlayerUnknown's Battlegrounds" },
                        { label: 'Mass Effect: Andromeda' },
                        { label: 'Elite: Dangerous' },
                    ],
                },
            ],
        },
        {
            key: 'brave',
            background: { type: 'image', src: '/images/d2.jpg' },
            entries: [
                {
                    title: 'A Brave New World',
                    dateRange: '2018-2020',
                    description: 'We continue to scale sensibly, piloting ever-forward. Our future, much like our history, is ours to create.',
                    tags: [
                        { label: 'Anthem' },
                        { label: 'Apex Legends' },
                        { label: 'Battlefield V' },
                        { label: 'Battlefront II' },
                        { label: 'Call of Duty: Modern Warfare' },
                        { label: 'Ghost Recon: Breakpoint' },
                        { label: 'Destiny 2' },
                        { label: 'World of Warships' },
                        { label: 'World of Warcraft Classic' },
                        { label: 'Sea of Thieves' },
                        { label: 'The Division 2' },
                        { label: 'iRacing' },
                        { label: 'Fortnite' },
                        { label: 'Bless Online' },
                        { label: 'Escape From Tarkov' },
                        { label: 'Fallout 76' },
                        { label: 'Hearts of Iron IV' },
                    ],
                },
            ],
        },
        {
            key: 'modern',
            background: { type: 'video', videoId: modernEraVideoId },
            entries: [
                {
                    title: 'Modern Era',
                    dateRange: '2021-Present',
                    description:
                        'Into our third decade, we continue to evolve and adapt. New generations of gamers join our ranks as we expand into emerging titles while maintaining our core values of community, leadership, and excellence.',
                    tags: [
                        { label: 'Hell Let Loose' },
                        { label: 'Halo Infinite' },
                        { label: 'Squad' },
                        { label: 'Valorant' },
                        { label: 'Star Wars: Squadrons' },
                        { label: 'Conan Exiles' },
                        { label: 'New World' },
                        { label: 'Final Fantasy XIV' },
                        { label: 'Lost Ark' },
                        { label: 'Diablo IV' },
                        { label: 'BattleBit Remastered' },
                        { label: 'Skull and Bones' },
                        { label: 'Helldivers 2' },
                        { label: 'XDefiant' },
                        { label: 'Once Human' },
                        { label: "Bluntz' Reserves" },
                        { label: 'Throne and Liberty' },
                        { label: 'Delta Force' },
                        { label: 'DUNE: Awakening' },
                        { label: 'Marvel Rivals' },
                        { label: 'ARC Raiders' },
                        { label: 'Wardogs' },
                    ],
                },
            ],
        },
    ];

    return (
        <SiteLayout>
            <Head title="History of AOD" />

            {eras.map((era) => (
                <EraSection key={era.key} background={era.background}>
                    {era.entries.map((entry) => (
                        <TimelineBlock key={entry.title} {...entry} />
                    ))}
                </EraSection>
            ))}
        </SiteLayout>
    );
}
