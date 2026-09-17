import { Head } from '@inertiajs/react';
import { useRef, type ReactNode } from 'react';

import { AutoMenu } from '@/components/division/auto-menu';
import { ScreenshotGallery } from '@/components/division/screenshot-gallery';
import { ContinuousCarousel } from '@/components/home/continuous-carousel';
import { DiscordIcon } from '@/components/icons/discord-icon';
import { SteamIcon } from '@/components/icons/steam-icon';
import { TwitchIcon } from '@/components/icons/twitch-icon';
import { XIcon } from '@/components/icons/x-icon';
import { YoutubeIcon } from '@/components/icons/youtube-icon';
import { Prose } from '@/components/prose';
import { Reveal } from '@/components/reveal';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { SiteLayout } from '@/layouts/site-layout';

const TOKENS = ['background', 'card', 'popover', 'muted', 'secondary', 'accent', 'primary', 'destructive', 'success', 'warning', 'info'];

const MERCH_ITEMS = [
    { slug: 'a', name: 'Sample Hoodie' },
    { slug: 'b', name: 'Sample Mousepad' },
    { slug: 'c', name: 'Sample Jersey' },
    { slug: 'd', name: 'Sample Mug' },
];

const SCREENSHOTS = [
    { url: '/images/bf4.jpg', caption: 'Sample screenshot one' },
    { url: '/images/d2.jpg', caption: 'Sample screenshot two' },
];

const PROSE_SAMPLE = `
<h2>A sample heading</h2>
<p>This is what <code>Markdown::convertToHtml()</code> output looks like once run through <code>.prose-tron</code> - the same wrapper used for division <code>site_content</code> and the legal pages.</p>
<ul>
    <li>Supports lists</li>
    <li>And <a href="#">links</a></li>
</ul>
`;

function Section({ title, id, children }: { title: string; id?: string; children: ReactNode }) {
    return (
        <section id={id} className="space-y-4 border-t border-border py-10 first:border-t-0 first:pt-0">
            <h2 className="text-xs font-semibold tracking-[0.2em] text-primary uppercase">{title}</h2>
            {children}
        </section>
    );
}

export default function Gallery() {
    const autoMenuContentRef = useRef<HTMLDivElement>(null);

    return (
        <SiteLayout>
            <Head title="Pattern Library" />

            <div className="mx-auto max-w-4xl space-y-2 px-4 py-16">
                <h1 className="text-2xl font-bold">aod_site_v2 pattern library</h1>
                <p className="text-sm text-muted-foreground">
                    Dev-only reference for the components/tokens built during the React/Inertia revamp. Not linked from anywhere in the real
                    site nav.
                </p>

                <Section title="Color tokens" id="colors">
                    <div className="grid grid-cols-2 gap-3 sm:grid-cols-4">
                        {TOKENS.map((token) => (
                            <div key={token} className="overflow-hidden rounded-lg border border-border">
                                <div className="h-16" style={{ backgroundColor: `var(--${token})` }} />
                                <div className="px-2 py-1.5 text-xs text-muted-foreground">{token}</div>
                            </div>
                        ))}
                    </div>
                </Section>

                <Section title="Typography" id="typography">
                    <h1 className="text-3xl font-bold">Heading 1</h1>
                    <h2 className="text-2xl font-bold">Heading 2</h2>
                    <h3 className="text-lg font-semibold">Heading 3</h3>
                    <p className="text-foreground/85">
                        Body copy at the default size, used for section blurbs and paragraph content across the marketing pages.
                    </p>
                    <p className="text-sm text-muted-foreground">Muted/secondary text, used for captions and metadata.</p>
                </Section>

                <Section title="Buttons" id="buttons">
                    <div className="flex flex-wrap items-center gap-3">
                        <Button>Default</Button>
                        <Button variant="outline">Outline</Button>
                        <Button variant="secondary">Secondary</Button>
                        <Button variant="ghost">Ghost</Button>
                        <Button variant="destructive">Destructive</Button>
                        <Button size="sm">Small</Button>
                        <Button size="lg">Large</Button>
                    </div>
                </Section>

                <Section title="Dialog" id="dialog">
                    <Dialog>
                        <DialogTrigger asChild>
                            <Button variant="outline">Open a dialog</Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>Sample dialog</DialogTitle>
                                <DialogDescription>Used for the apply modal, screenshot lightbox, and hero intro video.</DialogDescription>
                            </DialogHeader>
                        </DialogContent>
                    </Dialog>
                </Section>

                <Section title="Social icons" id="icons">
                    <div className="flex flex-wrap gap-4">
                        {[DiscordIcon, TwitchIcon, XIcon, SteamIcon, YoutubeIcon].map((Icon, index) => (
                            <div key={index} className="flex size-12 items-center justify-center rounded-lg border border-border bg-white/5">
                                <Icon className="size-6" />
                            </div>
                        ))}
                    </div>
                </Section>

                <Section title="Reveal (scroll into view once)" id="reveal">
                    <p className="text-sm text-muted-foreground">Scroll this section out of view and back to see it replay isn&apos;t possible - it fires once.</p>
                    <div className="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <Reveal from="left">
                            <div className="rounded-lg border border-border bg-card p-4 text-sm">from=&quot;left&quot;</div>
                        </Reveal>
                        <Reveal from="bottom" delay={150}>
                            <div className="rounded-lg border border-border bg-card p-4 text-sm">from=&quot;bottom&quot; delay=150</div>
                        </Reveal>
                        <Reveal from="right" delay={300}>
                            <div className="rounded-lg border border-border bg-card p-4 text-sm">from=&quot;right&quot; delay=300</div>
                        </Reveal>
                    </div>
                </Section>

                <Section title="Continuous carousel" id="carousel">
                    <ContinuousCarousel
                        items={MERCH_ITEMS}
                        keyFor={(item) => item.slug}
                        speed={0.5}
                        gap={16}
                        renderItem={(item) => (
                            <div className="flex h-24 w-40 items-center justify-center rounded-lg border border-border bg-card text-sm">
                                {item.name}
                            </div>
                        )}
                    />
                </Section>

                <Section title="Screenshot gallery / lightbox" id="screenshot-gallery">
                    <ScreenshotGallery screenshots={SCREENSHOTS} />
                </Section>

                <Section title="AutoMenu (jump-nav built from headings)" id="auto-menu">
                    <AutoMenu containerRef={autoMenuContentRef} className="mb-4" />
                    <div ref={autoMenuContentRef} className="space-y-4 text-sm text-muted-foreground">
                        <h2 className="text-lg font-semibold text-foreground">First section</h2>
                        <p>Scanned from this container&apos;s rendered headings on mount.</p>
                        <h2 className="text-lg font-semibold text-foreground">Second section</h2>
                        <p>Ids are assigned automatically if a heading doesn&apos;t already have one.</p>
                    </div>
                </Section>

                <Section title="Prose (rendered markdown)" id="prose">
                    <Prose html={PROSE_SAMPLE} className="rounded-lg border border-border p-4" />
                </Section>
            </div>
        </SiteLayout>
    );
}
