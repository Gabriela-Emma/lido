<template>
    <div
        class="bg-gradient-to-br py-16 from-teal-500 via-teal-600 to-accent-900 relative text-white flex justify-center">
        <div class="mt-2 flex flex-col justify-center gap-2 bg-white/[.92] py-5 px-8">
            <div v-if="walletError"
                 v-text="walletError"
                 class="my-1 text-sm text-red-500 text-center w-96"></div>

            <WalletLoginBtn role="reward"
                            redirect="rewards"
                            @walletError="handleWalletError($event)"
                            @walletLoginSuccessful="refresh" />

            <div class="mt-4">
                <Divider/>
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
import {ref} from "vue";

let walletError = ref(null);
let form = useForm({})

const props = withDefaults(
    defineProps<{
        errors?: Object,
    }>(), {});

let getForm = (loginForm: any) => {
    form = loginForm
}

let setUser = () => {
    refresh();
}

function refresh() {
    router.get(
        route('rewards.index')
    );
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


let handleWalletError = (error: any) => {
    console.log({error});
    walletError.value = error.message ?? error;
}

let errors = ref('');
</script>
