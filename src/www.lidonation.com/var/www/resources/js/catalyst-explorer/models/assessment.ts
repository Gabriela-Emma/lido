import Proposal from "./proposal";

export default interface Assessment {
    id: number;
    title: string;
    rationale: string;
    proposal: Proposal;
    rating: string;
}
