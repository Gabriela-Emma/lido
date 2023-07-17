import BookmarkItem from "./bookmark-item";
import Fund from "./fund";

export interface DraftBallotRationale {
    'title': string;
    'content': string;
    'status': string;
}

export interface DraftBallotGroup<T> {
    id: number;
    title: string;
    excerpt: string;
    rationale: DraftBallotRationale;
    items: BookmarkItem<T>[];
}

export default interface DraftBallot<T> {
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

    groups?: DraftBallotGroup<T>[];
}
