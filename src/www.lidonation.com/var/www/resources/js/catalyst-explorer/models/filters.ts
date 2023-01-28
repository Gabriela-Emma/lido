import Fund from "./fund";
import Tag from "./tag";

export default interface Filters {
    funded: boolean;
    fundingStatus: string;
    funds?: number[];
    challenges?: Fund[];
    tags?: number[];
}
