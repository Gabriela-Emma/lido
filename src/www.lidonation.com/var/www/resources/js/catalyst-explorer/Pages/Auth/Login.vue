<template>
    <div class="bg-slate-100 login-form-wrapper">
        <LoginForm  :role="'catalyst-explorer'"
                    :showLogo="showLogo"
                   :errors="errors"
                   :embedded="embedded"
                   @setForm="getForm($event)"
                   @submit="submit"
                   @go-to-register="router.get(route('catalystExplorer.register'))"
                   />
    </div>
</template>

<script lang="ts" setup>
import {router, useForm} from "@inertiajs/vue3";
import LoginForm from "../../../global/Shared/Components/LoginForm.vue";
import route from "ziggy-js";

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
