import Challenge from "./challenge";

export default interface Fund {
    id: number;
    title: string;
    label: string;
    launch_date:string;
    proposals_count: string;
    amount: string;
    currency: string;
    currency_symbol:string;
    link:string;
    gravatar:string;
    thumbnail_url:string;
    challenges?: Challenge[];
}
