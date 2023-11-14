import {defineStore} from "pinia";
import {AxiosError} from "axios";
import {Ref, ref} from "vue";
import Tag from "../models/tag";
import TagFilters from "../models/tag-filters";

export const useTagsStore = defineStore('tags', () => {
    let filters: Ref<TagFilters> = ref();
    let tags = ref<Tag[]>([]);

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
    async function load(ts: number[]) {
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

    return {
        search,
        load,
        filters,
        tags
    };
});
