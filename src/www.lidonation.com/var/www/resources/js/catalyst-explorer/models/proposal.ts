import Repo from "./repo";
import Fund from "./fund";
import Vote from "./vote";

export default interface Proposal {
    amount_received: number;
    amount_requested:number;
    ca_rating: number;
    currency: string;
    funding_status: string;
    fund_name?: string;
    id: number;
    ideascale_link: string;
    no_votes_count: number;
    problem: string;
    ratings_count: number;
    status: string;
    slug: string;
    solution: string;
    title: string;
    user_id: number;
    quickpitch?: string;
    website: string;
    yes_votes_count: number;
    vote: Vote;

    // relationships
    challenge?: Fund;
    fund?: Fund;
    meta_data?: {
        iog_hash?: string;
        quickpitch?: string;
    };
    repos: Repo[];
    users: {
        id: number;
        name: string;
        username: string;
        profile_photo_url: string;
        ideascale_id: number;
        media: {original_url: string}[]
    }[];
}
