import { router, usePage } from "@inertiajs/vue3";
import { defineStore } from "pinia";
import Filters from "../Models/filters";
import { Ref, onMounted, ref } from "vue";
import { asyncComputed, useStorage } from "@vueuse/core";
import axios from "axios";
import route from "ziggy-js";
import { isArray } from "lodash";

export default interface CurrentFilteredModel<T, K> {
    data: T
    filters: K
}
export const useFiltersStore = defineStore('filters', () => {
    let currentModel = ref(({} as CurrentFilteredModel<any, any>) || null);


    function setModel<T, K>(model: CurrentFilteredModel<T, K>) {
        currentModel.value = model
    }

    async function getFilteredData(params) {
        setUrlHistory(params);
        axios.get(route('catalystExplorer.filterProposals'), { params })
            .then((res) => {
                currentModel.value.data = res.data
            })
    }


    function setUrlHistory(params) {
        console.log({ params });
        const searchParams = new URLSearchParams();

        for (const key in params) {
            const value = params[key];
            if (value == null || value == '') { continue };
            if (isArray(value) && value.length > 0) {
                for (const element of value) {
                    searchParams.append(`${key}[]`, element);
                }
                console.log({ url1: searchParams.toString() });
            } else if (!isArray(value)) {
                searchParams.append(key, value);
            }
        }

        
        let searchUrl = searchParams.toString();
        if (searchUrl.length) {
            history.pushState(null, null, `?${searchUrl}`);
        }


    }

    return {
        setModel,
        currentModel,
        getFilteredData
    }
});
