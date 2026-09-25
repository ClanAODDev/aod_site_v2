import { Head, usePage } from '@inertiajs/react';

import { Hero } from '@/components/home/hero';
import { HighlightedEvent } from '@/components/home/highlighted-event';
import { MerchSection } from '@/components/home/merch-section';
import { SocialIcons } from '@/components/home/social-icons';
import { TwitchLive } from '@/components/home/twitch-live';
import { TwitchVods } from '@/components/home/twitch-vods';
import { HudCorners } from '@/components/hud-corners';
import { Reveal } from '@/components/reveal';
import { SectionTitle } from '@/components/section-title';
import { useOpenApplyDialog } from '@/components/site/apply-dialog';
import { Nav } from '@/components/site/nav';
import { SiteLayout } from '@/layouts/site-layout';
import type { SharedPageProps } from '@/types';

interface DiscordStats {
    online: number;
    idle: number;
    dnd: number;
    total: number;
}

interface TwitchStats {
    is_live: boolean;
    channel: string;
    stream: { title?: string; game_name?: string } | null;
    vods: { url: string; title: string; thumbnail_url: string; duration: string; view_count: number }[];
}

interface HighlightedEventData {
    theme: 'holiday' | 'esports' | 'community' | 'default';
    show_snowflakes?: boolean;
    badge?: { icon?: string; text: string };
    title: string;
    description?: string;
    video?: { type: 'youtube' | 'twitch'; id: string; title?: string };
    cta?: { text: string; url: string; icon?: string };
}

interface MerchItem {
    name: string;
    slug: string;
    image_id: string;
}

interface HomeProps {
    discord: DiscordStats | null;
    twitch: TwitchStats;
    highlightedEvent: HighlightedEventData | null;
    showTwitchLive: boolean;
    showHighlightedEvent: boolean;
    showVods: boolean;
    heroVideoId: string;
    introVideoId: string;
    merch: {
        store_url: string;
        image_base_url: string;
        image_suffix: string;
        items: MerchItem[];
    };
}

