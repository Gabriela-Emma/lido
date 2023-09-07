import { router, usePage } from "@inertiajs/vue3";
import { defineStore } from "pinia";
import User from "../Models/user";
import { Ref, onMounted, ref } from "vue";
import route from "ziggy-js";

export const useUserStore = defineStore('user', () => {
    let user$: Ref<User> = ref(null);

    function setUser() {
        user$.value =  usePage().props?.user as User;
    }

    function logout() {
        router.post(route('catalystExplorerApi.logout'), {}, {
            onSuccess: () => {
                user$.value = null;
            }

        });
    }

    onMounted(setUser);

    return {
        setUser,
        logout,
        user$
    }
});
