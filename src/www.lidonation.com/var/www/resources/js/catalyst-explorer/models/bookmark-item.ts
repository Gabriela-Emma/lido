import BookmarkCollection from "./bookmark-collection";

export default interface BookmarkItem<T> {
    id?: number;
    collection_id?: number;
    model_id: number;
    model_type?: string;
    title: string;
    content?: string;
    link?: string;
    created_at: string;
    collection: BookmarkCollection<T>;
    model: T;
}
