import { AxiosError } from "axios";
import {defineStore} from "pinia";
import {computed, ref, Ref } from "vue";


export const useGlobalSearchStore = defineStore('global-search', () => {
    
    let results= ref(null);
    let noResults =ref(false)

    async function search(term) {
        try {
            await window.axios.get(
                `/s`,
                {
                    params: {
                        q: term
                    }
                }
            ).then((res) => {
                results.value = res?.data;
                if(!results.value.length){
                    noResults.value = true;
                }else{
                    noResults.value = false;
                }
                
            });

        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    function clearSearch(){
         results= ref(null);
         noResults =ref(false)
    }



    return {
        results,
        search,
        noResults,
        clearSearch 
    }
});