<template>
    <div class="bg-slate-100 login-form-wrapper">
        <LoginForm :showLogo="false"
                   :errors="errors"
                   @go-to-register="router.get(`${usePage().props.ziggy.url}/sw/earn/learn/register`)"
                   @success="router.get(`${usePage().props.base_url}/sw/earn/learn/modules`)"
                   @setForm="getForm($event)"
                   @submit="submit" />
        <DuplicateAccountPopup :isOpen="duplicateError" @close="duplicateError = false"/>
    </div>
</template>

<script lang="ts" setup>
import  { ref, watch, toRef } from "vue";
import {useForm, router, usePage} from "@inertiajs/vue3";
import LoginForm from "@/global/Components/LoginForm.vue";
import DuplicateAccountPopup from "../modules/learn/components/DuplicateAccountPopup.vue"

const props = withDefaults(
    defineProps<{
        errors?: Object,
    }>(), {});

let form = useForm({})

let getForm = (loginForm:any) => {
    form = loginForm
} 

let submit = () => {
    const baseUrl = usePage().props?.ziggy?.url;
    form.post(`${baseUrl}/api/earn/learn/login`, {
        preserveScroll: true,
        onSuccess: () => {
            router.get(`${baseUrl}/sw/earn/learn/modules`)
        }
    })
}
let errorsRef = toRef(props, 'errors');
let duplicateError = ref(false)

watch(errorsRef, (newErrors, oldErrors) => {
    if (newErrors && 'duplicate' in newErrors) {
        duplicateError.value = true
    }
});
</script>
