import Repo from "./repo";
import Fund from "./fund";

export default interface Proposal {
    id: number;
    slug: string;
    title: string;
    solution: string;
    problem: string;
    user_id: number;
    funding_status: string;
    amount_received: number;
    amount_requested:number;
    currency_symbol: string;
    no_votes_count: number;
    yes_votes_count: number;
    ideascale_link: string;
    ca_rating: number;
    ratings_count: number;
    website: string;
    repos: Repo[];
    fund?: Fund;
    fund_name?: string;
    challenge_name?: string;
    meta_data?: {
        iog_hash: string;
    };
    users: {
        id: number;
        name: string;
        username: string;
        profile_photo_url: string;
        media: {original_url: string}[]
    }[];
}
