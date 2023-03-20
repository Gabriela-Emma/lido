import BookmarkItem from "./bookmark-item";


export default interface BookmarkCollection {
    id?: number;
    title: string;
    content?: string;
    color?: string;
    visibility?: string;
    status?: string;
    bookmarks?: BookmarkItem[];
    items_count?: number;
    created_at: string;
}
