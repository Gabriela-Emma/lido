<template>
    <div class="bg-slate-100 earn--register-form-wrapper overflow-auto">
        <RegisterForm :showLogo="false"
                      :role="'earn/learn'"
                      :errors="errors"
                      @endpoint="setEndpoint($event)"
                      @setForm="getForm($event)"
                      @submit="submit"/>
    </div>
</template>

<script lang="ts" setup>
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import RegisterForm from "../Shared/Components/RegisterForm.vue";
import RegistrationClosed from "../modules/learn/components/RegistrationClosed.vue";

const props = withDefaults(
    defineProps<{
        errors?: Object,
    }>(), {});

let Endpoint = ref('')
let form = useForm({})

let setEndpoint = (url: string) => {
    Endpoint.value = url
}

let getForm = (RegisterForm) => {
    form = RegisterForm
}

let submit = () => {
    form.post(Endpoint.value);
}
</script>
