<template>
    <div class="bg-slate-100 login-form-wrapper">
        <LoginForm :showLogo="false"
                   :errors="errors"
                   @go-to-register="router.get(`${usePage().props.base_url}/sw/earn/learn/register`)"
                   @success="router.get(`${usePage().props.base_url}/sw/earn/learn/modules`)"
                   @setForm="getForm($event)"
                   @submit="submit" />
    </div>
</template>

<script lang="ts" setup>
import {useForm, router, usePage} from "@inertiajs/vue3";
import LoginForm from "../../global/Shared/Components/LoginForm.vue";

const props = withDefaults(
    defineProps<{
        errors?: Object,
    }>(), {});

let form = useForm({})

let getForm = (loginForm) => {
    form = loginForm
}

let submit = () => {
    form.post(`${usePage().props.base_url}/api/earn/learn/login`, {
        preserveScroll: true,
        onSuccess: () => {
            router.get(`${usePage().props.base_url}/sw/earn/learn/modules`)
        }
    })
}
</script>
