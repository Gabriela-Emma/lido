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
import RegisterForm from "../Shared/Components/RegisterForm.vue";
import RegistrationStoppedVue from "../Shared/Components/RegistrationStopped.vue";

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

let getForm = (RegisterForm) => {
    form = RegisterForm;
};

let submit = () => {
    form.post(Endpoint.value);
};
</script>
