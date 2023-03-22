import BookmarkItem from "./bookmark-item";


export default interface BookmarkCollection {
    hash?: string;
    title: string;
    user_id:number;
    content?: string;
    color?: string;
    visibility?: string;
    status?: string;
    link?: string;
    items?: BookmarkItem[];
    items_count?: number;
    created_at: string;
}
