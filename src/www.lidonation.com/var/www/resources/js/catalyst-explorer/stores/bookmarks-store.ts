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
            [collection.hash]: collection
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

    let collectionsArray = computed<BookmarkCollection[]>(() => Object.values(collections.value))

    let bookmarkedModels = computed(() => {
        let models: Array<{}> = [];
        let modelIDs = new Set<number>();

        for (const collection of collectionsArray.value as Array<any>) {
            for (const item of collection.items) {
                if(!modelIDs.has(item.model.id)){
                    models.push(item.model);
                    modelIDs.add(item.model.id);
                }
            }
        }

        return models;

    });

    onMounted(loadCollections);

    return {
        loadCollections,
        saveCollection,
        models:bookmarkedModels,
        collections$: collectionsArray,
    };
});
