import Proposal from "./proposal";
import PaginationLink from "./pagination-link";
export default interface Pagination {
    current_page: number,
    data: Proposal[],
    links: PaginationLink,
    prev_page_url: String,
    next_page_url: string,
    first_page_url: string,
    last_page_url: string,
    from: number,
    to: number,
    last_page: number,
    total: number,
    path: string,
    per_page: number,
}
