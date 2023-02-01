import Fund from "./fund";

export default interface Filters {
    funded: boolean;
    fundingStatus: string;
    projectStatus: string;
    cohort: string;
    type?: string;
    funds?: number[];
    challenges?: Fund[];
    tags?: number[];
    people?: number[];
    groups?: number[];
    sort?: number[];
    budgets?: number[];
}
