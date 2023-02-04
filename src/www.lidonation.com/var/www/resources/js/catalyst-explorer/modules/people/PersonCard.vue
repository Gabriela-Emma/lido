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
                <div class="text-xs font-medium lg:text-sm">
                    <h3>
                        <a class="block" target="_blank"
                           :href="$utils.localizeRoute(`project-catalyst/users/${user.id}`)">
                            {{ user.name }}
                        </a>
                    </h3>
                    <p class="">
                        <span>
                            {{user.proposals_count}} {{ user.proposals_count > 1 ? 'Proposals' : 'Proposal' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import User from "../../models/user";
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
