import BookmarkCollection from "./bookmark-collection";
import {BookmarkItemModel} from "./bookmark-item-model";

export default interface BookmarkItem {
    id: number;
    collection_id: number;
    model_id: number;
    model_type: string;
    title: string;
    content?: string;
    link?: string;
    created_at: string;
    collection: BookmarkCollection;
    model: BookmarkItemModel;
}
