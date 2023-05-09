import { AxiosError } from "axios";
import {defineStore} from "pinia";
import {computed, ref, Ref } from "vue";


export const useGlobalSearchStore = defineStore('global-search', () => {
    
    let result:Ref<boolean> = ref(false);

    async function search(term) {
        try {
            const {data} = await window.axios.get(
                `/s`,
                {
                    params: {
                        q: term
                    }
                }
            );
            result.value = data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }



    return {
        result,
        search 
    }
});