<template>
    <div class="bg-slate-100 earn--register-form-wrapper overflow-auto">
        <RegisterForm
            :showLogo="false"
            :role="'earn/learn'"
            :errors="errors"
            @endpoint="setEndpoint($event)"
            @setForm="getForm($event)"
            @submit="submit"
        />
        <RegistrationStoppedVue :show="!registerOpen"/>
    </div>
</template>

<script lang="ts" setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import RegisterForm from "../Components/Global/RegisterForm.vue";
import RegistrationStoppedVue from "../Components/Global/RegistrationStopped.vue";
const props = withDefaults(
    defineProps<{
        errors?: Object;
        registerOpen?: boolean;
    }>(),
    {}
);

let Endpoint = ref("");
let form = useForm({});

let setEndpoint = (url: string) => {
    Endpoint.value = url;
};

let getForm = (RegisterForm:any) => {
    form = RegisterForm;
};

let submit = () => {
    console.log(Endpoint.value);
    form.post(Endpoint.value);
};
</script>
