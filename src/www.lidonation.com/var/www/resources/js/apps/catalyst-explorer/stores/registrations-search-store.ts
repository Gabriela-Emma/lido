import {defineStore} from "pinia";
import { ref } from "vue";

export const useRegistrationsSearchStore = defineStore('registrations-search', () => {
    let search = ref('');

    function setSearchValue(searchTerm: string){
        search.value = searchTerm;
    }

    return{
        search,
        setSearchValue
    }
})