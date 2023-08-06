import { defineStore } from "pinia";
import { computed, ref, Ref } from "vue";


export const usePlayStore = defineStore('play-store', () => {

    let playList = ref([]);

    function showSpinner(color: string,) {

    }

    function stopSpinner() {

    }

    return {

    }
});