import { router, usePage } from "@inertiajs/vue3";
import { defineStore } from "pinia";
import { Ref, onMounted, ref } from "vue";
import route from "ziggy-js";
import User from "@/global/models/user";

export const useUserStore = defineStore('user', () => {
    let user$: Ref<User|null> = ref(null);

    function setUser() {
        console.log({page:usePage()});
        
        user$.value =  usePage().props?.ziggy.user as User;
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
