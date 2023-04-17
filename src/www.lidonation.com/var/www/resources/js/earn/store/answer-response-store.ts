import {defineStore} from "pinia";
import axios, {AxiosError} from "axios";
import {onMounted, ref} from "vue";
import AnswerResponse from "../models/answer-response";

export const useAnswerResponseStore = defineStore('answer-response', () => {

    let answerResponseData = ref<AnswerResponse[]>([]);

    async function submitAnswer(baseUrl, form)
    {
        form.post(`${baseUrl}/earn/learn/answer-response/store/answer`);
    }

    async function loadAnswerResponses()
    {
        try {
            const response = await axios.get(`/earn/learn/answer-response/responses`);
            answerResponseData.value = response.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    onMounted(loadAnswerResponses);

    return {
        answerResponseData,
        submitAnswer,
    };
});
