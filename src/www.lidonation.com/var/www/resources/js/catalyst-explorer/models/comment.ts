import User from "./user";

export default interface Comment {
    id: number;
    text: string;
    created_at: number;
    commentator: User;
}
