<template>
    <div class="bg-slate-100 login-form-wrapper">
        <LoginForm :showLogo="false"
                   :errors="errors"
                   @success="router.get(route('rewards.index'))"
                   @setForm="getForm($event)"
                   @submit="submit" />
    </div>
</template>

<script lang="ts" setup>
import {useForm, router} from "@inertiajs/vue3";
import LoginForm from "@/global/Components/LoginForm.vue";
import route from "ziggy-js";

const props = withDefaults(
    defineProps<{
        errors?: Object,
    }>(), {});

let form = useForm({})

let getForm = (loginForm: any) => {
    form = loginForm
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
</script>
