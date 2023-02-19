import Proposal from "./proposal";

export default interface Assessment {
    id: number;
    title?: string;
    label: string;
    rationale: string;
    proposal: Proposal;
    rating: number;
    assessor: string;
}
