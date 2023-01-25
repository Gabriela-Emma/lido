export default interface Proposal {
    slug: string;
    title: string;
    solution: string;
    problem: string;
    funding_status: string;
    amount_received: number;
    users: {
        name: string;
        profile_photo_url: string;
        media: {original_url: string}[]
    }[];
}
