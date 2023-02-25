import Bookmark from "./bookmark";

export default interface BookmarkCollection {
    uuid: number;
    title: string;
    bookmarks: Bookmark[];
}
