import { usePage } from "@inertiajs/vue3";
import { defineStore } from "pinia";
import User from "../Models/user";
import { onMounted } from "vue";

export const useUserStore = defineStore('user', () => {
    let user: User = null;

    function setUser(){
        user =  usePage().props?.user as User;
    }

    onMounted(setUser);

    return {
        setUser,
        user$: user
    }
});
