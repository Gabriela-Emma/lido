import {defineStore} from "pinia";
import {computed, ref, Ref } from "vue";


export const useSpinnerStore = defineStore('spinner', () => {
    
    let show:Ref<boolean> = ref(false);
    let fillColor:Ref<string> = ref(null);

    function showSpinner(color:string,){
        show.value = true;
        fillColor.value = color;
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