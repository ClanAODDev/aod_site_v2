import { DiscordIcon } from '@/components/icons/discord-icon';
import { SteamIcon } from '@/components/icons/steam-icon';
import { TwitchIcon } from '@/components/icons/twitch-icon';
import { XIcon } from '@/components/icons/x-icon';
import { YoutubeIcon } from '@/components/icons/youtube-icon';

const links = [
    { name: 'Discord', href: 'https://discord.gg/clanaod', Icon: DiscordIcon, hoverClass: 'hover:border-[#5865F2]/50 hover:bg-[#5865F2]/20 hover:text-[#5865F2]' },
    { name: 'Twitch', href: 'https://www.twitch.tv/clanaodstream', Icon: TwitchIcon, hoverClass: 'hover:border-[#9146FF]/50 hover:bg-[#9146FF]/20 hover:text-[#9146FF]' },
    { name: 'X', href: 'https://twitter.com/officialclanaod', Icon: XIcon, hoverClass: 'hover:border-[#1DA1F2]/40 hover:bg-[#1DA1F2]/15 hover:text-[#1DA1F2]' },
    { name: 'Steam', href: 'https://steamcommunity.com/groups/clanaod', Icon: SteamIcon, hoverClass: 'hover:border-[#00adee]/50 hover:bg-[#00adee]/20 hover:text-[#00adee]' },
    { name: 'YouTube', href: 'https://www.youtube.com/ClanAODnet', Icon: YoutubeIcon, hoverClass: 'hover:border-[#FF0000]/50 hover:bg-[#FF0000]/20 hover:text-[#FF0000]' },
];

export function SocialIcons() {
    return (
        <div className="mt-8 flex flex-wrap justify-center gap-6">
            {links.map(({ name, href, Icon, hoverClass }) => (
                <a
                    key={name}
                    href={href}
                    target="_blank"
                    rel="noopener noreferrer"
                    title={name}
                    className={`group flex min-w-[90px] flex-col items-center gap-2 rounded-xl border border-white/10 bg-white/5 p-5 text-foreground transition-all hover:-translate-y-1 ${hoverClass}`}
                >
                    <Icon className="size-10 transition-transform group-hover:scale-115" />
                    <span className="text-xs tracking-wide text-foreground/80 uppercase">{name}</span>
                </a>
            ))}
        </div>
    );
}
