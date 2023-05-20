<template>
    <nav>
        <Link
            :href="route('rewards.index')"
            :class="{ 'active': $page.component.endsWith('Rewards') }"
            class="inline-flex items-center px-1 py-0.5 rounded text-xs">
            Rewards
        </Link>
        <Link :href="route('rewards.withdrawals.index')"
              :class="{ 'active': $page.component.endsWith('History') }"
              class="inline-flex items-center px-1 py-0.5 rounded text-xs">
            History
        </Link>
    </nav>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';

</script>
