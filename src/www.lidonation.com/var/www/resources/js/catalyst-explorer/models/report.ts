import Proposal from "./proposal";

export default interface Report {
    slug: string;
    title: string;
    content: string;
    proposal: Proposal;
    project_status: string;
    completion_target: string;
    users: {
        name: string;
        profile_photo_url: string;
        media: {original_url: string}[]
    }[];
}
