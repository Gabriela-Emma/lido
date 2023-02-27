import {defineStore} from "pinia";
import {AxiosError} from "axios";
import {onMounted, Ref, ref} from "vue";
import {useLocalStorage, useStorage} from '@vueuse/core';
import BookmarkCollection from "../models/bookmark-collection";
import User from "../models/user";
import {RemovableRef} from "@vueuse/shared";

export const useBookmarksStore = defineStore('bookmarks', () => {
    let collections: Ref<BookmarkCollection[]> = ref([]);

    async function loadCollections(user?: User) {
        if (collections.value?.length > 0) {
            return ;
        }

        try {
            if (user?.name) {
                // get authenticated user bookmark collections

            } else {
                // get uuid from localStorage
                const state = <RemovableRef<{collection: string}>>useStorage(
                    'catalyst-explorer-bookmark-collection',
                    {collection: null},
                    localStorage,
                    {mergeDefaults: true}
                );
                console.log('state::', state.value?.collection);

                // fetch bookmarks from api
                if (state?.value.collection) {
                    // const {data} = await window.axios.get(
                    //     `/api/catalyst-explorer/bookmarks/${state.value?.collection}`,
                    //     {
                    //         params: {
                    //             // ids: ts.join(',')
                    //         }
                    //     }
                    // );
                    // collections.value = [data?.data];
                }
            }
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    onMounted(loadCollections);

    return {
        loadCollections,
        collections,
    };
});
