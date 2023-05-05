import {defineStore} from "pinia";
import {ref} from "vue";
import LearnerData = App.DataTransferObjects.LearnerData
import { AxiosError } from "axios";

export const useLearnerDataStore = defineStore('learner-data', () => {
    let learnerData = ref<LearnerData>(null);

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
