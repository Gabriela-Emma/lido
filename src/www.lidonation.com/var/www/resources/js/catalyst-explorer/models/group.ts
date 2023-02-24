import Profile from "./profile";

export default interface Group {
    id: number;
    slug: string;
    name: string;
    bio: string;
    created_at:Date ;
    amount_awarded: number;
    proposals_count: number;
    link: string;
    twitter:string;
    discord:string;
    website: string;
    github: string;
    logo:string;
    owner: Profile
    new:boolean
}
