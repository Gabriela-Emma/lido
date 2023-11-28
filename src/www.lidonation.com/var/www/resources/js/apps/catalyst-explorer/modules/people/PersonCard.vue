<template>
    <div class="bg-white round-sm p-8">
        <div class="space-y-4">
            <a class="block" target="_blank"
               :href="$utils.localizeRoute(`project-catalyst/users/${user.id}`)">
                <img class="w-20 h-20 mx-auto rounded-full lg:w-24 lg:h-24"
                     :src="user.media?.length > 0 ? user?.media[0]?.original_url : user.profile_photo_url"
                     :alt="user.name"/>
            </a>

            <div class="space-y-2">
                <div class="text-xs font-medium lg:text-sm flx flex-col justify-between">
                    <h3>
                        <a class="block" target="_blank"
                           :href="$utils.localizeRoute(`project-catalyst/users/${user.id}`)">
                            {{ user.name }}
                        </a>
                    </h3>
                    <div class="flex flex-col divide-y mt-2">
                        <div class="py-2">
                            <span>
                                {{user.own_proposals_count}} {{ user.own_proposals_count > 1 ? $t('Own Proposals') : $t('Own Proposal') }}
                            </span>
                        </div>
                        <div class="py-2">
                            <span>
                                {{user.co_proposals_count}} {{ user.co_proposals_count > 1 ? $t('Co Proposals') : $t('Co Proposal') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {inject} from "vue";
import User from "@/global/models/user";

const $utils: any = inject('$utils');
const props = withDefaults(
    defineProps<{
        user: User
    }>(),
    {
        user: () => {
            return {} as User;
        }
    },
);
</script>
