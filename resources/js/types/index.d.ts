export interface Division {
    name: string;
    slug: string;
    icon: string;
    members_count: number;
    href: string;
}

export interface SharedPageProps {
    [key: string]: unknown;
    divisions: Division[];
}
