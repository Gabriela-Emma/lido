import {defineStore} from "pinia";
import {ref} from "vue";
import Pagination from "../models/pagination";

export const proposalsStore = defineStore('proposals', () => {
    const pagination = ref({

    } as Pagination);
    const name = ref('Eduardo');
    const filters = ref('Eduardo');

    function search() {
        console.log(window.axios);
    }

    return {
        pagination,
        name,
        filters,
        search
    };
});
