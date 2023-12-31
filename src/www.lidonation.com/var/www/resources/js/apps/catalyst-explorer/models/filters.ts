import Fund from "./fund";
import Proposal from "./proposal";

export default interface Filters {
    currentPage: number;
    funded: boolean;
    opensource: boolean;
    fundingStatus: string;
    projectStatus: string;
    cohort: string;
    type?: string;
    funds?: number[];
    challenges?: number[];
    proposals?: Proposal[];
    tags?: number[];
    people?: number[];
    groups?: number[];
    sort?: number[];
    budgets?: number[];
}
