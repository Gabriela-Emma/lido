import Challenge from "./challenge";

export default interface Fund {
    id: number;
    title: string;
    label: string;
    status: string;
    launch_date:string;
    proposals_count: string;
    parent_proposals: number;
    amount: number;
    currency: string;
    currency_symbol:string;
    link:string;
    gravatar:string;
    thumbnail_url:string;
    parent?: Fund;
    challenges?: Challenge[];
    slug: string;
    content: string;
    excerpt: string;
}
