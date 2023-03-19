import BookmarkItem from "./bookmark-item";


export default interface BookmarkCollection {
    id?: number;
    title: string;
    user_id:number;
    content?: string;
    color?: string;
    visibility?: string;
    status?: string;
    bookmarks?: BookmarkItem[];
    created_at: string;
}
