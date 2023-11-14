<template>
    <div class="bg-slate-100 login-form-wrapper">
        <LoginForm  :role="'catalyst-explorer'"
                    :showLogo="showLogo"
                   :errors="errors"
                   :embedded="embedded"
                   @setForm="getForm($event)"
                   @submit="submit"
                   @go-to-register="router.get(route('catalyst-explorer.register'))"
                   />
    </div>
</template>

<script lang="ts" setup>
import {router, useForm} from "@inertiajs/vue3";
import route from "ziggy-js";
import LoginForm from "@/global/Components/LoginForm.vue";

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
    form.post(route('catalystExplorerApi.login'), {
        onSuccess: () => {
            window.location.reload();
        }
    });
}
</script>
