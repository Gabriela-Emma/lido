export default interface Proposal {
[x: string]: any;
    slug: string;
    title: string;
    solution: string;
    problem: string;
    funding_status: string;
    amount_received: number;
    no_votes_count: number;
    yes_votes_count: number;
    ideascale_link: string;
    ca_rating: number;
    ratings_count: number;
    website: string;
    users: {
        name: string;
        username: string;
        profile_photo_url: string;
        media: {original_url: string}[]
    }[];
}
