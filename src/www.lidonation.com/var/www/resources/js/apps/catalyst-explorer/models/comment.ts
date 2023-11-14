import User from "../../global/Shared/Models/user";

export default interface Comment {
    id: number;
    text: string;
    created_at: number;
    commentator: User;
}
