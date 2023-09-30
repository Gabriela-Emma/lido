import { router, usePage } from "@inertiajs/vue3";
import { defineStore } from "pinia";
import Filters from "../Models/filters";
import { Ref, onMounted, ref, watch } from "vue";
import { asyncComputed, useStorage } from "@vueuse/core";
import axios from "axios";
import route from "ziggy-js";
import { isArray } from "lodash";
import { VARIABLES } from "../../../catalyst-explorer/models/variables";
import { Nullable } from "primevue/ts-helpers";

interface CurrentFilteredModel<T = Nullable, K = Nullable, S = Nullable, ST = Nullable> {
    data?: T
    filters?: K
    search?:S
    sorts?:ST
}
export const useFiltersStore = defineStore('filters', () => {
    let currentModel = ref(({} as CurrentFilteredModel<any, any, any, any>) || null);
    let params = ref(null);

    function setModel<T, K, S, ST>(model: CurrentFilteredModel<T, K, S, ST>) {
        currentModel.value = model
    }

    async function getFilteredData() {
        setParams();
        setUrlHistory(params.value);
        axios.get(route('catalystExplorer.filterProposals'), { params: params.value })
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
            } else if (!isArray(value)) {
                searchParams.append(key, value);
            }
        }

        
        let searchUrl = searchParams.toString();
        if (searchUrl.length) {
            history.pushState(null, null, `?${searchUrl}`);
        }


    }

    function setParams() {
        const data = {};
        if (currentModel.value.filters.currentPage) {
            data[VARIABLES.PAGE] = currentModel.value.filters.currentPage;
        }
        if (currentModel.value.filters) {
            data[VARIABLES.PER_PAGE] = currentModel.value.filters;
        }

        if (currentModel.value.filters.funds) {
            data[VARIABLES.FUNDS] = Array.from(currentModel.value.filters.funds);
        }

        if (currentModel.value.filters.challenges) {
            data[VARIABLES.CHALLENGES] = Array.from(currentModel.value.filters?.challenges);
        }

        if (currentModel.value.filters.cohort) {
            data[VARIABLES.COHORT] = currentModel.value.filters.cohort;
        }

        if (currentModel.value.filters.fundingStatus) {
            data[VARIABLES.FUNDING_STATUS] = currentModel.value.filters?.fundingStatus;
        }

        if (currentModel.value.filters.projectStatus) {
            data[VARIABLES.STATUS] = currentModel.value.filters.projectStatus;
        }

        if (currentModel.value.filters.type) {
            data[VARIABLES.TYPE] = currentModel.value.filters.type;
        }

        if (currentModel.value.filters.tags) {
            data[VARIABLES.TAGS] = Array.from(currentModel.value.filters.tags);
        }

        if (currentModel.value.filters.people) {
            data[VARIABLES.PEOPLE] = Array.from(currentModel.value.filters.people);
        }

        if (currentModel.value.filters.groups) {
            data[VARIABLES.GROUPS] = Array.from(currentModel.value.filters.groups);
        }

        // TODO IMPLEMENT SEARCH 
        // if (search.value?.length > 0) {
        //     data[VARIABLES.SEARCH] = search.value;
        // }

        // TODO implement sorts
        // if (!!currentModel.value.sorts.value && currentModel.value.sorts.value.length > 3) {
        //     data[VARIABLES.SORTS] = currentModel.value.sorts.value;
        // }

        // TODO Range picker
        // if (!!filtersRef.value.budgets) {
        //     if (filtersRef.value.budgets[0] > VARIABLES.MIN_BUDGET || filtersRef.value.budgets[1] < VARIABLES.MAX_BUDGET) {
        //         data[VARIABLES.BUDGETS] = filtersRef.value.budgets;
        //     }
        // }

        // TODO toggle component
        // if (currentModel.value.filters) {
        //     data[VARIABLES.FUNDED_PROPOSALS] = 1;
        // }

        // if (currentModel.value.filters) {
        //     data[VARIABLES.OPENSOURCE_PROPOSALS] = 1;
        // }

        params.value =  data;
    }


    // watch(()=>currentModel,() => {
    //     getFilteredData(); 
    // });

    return {
        setModel,
        currentModel,
        getFilteredData
    }
});
