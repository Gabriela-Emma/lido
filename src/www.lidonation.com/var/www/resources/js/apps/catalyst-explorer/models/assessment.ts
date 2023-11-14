import Proposal from "./proposal";

export default interface Assessment {
    id: number;
    title?: string;
    label: string;
    rationale?: string;
    proposal: Proposal;
    rating: number;
    assessor: string;
    qa_excellent_count: number;
    qa_good_count: number;
    qa_filtered_out_count: number;
    flagged: boolean;
    meta_data: {
        assessor_id: string;
        assessor_level: string;
    }
}