export default function Home({ discord, twitch, highlightedEvent, showTwitchLive, showHighlightedEvent, showVods, heroVideoId, introVideoId, merch }: HomeProps) {
    const { divisions } = usePage<SharedPageProps>().props;
    const onlineCount = discord ? discord.online + discord.idle + discord.dnd : null;
    const isChristmas = highlightedEvent?.theme === 'holiday';

    return (
        <SiteLayout heroNav>
            <Head title="Angels of Death Gaming Clan | Since 1999" />

            <Hero
                videoId={heroVideoId}
                introVideoId={introVideoId}
                discordOnline={onlineCount ?? undefined}
                discordTotal={discord?.total}
                isChristmas={isChristmas}
            />

            <div className="pointer-events-none h-[55vh]" />

            <Nav startsUnstuck />

            {showTwitchLive && twitch.stream && <TwitchLive channel={twitch.channel} title={twitch.stream.title} gameName={twitch.stream.game_name} />}
            {showHighlightedEvent && highlightedEvent && <HighlightedEvent event={highlightedEvent} />}
            {showVods && twitch.vods.length > 0 && <TwitchVods vods={twitch.vods} channel={twitch.channel} divisions={divisions} />}

            <section className="relative bg-[#0b0f12] bg-[url('/images/supported-games-bg.jpg')] bg-top bg-no-repeat px-4 py-20 text-center after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-20 after:bg-gradient-to-b after:from-transparent after:to-[#090a10]">
                <Reveal from="right">
                    <SectionTitle>
                        Engaged in <strong className="font-semibold text-primary">{divisions.length}</strong> major titles
                    </SectionTitle>
                </Reveal>
                <Reveal from="left" delay={150} className="mx-auto mt-5 max-w-2xl">
                    <p className="text-foreground/75">
                        From first-person shooters and survival games to the most well known massive-multiplayer games, you&apos;ll always have
                        something to play. And there&apos;s no shortage of AOD members playing around the clock from Brisbane, Australia and
                        Osaka, Japan crossing the likes of Norway, France, and Brazil, and dominating the time zones of North and South America.
                    </p>
                </Reveal>
                <Reveal from="bottom" delay={300} className="mx-auto mt-10 flex max-w-4xl flex-wrap justify-center gap-3">
                    {divisions.map((division) => (
                        <a
                            key={division.slug}
                            href={division.href}
                            title={division.name}
                            className="group relative flex w-28 flex-col items-center bg-white/5 p-4 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] backdrop-blur-md backdrop-saturate-150 transition-all hover:-translate-y-1 hover:bg-white/10"
                        >
                            <HudCorners className="border-border-strong/60 transition-colors group-hover:border-primary" />
                            <img
                                src={division.icon}
                                alt={division.name}
                                className="size-12 object-contain opacity-70 transition-all group-hover:scale-110 group-hover:opacity-100 group-hover:drop-shadow-[0_0_8px_var(--primary-glow)]"
                            />
                            <span className="mt-2 flex min-h-8 items-center text-center text-[11px] tracking-wide text-foreground/80 uppercase">
                                {division.name}
                            </span>
                            {division.members_count > 0 && (
                                <span className="mt-1 font-mono text-[10px] text-foreground/50">{division.members_count.toLocaleString()} members</span>
                            )}
                        </a>
                    ))}
                </Reveal>
            </section>

            <section className="founded-section overflow-hidden bg-[#3a0707] px-4 py-20 md:overflow-visible">
                <div className="relative mx-auto max-w-5xl">
                    <Reveal from="left" className="md:max-w-md">
                        <SectionTitle className="text-left">
                            Founded in <strong className="font-semibold text-primary">1999</strong>
                            <br />
                            and still growing!
                        </SectionTitle>
                        <p className="mt-5 text-foreground/85">
                            The Angels of Death is a time-tested organization, supporting over 56 major gaming titles in the past 25 years
                            including classics like Medal of Honor: Allied Assault, and Swat 3.
                        </p>
                        <p className="mt-4 text-foreground/85">
                            We&apos;ve lasted this long because of the tireless efforts of people who love gaming, and our community is as
                            diverse as the games we play. AOD is truly a family, and we&apos;ve never stopped growing.
                        </p>
                        <a href="/history" className="mt-4 inline-block text-primary underline underline-offset-2 hover:text-primary/80">
                            Read the history of AOD
                        </a>
                    </Reveal>
                    <Reveal from="right" delay={150} className="mt-10 md:hidden">
                        <img src="/images/dude.png" alt="" className="mx-auto w-full max-w-md drop-shadow-[0_10px_30px_rgba(0,0,0,0.8)]" />
                    </Reveal>
                    <img
                        src="/images/dude.png"
                        alt=""
                        className="pointer-events-none absolute -top-24 -right-4 hidden w-[420px] drop-shadow-[0_10px_30px_rgba(0,0,0,0.8)] md:block lg:-top-[130px] lg:-right-10 lg:w-[600px]"
                    />
                </div>
            </section>

            <section className="bg-[#050505] bg-[url('/images/belong-section-bg.jpg')] bg-top bg-no-repeat px-4 py-20 text-center">
                <Reveal from="left">
                    <SectionTitle>
                        Belong to something <strong className="font-semibold text-primary">unique</strong> and
                        <br />
                        worldwide that <strong className="font-semibold text-primary">endures</strong> through time
                    </SectionTitle>
                </Reveal>
                <Reveal from="right" delay={150} className="mx-auto mt-5 max-w-2xl space-y-4 text-foreground/85">
                    <p>
                        Maniacal adolescent leaders with cosmic delusional powers, leaders that suddenly vanish, councils that focus more on forum
                        flair than decisions. Like you, we&apos;ve experienced them all and learned a lot in the process.
                    </p>
                    <p>
                        We made sure AOD was different. We intentionally cultivated a community focused on less drama, and more gaming. Here your
                        relationships and investments in the community continue beyond a single game.
                    </p>
                    <p>At AOD, your legacy can last for years.</p>
                </Reveal>
            </section>

            <section className="bg-[#030911] bg-[url('/images/social-media-bg.jpg')] bg-top bg-no-repeat px-4 py-20 text-center">
                <Reveal from="left">
                    <SectionTitle>Catch up with us on social media</SectionTitle>
                </Reveal>
                <Reveal from="right" delay={150} className="mx-auto mt-5 max-w-2xl">
                    <p className="text-foreground/85">
                        Grab one of the hundreds of seats in our hosted VOIP amphitheater while working your WASD and, when you have to leave your
                        mechanical keys, keep up to date by following our social feeds.
                    </p>
                </Reveal>
                <Reveal from="bottom" delay={300}>
                    <SocialIcons />
                </Reveal>
            </section>

            <MerchSection
                items={merch.items}
                storeUrl={merch.store_url}
                imageBaseUrl={merch.image_base_url}
                imageSuffix={merch.image_suffix}
            />

            <section className="cta-hatch relative bg-[#030911] bg-[url('/images/apply-bg.jpg')] bg-top bg-no-repeat px-4 py-20 text-center">
                <div className="absolute inset-0 bg-gradient-to-br from-black/40 to-primary/20" />
                <div className="relative">
                    <SectionTitle>So what are you waiting for?</SectionTitle>
                    <p className="mx-auto mt-5 max-w-xl text-foreground/85 [text-shadow:0_0_2px_rgba(0,0,0,0.4)]">
                        Complete a clan application with one of our divisions to start the process and see if we&apos;re a good fit for each other.
                    </p>
                    <ApplyCta />
                </div>
            </section>
        </SiteLayout>
    );
}

function ApplyCta() {
    const openApply = useOpenApplyDialog();

    return (
        <button
            onClick={openApply}
            className="mt-6 inline-block rounded-md bg-primary px-8 py-3.5 text-sm font-medium tracking-widest text-primary-foreground uppercase transition-colors hover:bg-primary/90"
        >
            Apply to ClanAOD
        </button>
    );
}
