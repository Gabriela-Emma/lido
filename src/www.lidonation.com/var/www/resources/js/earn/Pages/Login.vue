<template>
    <div class="bg-slate-100 login-form-wrapper">
        <LoginForm :showLogo="false" :errors="errors" />
    </div>
</template>

<script lang="ts" setup>
import LoginForm from "../../global/Shared/Components/LoginForm.vue";

const props = withDefaults(
    defineProps<{
        errors?: Object,
    }>(), {});

let submit = (form) => {
    form.post('/earn/login');
}
</script>
