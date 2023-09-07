import BookmarkItem from "./bookmark-item";
import Fund from "./fund";

export default interface BookmarkCollection<T> {
    hash?: string;
    title: string;
    fund: Fund;
    user_id:number;
    content?: string;
    color?: string;
    visibility?: string;
    status?: string;
    link?: string;
    items?: BookmarkItem<T>[];
    items_count?: number;
    created_at: string;
}
