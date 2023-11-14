import {defineStore} from "pinia";
import { ref, Ref } from "vue";


export const useSpinnerStore = defineStore('spinner', () => {
    
    let show:Ref<boolean> = ref(false);

    function showSpinner(){
        show.value = true;
    }

    function stopSpinner(){
        show.value = false;
    }

    return {
        showSpinner,
        stopSpinner,
        show,
    }
});