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
            setCounts();
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
            setCounts();
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    function setCounts() {
        let tagCounts = currentModel.value.props.filterCounts['tagsCount'];
        tags.value.map(tag => {
            const id = tag.id;

            if (tagCounts[id]) {
                tag['count'] = tagCounts[id];

            } else {
                tag['count'] = 0;
            }
            return tag;
        });
        
    }

    watch([() => currentModel.value], () => {
        setCounts();
    }, { immediate: true, deep: true });

    onMounted(
        () => load([])
        );

    return {
        search,
        load,
        filters,
        tags
    };
});
