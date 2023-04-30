<template>
    <div class="bg-slate-100 login-form-wrapper">
        <LoginForm :showLogo="false"
                   :errors="errors"
                   @success="router.get(`${usePage().props.base_url}/sw/earn/learn/modules`)"
                   @endpoint="setEndpoint($event)"
                   @setForm="getForm($event)"
                   @submit="submit" />
    </div>
</template>

<script lang="ts" setup>
import { useForm, router } from "@inertiajs/vue3";
import { ref } from "vue";
import LoginForm from "../../global/Shared/Components/LoginForm.vue";

const props = withDefaults(
    defineProps<{
        errors?: Object,
    }>(), {});

let Endpoint= ref('')
let form = useForm({})

let setEndpoint = (url:string) => {
    Endpoint.value = url
}

let getForm = (loginForm) => {
    form = loginForm
}

let submit = () => {
    form.post(Endpoint.value);
}
</script>
