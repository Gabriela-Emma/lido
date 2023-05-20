interface PaginationLink {
    url?: string;
    label: string;
    active: boolean;
}

interface PaginationMeta {
    current_page: number;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    next_page_url?: string;
    path: string;
    per_page: number;
    prev_page_url?: number;
    to: number;
    total: number;
}

export default interface PaginatedData<K>{
    data: K[],
    links: PaginationLink[],
    meta: PaginationMeta
}
