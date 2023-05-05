<template>
    <div v-if="user">
        <Nav :crumbs=crumbs />
    </div>

    <section class="">
        <slot></slot>
        <Modal />
    </section>
</template>

<script lang="ts" setup>
import { Modal } from "momentum-modal"
import Nav from "./Nav.vue";
import {useForm, usePage} from '@inertiajs/vue3';
import {computed} from "vue";
import Spinner from "../../global/Shared/Components/Spinner.vue";
import User from '../../global/Shared/Models/user'

const props = withDefaults(
    defineProps<{
        crumbs: []
    }>(), {});

const user = computed(() => usePage().props.user as User)
</script>
