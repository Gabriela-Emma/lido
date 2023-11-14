import { defineStore } from "pinia";
import { computed, onMounted, ref, Ref } from "vue";
import QuizData = App.DataTransferObjects.QuizData;
import route from "ziggy-js";
import {useSpinnerStore} from "@/global/stores/spinner-store";
import axios from "@/global/utils/axios";

export const useEveryEpochStore = defineStore("every-epoch", () => {
    let quiz: Ref<QuizData|null> = ref(null);
    let answerResponse = ref(null);
    let epochAnswer = ref(null);
    let epochDetails = ref(null);
    let rewardPot = ref(null);
    let rewardTemplate = ref(null);
    let claimed = ref(false);
    let reward = ref(null);
    let epochErrors = ref(null)
    let processing = ref(false);
    const spinnerStore = useSpinnerStore();



    function init() {
        spinnerStore.showSpinner()
        getEpochDetail();
        getEpochAnswer();
        getQuiz();
        getRewardPot();
        getRewardtemplate();
    }

    function getQuiz() {
        try {
            axios.get(route("epoch.quiz")).then((res) => {
                quiz.value = res?.data;
            });
        } catch (error) {
            epochErrors.value = error;
        }
    }

    function submitAnswer(answer) {
        try {
            axios
                .post(route("epoch.response.store"), answer)
                .then((res) => {
                    answerResponse.value = res?.data;
                });
        } catch (error) {
            epochErrors.value = error;
        }
    }

    function getEpochAnswer() {
        try {
            axios
                .get(route("epoch.answerResponse"))
                .then((res) => {
                    if (!res.data) {
                        epochAnswer.value = null;
                    }
                    epochAnswer.value = res?.data;
                });
        } catch (error) {
            epochErrors.value = error;
        }
    }

    function getEpochDetail() {
        try {
            axios
                .get(route("epoch.epochDetails"))
                .then((res) => {
                    epochDetails.value = res?.data;
                });
        } catch (error) {
            epochErrors.value = error;
        }
    }

    function getRewardPot() {
        try {
            axios
                .get(route("epoch.rewardsPot"))
                .then((res) => {
                    rewardPot.value = res?.data;
                });
        } catch (error) {
            epochErrors.value = error;
        }
    }

    function getRewardtemplate() {
        try {
            axios
                .get(route("epoch.rewardsTemplate"))
                .then((res) => {
                    rewardTemplate.value = res?.data;
                });
        } catch (error) {
            epochErrors.value = error;
        }
    }

    function claimAsset(asset) {
        processing.value = true
        try {
            axios
                .post(route("epoch.rewardsClaim"), { asset: asset })
                .then((res) => {
                    processing.value = false
                    reward.value = res.data;
                    reward.value ? claimed.value = true : null;
                });
        } catch (error) {
            epochErrors.value = error;
        }
    }

    let loaded = computed(() => quiz.value != null && epochDetails.value != null && rewardPot.value != null &&
        rewardTemplate.value != null);

    onMounted(init);
    return {
        quiz,
        submitAnswer,
        answerResponse,
        epochAnswer,
        epochDetails,
        rewardPot,
        rewardTemplate,
        claimed,
        claimAsset,
        loaded,
        epochErrors,
        processing
    };
});
