import {defineStore} from "pinia";
import {Ref, ref} from "vue";
import LearnerData = App.DataTransferObjects.LearnerData
import { AxiosError } from "axios";
import {useStorage} from "@vueuse/core";

export const useLearnerDataStore = defineStore('learner-data', () => {
    // let learnerData = ref<LearnerData>(null);
    let learnerData: Ref<LearnerData> = useStorage<LearnerData>('earn-user-data', {} as LearnerData, localStorage, {mergeDefaults: true});

    async function getLearnerData() {
        try {
            await window.axios.get(
                `/api/earn/learn/learner-data`,
            ).then((res) => {
                learnerData.value = res?.data
            });
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    return{
        learnerData,
        getLearnerData
    }
});
