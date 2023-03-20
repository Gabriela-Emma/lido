import {defineStore} from "pinia";
import {AxiosError} from "axios";
import {computed, onMounted, Ref, ref} from "vue";
import {useStorage} from '@vueuse/core';
import BookmarkCollection from "../models/bookmark-collection";
import User from "../models/user";

export const useBookmarksStore = defineStore('bookmarks', () => {
    let collections = useStorage('bookmark-collections', {}, localStorage, { mergeDefaults: true });

    async function saveCollection(collection: BookmarkCollection) {
        collections.value = {
            ...collections.value,
            [collection.id]: collection
        };
    }

    async function loadCollections(user?: User) {
        if (Object.entries(collections.value)?.length > 0) {
            return ;
        }

        try {
            if (user?.name) {
                // get authenticated user bookmark collections
            } else {

            }
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    let collectionsArray = computed(() => Object.values(collections.value))

    onMounted(loadCollections);

    return {
        loadCollections,
        saveCollection,
        collections$: collectionsArray,
    };
});
