import { router, usePage } from "@inertiajs/vue3";
import { defineStore } from "pinia";
import Filters from "../Models/filters";
import { Ref, onMounted, ref } from "vue";
import { useStorage } from "@vueuse/core";

export default interface CurrentFilteredModel<T> {
    data: T[];
    filters: T[]
}

export const useFiltersStore = defineStore('filters', () => {
    let currentModel = ref(null);

    function setModel(model){
        currentModel.value = model as CurrentFilteredModel<typeof model.data>
    }



    return {
        setModel,
        currentModel,
    }
});
