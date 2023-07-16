import {defineStore} from "pinia";
import axios, {AxiosError} from "axios";
import {computed, onMounted, Ref, ref} from "vue";
import {useStorage} from '@vueuse/core';
import BookmarkCollection from "../models/bookmark-collection";
import {BookmarkItemModel} from "../models/bookmark-item-model";
import Proposal from "../models/proposal";

export const useBookmarksStore = defineStore('bookmarks', () => {
    let localCollections = useStorage('bookmark-collections', {}, localStorage, {mergeDefaults: true});
    let collections = ref<BookmarkCollection<Proposal>[]>([]);

    async function saveCollection(collection: BookmarkCollection<Proposal>) {
        localCollections.value = {
            ...localCollections.value,
            [collection.hash]: {
                hash: collection.hash,
                items: collection.items.map((item) => ({
                    id: item.id,
                    model: {id: item.model?.id}
                }))
            }
        };
        loadCollections().then();
    }

    async function deleteCollection(collectionHash: string) {
        delete localCollections.value[collectionHash];
        loadCollections().then();
    }

    async function deleteItem(itemId: number, collectionHash: string) {
       let collection = localCollections.value[collectionHash];
       collection.items = collection.items.filter((item) => item.id != itemId)
       localCollections.value = {
        ...localCollections.value,
        [collectionHash]: collection,
      };
        loadCollections().then();
    }


    async function loadCollections() {
        if (Object.entries(localCollections.value)?.length == 0) {
            return;
        }

        try {
            const response = await axios.get(`/catalyst-explorer/my/bookmarks`, {params: {hashes: Object.keys(localCollections.value)}});
            collections.value = response.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    let collectionsArray = computed<BookmarkCollection<Proposal>[]>(() => Object.values(collections.value))

    let bookmarkedModels = computed<BookmarkItemModel[]>(() => {
        const models = collectionsArray.value.flatMap((collection) => collection?.items?.map((item) => item?.model));
        return models.filter((model, index, self) => self.findIndex((m) => m.id === model.id) === index);
    });

    onMounted(loadCollections);

    return {
        loadCollections,
        saveCollection,
        deleteCollection,
        deleteItem,
        models: bookmarkedModels,
        collections$: collectionsArray,
    };
});
