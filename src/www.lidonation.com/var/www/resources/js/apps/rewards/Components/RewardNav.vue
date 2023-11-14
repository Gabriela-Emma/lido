<template>
    <nav>
        <Link
            :href="route('rewards.index')"
            :class="{ 'active': $page.component.endsWith('Rewards') }"
            class="inline-flex items-center px-1 py-0.5 rounded">
            Rewards
        </Link>
        <Link :href="route('rewards.withdrawals.index')"
              :class="{ 'active': $page.component.endsWith('History') }"
              class="inline-flex items-center px-1 py-0.5 rounded">
            History
        </Link>
        <Link class="flex gap-1 items-center text-teal-200 font-bold hover:text-red-600"
            href="/api/catalyst-explorer/logout" method="POST" as="button">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-4 h-4 relative">
            <path stroke-linecap="round" stroke-linejoin="round"
             d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
             </svg>
                            {{ $t('logout') }}
        </Link>
    </nav>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';

</script>
