import BookmarkItem from "./bookmark-item";
import Fund from "./fund";


export default interface DraftBallot {
    hash?: string;
    title: string;
    user_id:number;
    content?: string;
    color?: string;
    visibility?: string;
    status?: string;
    link?: string;
    items_count?: number;
    created_at: string;

    groups?: {
        title: string,
        excerpt: string,
        items: BookmarkItem[]
    };
}
