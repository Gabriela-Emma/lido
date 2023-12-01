<template>
    <div class="bg-gray-100 flex items-center justify-center py-6">
        <div class="bg-gray-100 mb-6 w-full container">
            <form
                v-if="!success && isValidDrep"
                @submit.prevent="save()"
                class="space-y-4 text-lg bg-white rounded shadow-md p-4 px-4 container mx-auto"
            >
                <div>
                    <h2>Become a dRep - Delegate Representative in Catalyst</h2>
                </div>
                <div>
                    <label for="full_name" class="font-light">Full Name</label>
                    <input
                        v-model="form.name"
                        type="text"
                        name="full_name"
                        id="full_name"
                        class="h-10 mt-1 px-4 w-full bg-gray-50 outline-none border border-gray-100 rounded-sm text-sm focus:border-blue-500"
                        placeholder="John Doe"
                        required
                    />
                </div>

                <div>
                    <label for="email" class="font-light">Email Address</label>
                    <input
                        v-model="form.email"
                        type="email"
                        name="email"
                        id="email"
                        class="h-10 mt-1 px-4 w-full bg-gray-50 outline-none border border-gray-100 rounded-sm text-sm focus:border-blue-500"
                        placeholder="email@domain.com"
                        required
                    />
                </div>
                <div>
                    <label for="message" class="font-light"
                        >Platform statement</label
                    >
                    <textarea
                        v-model="form.platformStatement"
                        id="message"
                        rows="4"
                        class="mt-1 px-4 w-full text-sm bg-gray-50 outline-none rounded-sm border border-gray-100 focus:border-blue-500"
                        placeholder="Write your thoughts here..."
                        required
                    ></textarea>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <span class="border-b w-1/5 lg:w-1/2"></span>
                    <a href="#" class="text-xs text-center uppercase text-slate-400"
                        >connect your wallet</a
                    >
                    <span class="border-b w-1/5 lg:w-1/2"></span>
                </div>
                <div
                    class="border border-gray-100 bg-gray-50 rounded-sm px-4 py-10"
                >
                    <div
                        class="flex flex-col justify-center items-center gap-4">
                        <ConnectWallet />

                        <div class="px-4 md:px-10 xl:px-24 2xl:px-36">
                            <p
                                class="text-base font-light leading-relaxed tracking-wide"
                            >
                                To ensure your eligibility to be a dRep, please
                                connect your Cardano wallet. This will allow us
                                to verify that you have been an active voter in
                                the previous two funding cycles, demonstrating
                                your continued support for the Project Catalyst
                                initiative.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="md:flex md:flex-row md:items-center gap-4">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-between gap-2 px-3 py-2 font-medium text-white rounded-sm menu-link xl:text-xl 3xl:text-2xl bg-teal-700 hover:bg-teal-900"
                    >
                        Submit
                    </button>
                    <span v-if="loading"
                        ><svg
                            aria-hidden="true"
                            class="inline w-7 h-7 text-gray-200 animate-spin fill-slate-600"
                            viewBox="0 0 100 101"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor"
                            />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill"
                            />
                        </svg>
                    </span>
                    <p v-if="!isConnected" class="text-red-700 text-xs">
                        Please connect your Cardano wallet.
                    </p>
                    <p v-if="!isSigned" class="text-red-700 text-xs">
                        Please sign the message to get a signature.
                    </p>
                </div>
            </form>

            <div v-if="success">
                <div
                    class="text-gray-600 flex flex-col justify-center rounded shadow-md p-4 px-4 bg-white"
                >
                    <div class="flex items-start gap-4">
                        <p class="text-black font-bold text-2xl">
                            Congratulations on successfully registering to be a
                            dRep!
                        </p>
                        <span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6 text-green-600"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"
                                />
                            </svg>
                        </span>
                    </div>
                    <p
                        class="text-xl font-light leading-relaxed tracking-wide py-8"
                    >
                        We are excited to have you join our community of dReps
                        and contribute to the governance of Cardano. Your
                        participation is essential in ensuring that Cardano
                        continues to develop in a way that meets the needs of
                        the community. In the meantime, wait for more
                        communication and learn more about the role of dReps and
                        how to participate in governance on the Cardano website.
                    </p>
                </div>
            </div>

            <div v-if="!isValidDrep">
                <div
                    class="text-gray-600 flex flex-col justify-center rounded shadow-md p-4 px-4 bg-white"
                >
                    <div class="flex items-start gap-4">
                        <p class="text-black font-bold text-2xl">
                            Form successfully submitted.
                        </p>
                        <span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6 text-green-600"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"
                                />
                            </svg>
                        </span>
                    </div>
                    <p
                        class="text-xl font-light leading-relaxed tracking-wide py-8"
                    >
                        We regret to inform you that you do not currently meet
                        the eligibility criteria to become a dRep. One of the
                        requirements for dReps is to have actively participated
                        in the governance process by casting votes in the last
                        two voting rounds. Unfortunately, we could not verify
                        your voting activity in these rounds. To ensure that
                        dReps are actively engaged in the governance process, we
                        require them to have a consistent history of voting.
                        This helps to ensure that the dRep community is
                        representative of the Cardano community as a whole. We
                        encourage you to continue participating in the
                        governance process by voting in future rounds. Once you
                        have voted in two consecutive rounds, you will be
                        eligible to apply for dRep status again.** Thank you for
                        your interest in serving as a dRep!
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
// @ts-nocheck
import { fromText } from "@lucid-cardano";
import ConnectWallet from "@/global/Components/ConnectWallet.vue";
import { useWalletStore } from "@/global/stores/wallet-store";
import { storeToRefs } from "pinia";
import WalletService from "@/global/services/wallet-service";
import { useForm } from "@inertiajs/vue3";
import route from "ziggy-js";
import { ref } from "vue";
import axios from "axios";

let walletStore = useWalletStore();
let { walletData } = storeToRefs(walletStore);
let isValidDrep = ref(true);
let isConnected = ref(true);
let success = ref(false);
let loading = ref(false);
let isSigned = ref(true);

let form = useForm({
    name: "",
    email: "",
    platformStatement: "",
    signature: "",
    stakeAddress: "",
});

async function save() {
    if (!walletData.value?.address) {
        isConnected.value = false;
        return;
    }

    loading.value = true;
    isConnected.value = true;

    const messageHex = fromText("Catalyst dReps sign up");
    // const signature = (await new WalletService().signMessage(
    //     walletData.value?.name,
    //     messageHex
    // )) as {};

    try {
        const signature = (await new WalletService().signMessage(
            walletData.value?.name,
            messageHex
        )) as {};

        form.signature = signature?.signature;
        form.stakeAddress = walletData.value?.stakeAddress;
    } catch (error) {
        if (error.message === "user declined to sign data") {
            loading.value = false;
            success.value = false;
            isSigned.value = false;
            return
        }
    }

    axios
        .post(route("catalyst-explorer.dReps.store"), form)
        .then((response) => {
            success.value = true;
            loading.value = false;
            form.reset();
        })
        .catch((error) => {
            isValidDrep.value = false;
            loading.value = false;
        });
}
</script>
