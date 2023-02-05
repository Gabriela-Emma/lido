import {defineStore} from "pinia";
import {computed, Ref, ref} from "vue";
import Pagination from "../models/pagination";
import Filters from "../models/filters";

export const useProposalsStore = defineStore('proposals', () => {
    let pagination = ref<Pagination>();
    let filters = ref({} as Filters);

    const showPrevButton = computed(() => {
        return pagination.value.current_page > 1 ? true : false;
    })
    const showNextButton = computed(() => {
        return (pagination.value.current_page+1) < pagination.value.last_page ? true : false;
    })
    const prevPage = computed(():number => {
        if (showPrevButton) {
            return pagination.value.current_page - 1;
        }
    })
    const nextPage = computed(():number => {
        if (showPrevButton) {
            return pagination.value.current_page + 1;
        }
    })
    const pages = computed(() => {
        const pagesArray = Array.from({length: 5}, (v, k) => k+1); 
        return pagesArray;
    });
    // function showPrevButton(): boolean
    // {
    //     return pagination['current_page'] > 1 ? true : false;
    // }
    // function showNextButton(): boolean
    // {
    //     return (pagination['current_page']+1) < pagination['last_page'] ? true : false;
    // }

    // function setPagination(currentPage:number)
    // {
    //     if (currentPage == pagination['current_page']) {
    //         return pagination;
    //     }
    // }

    function loadProposals(paginated: Pagination):void
    {
        pagination.value = paginated;
        console.log(pagination.value);
    }

    function loadFilters(f: Filters)
    {
        filters.value = f;
        console.log(filters.value);
    }

    return {
        loadProposals,
        loadFilters,
        prevPage,
        nextPage,
        pagination,
        showPrevButton,
        showNextButton,
        pages,
        filters,
        // doubleCount,
    };
});
