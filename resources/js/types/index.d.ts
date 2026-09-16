export interface Division {
    name: string;
    slug: string;
    icon: string;
}

export interface SharedPageProps {
    [key: string]: unknown;
    divisions: Division[];
}
