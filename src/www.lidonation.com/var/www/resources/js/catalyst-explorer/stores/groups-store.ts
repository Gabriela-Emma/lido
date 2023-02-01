import {defineStore} from "pinia";
import {AxiosError} from "axios";
import {Ref, ref} from "vue";
import Group from "../models/group";
import GroupFilters from "../models/group-filters";

export const useGroupsStore = defineStore('groups', () => {
    let filters: Ref<GroupFilters> = ref();
    let groups = ref<Group[]>([]);

    async function search(f: GroupFilters) {
        filters.value = f;
        try {
            const {data} = await window.axios.get(
                `/api/catalyst-explorer/groups`,
                {
                    params: {
                        search: filters.value.search
                    }
                }
            );
            groups.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }
    async function loadGroups(pp: number[]) {
        try {
            const {data} = await window.axios.get(
                `/api/catalyst-explorer/groups`,
                {
                    params: {
                        ids: pp.join(',')
                    }
                }
            );
            groups.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    return {
        search,
        loadGroups,
        filters,
        groups
    };
});
