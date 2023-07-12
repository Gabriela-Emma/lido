import { usePage } from "@inertiajs/vue3";
import { defineStore } from "pinia";
import User from "../Models/user";
import { Ref, onMounted } from "vue";

export const useUserStore = defineStore('user', () => {
    let user$: Ref<User> = null;

    function setUser() {
        user$.value =  usePage().props?.user as User;
    }

    onMounted(setUser);

    return {
        setUser,
        user$
    }
});
