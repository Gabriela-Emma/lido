<template>
    <div class="bg-slate-100 login-form-wrapper">
        <LoginForm  :role="'catalyst-explorer'"
                    :showLogo="showLogo"
                   :errors="errors"
                   :embedded="embedded"
                   @setForm="getForm($event)"
                   @submit="submit"
                   @go-to-register="router.get(`${usePage().props.base_url}/en/catalyst-explorer/register`)"
                   />
    </div>
</template>

<script lang="ts" setup>
import {router, useForm, usePage} from "@inertiajs/vue3";
import LoginForm from "../../../global/Shared/Components/LoginForm.vue";

withDefaults(
    defineProps<{
        errors?: Object,
        embedded?: boolean,
        showLogo?: boolean,
    }>(), {embedded: false, showLogo:true});

let form = useForm({})

let getForm = (loginForm) => {
    form = loginForm
}

let submit = () => {
    form.post(`${usePage().props.base_url}/api/catalyst-explorer/login`, {
        onSuccess: () => {
            router.get(`${usePage().props.base_url}/catalyst-explorer/my/dashboard`)
        }
    });
}
</script>
