import { DiscordIcon } from '@/components/icons/discord-icon';
import { SteamIcon } from '@/components/icons/steam-icon';
import { TwitchIcon } from '@/components/icons/twitch-icon';
import { XIcon } from '@/components/icons/x-icon';
import { YoutubeIcon } from '@/components/icons/youtube-icon';
import { useOpenApplyDialog } from '@/components/site/apply-dialog';

const sitemapLinks = [
    { label: 'Home', href: '/' },
    { label: 'Forums', href: '/forums' },
    { label: 'Divisions', href: '/divisions' },
    { label: 'History', href: '/history' },
    { label: 'Fallen Angels', href: '/fallen-angels' },
];

const socialLinks = [
    { name: 'Discord', href: 'https://discord.gg/clanaod', Icon: DiscordIcon, hoverClass: 'hover:border-[#5865F2]/50 hover:text-[#5865F2]' },
    { name: 'Twitch', href: 'https://www.twitch.tv/clanaodstream', Icon: TwitchIcon, hoverClass: 'hover:border-[#9146FF]/50 hover:text-[#9146FF]' },
    { name: 'X', href: 'https://twitter.com/officialclanaod', Icon: XIcon, hoverClass: 'hover:border-[#1DA1F2]/40 hover:text-[#1DA1F2]' },
    { name: 'Steam', href: 'https://steamcommunity.com/groups/clanaod', Icon: SteamIcon, hoverClass: 'hover:border-[#00adee]/50 hover:text-[#00adee]' },
    { name: 'YouTube', href: 'https://www.youtube.com/ClanAODnet', Icon: YoutubeIcon, hoverClass: 'hover:border-[#FF0000]/50 hover:text-[#FF0000]' },
];

export function Footer() {
    const openApply = useOpenApplyDialog();

    return (
        <footer className="border-t border-border bg-[#1a2128] bg-[url('/images/footer-bg.jpg')] bg-top bg-no-repeat">
            <div className="mx-auto flex max-w-6xl flex-col gap-10 px-4 py-12 sm:flex-row sm:items-start sm:justify-center sm:gap-20">
                <div className="flex flex-col items-start gap-6 sm:flex-row sm:items-center">
                    <img src="/images/official-logo.png" alt="Angels of Death" className="h-16 w-auto shrink-0" />
                    <div>
                        <h2 className="text-lg font-semibold">About The Angels of Death</h2>
                        <p className="mt-2 max-w-sm text-sm text-muted-foreground">
                            The Angels of Death is a community of players founded in 1999 based on a core set of conduct that aims to promote decency
                            and provide a comfortable environment to play with thousands of other likeminded members.
                        </p>
                    </div>
                </div>

                <div className="shrink-0">
                    <h2 className="text-lg font-semibold">Site Map</h2>
                    <ul className="mt-2 space-y-1.5 text-sm">
                        {sitemapLinks.map((link) => (
                            <li key={link.href}>
                                <a href={link.href} className="text-muted-foreground transition-colors hover:text-foreground">
                                    {link.label}
                                </a>
                            </li>
                        ))}
                        <li>
                            <button onClick={openApply} className="text-primary transition-colors hover:text-primary/80">
                                Apply
                            </button>
                        </li>
                    </ul>

                    <div className="mt-5 flex gap-3">
                        {socialLinks.map(({ name, href, Icon, hoverClass }) => (
                            <a
                                key={name}
                                href={href}
                                target="_blank"
                                rel="noopener noreferrer"
                                title={name}
                                className={`flex size-9 items-center justify-center rounded-full border border-white/15 text-foreground/70 transition-colors ${hoverClass}`}
                            >
                                <Icon className="size-4" />
                            </a>
                        ))}
                    </div>
                </div>
            </div>

            <div className="border-t border-border px-4 py-6 text-center text-xs text-muted-foreground">
                <span>Copyright &copy; 1999 - {new Date().getFullYear()} Angels of Death. All rights reserved.</span>
                <span className="mx-2">-</span>
                <a href="/privacy-policy" className="hover:text-foreground">
                    Privacy Policy
                </a>
                <span className="mx-2">-</span>
                <a href="/terms-of-use" className="hover:text-foreground">
                    Terms of Use
                </a>
            </div>
        </footer>
    );
}
