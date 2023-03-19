import Proposal from "./proposal";
import Profile from "./profile";
import Group from "./group";
import BookmarkCollection from "./bookmark-collection";

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
    model: Proposal | Profile | Group;
}
