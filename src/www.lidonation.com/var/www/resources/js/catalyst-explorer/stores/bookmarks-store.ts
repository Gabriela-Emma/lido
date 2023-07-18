import {defineStore} from "pinia";
import axios, {AxiosError} from "axios";
import {computed, onMounted, Ref, ref} from "vue";
import BookmarkCollection from "../models/bookmark-collection";
import {BookmarkItemModel} from "../models/bookmark-item-model";
import Proposal from "../models/proposal";
import DraftBallot from "../models/draft-ballot";
import { cloneDeep } from "lodash";
import route from "ziggy-js";

export const useBookmarksStore = defineStore('bookmarks', () => {
    let collections = ref<BookmarkCollection<Proposal>[]>([]);
    let draftBallot = ref<DraftBallot<Proposal>>(null);
    let draftBallots = ref<DraftBallot<Proposal>[]>([]);

    async function saveCollection(collection: BookmarkCollection<Proposal>) {
        const collections = {
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
        loadCollections().then();
    }

    async function deleteItem(itemId: number, collectionHash: string) {
        loadCollections().then();
    }

    async function loadDraftBallots() {
        try {
            const response = await axios.get(route('catalystExplorerApi.draftBallots'));
            draftBallots.value = response?.data?.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    async function loadDraftBallot(ballot?: DraftBallot<Proposal>) {
        //@todo if no ballot provided load from server based on url
        if (ballot) {
            draftBallot.value = cloneDeep(ballot);
            return;
        }

        const segments = (window.location.href).split('/');
        const hash = segments[segments.indexOf('draft-ballots') + 1] || null;
        if (hash) {
            try {
                const response = await axios.get(route('catalystExplorerApi.draftBallot', {draftBallot: hash}));
                draftBallot.value = response.data;
            } catch (e: AxiosError | any) {
                console.log({e});
            }
        }
    }

    async function loadCollections() {
        try {
            const response = await axios.get(route('catalystExplorer.myBookmarks'));
            collections.value = [...response.data];
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    async function bookmarkProposal(proposal: Proposal) {
        try {
            const item = {
                model_id: proposal?.id,
                model_type: 'proposals',
                collection: {hash: draftBallot.value?.hash},
            };

            const res = await axios.post(route('catalystExplorer.bookmarkItem.create'), item);
            if (res.status == 200) {
                loadDraftBallot().then();
            }

        } catch (e) {
            console.log(e);
        }
    }

    let collectionsArray = computed<BookmarkCollection<Proposal>[]>(() => Object.values(collections.value))

    let bookmarkedModels = computed<number[]>(() => {
        return [...collectionsArray.value.flatMap((collection) => collection?.items?.map((item) => item?.model_id))]
    });

    // let bookmarkedModels = computed<BookmarkItemModel[]>(() => {
        // return collectionsArray.value.flatMap((collection) => collection?.items?.map((item) => item?.model_id));
        // console.log({models});
        // return models.filter((model, index, self) => self.findIndex((m) => m.id === model.id) === index);
    // });

    // onMounted();

    return {
        bookmarkProposal,
        loadCollections,
        saveCollection,
        deleteCollection,
        loadDraftBallot,
        loadDraftBallots,
        draftBallots$: draftBallots,
        deleteItem,
        modelIds$: bookmarkedModels,
        collections$: collectionsArray,
        draftBallot$: draftBallot,
    };
});
