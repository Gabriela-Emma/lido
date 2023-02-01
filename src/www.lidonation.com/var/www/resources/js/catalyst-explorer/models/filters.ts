import Fund from "./fund";

export default interface Filters {
    funded: boolean;
    fundingStatus: string;
    funds?: number[];
    challenges?: Fund[];
    tags?: number[];
    people?: number[];
    sort?: number[];
    budgets?: number[];
}
