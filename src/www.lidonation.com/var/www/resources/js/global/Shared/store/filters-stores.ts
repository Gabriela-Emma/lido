import { router, usePage } from "@inertiajs/vue3";
import { defineStore } from "pinia";
import Filters from "../Models/filters";
import { Ref, onMounted, ref } from "vue";
import { asyncComputed, useStorage } from "@vueuse/core";
import axios from "axios";
import route from "ziggy-js";

export default interface CurrentFilteredModel<T,K> {
    data: T
    filters: K
}
export const useFiltersStore = defineStore('filters', () => {
    let currentModel = ref(null);


    function setModel<T,K>(model: CurrentFilteredModel<T,K>) {
        currentModel.value = model
    }

    async function getFilteredData(params) {
        axios.get(route('filterProposals'),{params})
        .then((res) => {
            currentModel.value.data = res.data
        })
    }

    return {
        setModel,
        currentModel,
        getFilteredData
    }
});
