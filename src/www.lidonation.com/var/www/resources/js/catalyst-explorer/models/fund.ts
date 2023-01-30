import Challenge from "./challenge";

export default interface Fund {
    id: number;
    launch_date:Date;
    title: string;
    proposals_count: string;
    amount: string;
    currency: string;
    currency_symbol:string
    challenges?: Challenge[];
}
