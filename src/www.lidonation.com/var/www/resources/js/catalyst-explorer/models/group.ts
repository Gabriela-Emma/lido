import Profile from "./profile";

export default interface Group {
    [x: string]: any;
    id: number;
    slug: string;
    name: string;
    bio: string;
    created_at: Date;
    amount_awarded_ada: number;
    amount_awarded_usd: number;
    proposals_count: number;
    link: string;
    twitter: string;
    discord: string;
    website: string;
    github: string;
    logo: string;
    owner: Profile;
    gravatar: string
    thumbnail_url: string;

}
