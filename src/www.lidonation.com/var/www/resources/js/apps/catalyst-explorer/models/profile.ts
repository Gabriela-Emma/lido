import Wallet from "./wallet";

export default interface Profile {
    id: number;
    username: string;
    name: string;
    bio?:string;
    email?:string;
    twitter?:string;
    linkedin?:string;
    discord?:string;
    telegram?:string;
    profile_photo:string
    profile_photo_url:string
    role?:string; 
    admin?:boolean;
    title?:string;
    wallets?:Wallet[];
    // proposers
    amount_requested?:string
}
