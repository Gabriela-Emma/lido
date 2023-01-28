export default interface Proposal {
    slug: string;
    title: string;
    solution: string;
    problem: string;
    funding_status: string;
    amount_received: number;
    no_votes_count: number;
    yes_votes_count: number;
    ideascale_link: string;
    website: string;
    users: {
        name: string;
        profile_photo_url: string;
        media: {original_url: string}[]
    }[];
}
