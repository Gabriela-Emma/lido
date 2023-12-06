import {defineStore, storeToRefs} from "pinia";
import {AxiosError} from "axios";
import {Ref, onMounted, ref, watch} from "vue";
import Tag from "../models/tag";
import TagFilters from "../models/tag-filters";
import { useFiltersStore } from "@/global/stores/filters-stores";



export const useTagsStore = defineStore('tags', () => {
    let filters: Ref<TagFilters> = ref();
    let tags = ref<Tag[]>([]);
    const filterStore = useFiltersStore();
    const { currentModel } = storeToRefs(filterStore);

    async function search(f: TagFilters) {
        filters.value = f;
        try {
            const {data} = await window.axios.get(
                `/api/catalyst-explorer/tags`,
                {
                    params: {
                        search: filters.value
                    }
                }
            );
            tags.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }
    async function load(ts?: number[]) {
        try {
            const {data} = await window.axios.get(
                `/api/catalyst-explorer/tags`,
                {
                    params: {
                        ids: ts.join(',') 
                    }
                }
            );
            tags.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    // watch(currentModel.value.filters, () => {
    //     if (currentModel.value.filters.tags.length) {
    //         search(currentModel.value.filters);
    //     } 
    // });

    onMounted(
        () => load(currentModel.value.filters.tags ?? [])
        );

    return {
        search,
        load,
        filters,
        tags
    };
});
