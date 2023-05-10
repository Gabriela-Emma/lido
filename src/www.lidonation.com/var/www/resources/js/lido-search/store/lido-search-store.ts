import { AxiosError } from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "../../lib/utils/axios";

export const useGlobalSearchStore = defineStore("global-search", () => {
  let results = ref(null);
  let noResults = ref(false);
  let working = ref(false);
  let open = ref(true);

  async function search(term) {
    try {
      working.value = true;
      const response = await axios.get("/search", { params: { q: term } });
      results.value = response?.data;
      if (!results.value.length) {
        noResults.value = true;
        results.value  = null;
      } else {
        noResults.value = false;
      }
      working.value = false;
      const url = new URL(window.location.href);
      url.searchParams.set("q", term);
      history.pushState(null, null, url.toString());
    } catch (e) {
      console.log({ e });
    }
  }

  function closeSearch() {
    results.value = null;
    noResults.value = false;
  }

  return {
    results,
    search,
    noResults,
    closeSearch,
    working,
    open,
  };
});
