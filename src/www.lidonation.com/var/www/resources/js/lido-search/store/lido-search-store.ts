import { defineStore } from "pinia";
import { Ref, ref } from "vue";
import PostSearchResultsData = App.DataTransferObjects.PostSearchResultData;
import GlobalSearchHttpService from "../../global/Services/GlobalSearchHttpService";

export const useGlobalSearchStore = defineStore("global-search", () => {
    let results: Ref<PostSearchResultsData[]> = ref(null);
    let noResults: Ref<boolean> = ref(false);
    let working: Ref<boolean> = ref(false);

    async function search(term) {
        try {
            working.value = true;
            const url = new URL(window.location.href);
            url.searchParams.set("q", term);
            history.pushState(null, null, url.toString());
            const response = await GlobalSearchHttpService.search(term);
            results.value = response;
            if (!results.value.length) {
                noResults.value = true;
                results.value = null;
            } else {
                noResults.value = false;
            }
            working.value = false;
        } catch (e) {
            console.log({ e });
        }
    }

    function clearSearch() {
        results.value = null;
        noResults.value = false;
    }

    return {
        results,
        search,
        noResults,
        clearSearch,
        working,
    };
});
