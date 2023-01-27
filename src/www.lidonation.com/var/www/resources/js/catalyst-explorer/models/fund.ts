import Challenge from "./challenge";

export default interface Fund {
    id: number;
    title: string;
    proposals_count: string;
    amount: string;
    currency: string;
    challenges?: Challenge[];
}
