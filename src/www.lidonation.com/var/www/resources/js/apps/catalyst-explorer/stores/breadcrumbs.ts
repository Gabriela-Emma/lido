import {defineStore} from "pinia";
import {computed, ref} from "vue";

export const breadcrumbStore = defineStore('breadcrumbs', () => {
    const count = ref(0);
    const name = ref('Eduardo');
    const filters = ref('Eduardo');
    const doubleCount = computed(() => count.value * 2);

    function increment() {
        count.value++
    }

    return {
        count,
        name,
        filters,
        doubleCount, increment
    };
});
