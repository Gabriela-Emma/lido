import Fund from "./fund";

export default interface Challenge {
    id: number;
    fundId: number;
    title: string;
    proposals_count: string;
    amount: string;
    currency: string;
    fund?: Fund;
}
