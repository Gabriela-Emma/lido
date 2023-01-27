import Fund from "./fund";

export default interface Filters {
    funded: boolean;
    funds?: Fund[];
}
