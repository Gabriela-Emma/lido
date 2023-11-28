import {defineStore} from "pinia";
import axios, {AxiosError} from "axios";
import {ref} from "vue";
import AnswerResponseData = App.DataTransferObjects.AnswerResponseData;

export const useAnswerResponseStore = defineStore('answer-response', () => {

    let answerResponseData = ref<AnswerResponseData[]>([]);

    async function submitAnswer(baseUrl, form)
    {
        form.post(`${baseUrl}/earn/learn/answer-response/store/answer`, {
            preserveScroll: true,
            preserveState: false,

        });
    }

    async function loadUserAnswerResponses()
    {
        try {
            const response = await axios.get(`/earn/learn/answer-response/responses`);
            answerResponseData.value = response.data;
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    // onMounted(loadUserAnswerResponses);

    return {
        answerResponseData,
        submitAnswer,
    };
});
