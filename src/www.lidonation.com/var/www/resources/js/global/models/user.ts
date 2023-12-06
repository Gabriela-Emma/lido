import Proposal from "@/apps/catalyst-explorer/models/proposal";

export default interface User{
    id:number;
    name:string;
    email:string;
    link:string;
    bio:string;
    twitter:string;
    linkedin:string;
    discord:string;
    telegram:string;
    profile_photo_url:string;
    proposals_count:number;
    own_proposals_count:number;
    co_proposals_count:number;
    media: {original_url: string}[],
    roles: string[],
    meta_data: {}
    proposals:Proposal[]
    
}
