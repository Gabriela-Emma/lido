import {defineStore} from "pinia";
import {computed, ref, Ref } from "vue";


export const useSpinnerStore = defineStore('spinner', () => {
    
    let show:Ref<boolean> = ref(false);
    let fillColor:Ref<string> = ref(null);

    function showSpinner(fill_color:string,){
        show.value = true;
        fillColor.value = fill_color;
    }

    function stopSpinner(){
        show.value = false;
    }

    return {
        showSpinner,
        stopSpinner,
        show,
        fillColor
    }
});