export default interface User{
    name:string;
    link:string;
    profile_photo_url:string;
    proposals_count:number;
    media: {original_url: string}[]  
}