<template>
    <div class="flex justify-center">
        <div class="mt-2 flex flex-col gap-6 bg-white/[.92] py-5 px-8">
            <div v-show="walletError" v-text="walletError"
                 class="my-1 text-sm text-red-500 w-96"></div>
            <WalletLoginBtn role="reward"
                            redirect="rewards"
                            @walletError="handleWalletError($event)"
                            @walletLoginSuccessful="refresh"
                            @user="setUser($event)"/>
            <div>
                <Divider />
            </div>

            <div class="text-slate-800">
                <LoginForm :forRewards="true"
                           :embedded="true"
                           :showLogo="false"
                           :showDivider="false"
                           :showWalletBtn="false"
                           :role="'rewards'"
                           @setForm="getForm($event)"
                           @submit="submit($event)"/>
                <div v-show="errors.length>0" v-text="errors"
                     class="my-1 text-sm text-red-500 w-96"></div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {useForm, router, usePage} from "@inertiajs/vue3";
import LoginForm from "@/global/Components/LoginForm.vue";
import route from "ziggy-js";
import Divider from "@/global/Components/Divider.vue";
import WalletLoginBtn from "@/global/Components/WalletLoginBtn.vue";
import axios from "@/global/utils/axios";
import {AxiosError} from "axios";
import {ref} from "vue";

const props = withDefaults(
    defineProps<{
        errors?: Object,
    }>(), {});

let form = useForm({})

let getForm = (loginForm: any) => {
    form = loginForm
}

let setUser = (userData) => {
    refresh();
}

function refresh() {
    router.get(`${usePage().props.base_url}/rewards/`);
}

let submit = () => {
    form.post(route('rewardsApi.login'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            router.get(route('rewards.index'))
        }
    })
}

let walletError = ref(null);
let handleWalletError = (error) => {
    walletError.value = error.message;
}

let errors = ref('');
</script>
