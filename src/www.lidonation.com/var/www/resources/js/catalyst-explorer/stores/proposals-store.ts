import {defineStore} from "pinia";
import {computed, ref} from "vue";
import Pagination from "../models/pagination";

export const proposalsStore = defineStore('proposals', () => {
    const pagination = ref({

    } as Pagination);
    const name = ref('Eduardo');
    const filters = ref('Eduardo');
    // const doubleCount = computed(() => count.value * 2);

    function increment() {
        // count.value++
    }

    function search() {
        console.log(window.axios);
    }

    return {
        pagination,
        name,
        filters,
        // doubleCount,
        increment,
        search
    };
});
