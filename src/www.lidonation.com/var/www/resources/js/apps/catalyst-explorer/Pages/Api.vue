<template>
    <Head title="Catalyst API" />
    <header-component titleName0="catalyst" titleName1="Explorer API" subTitle=""/>
    <section>
        <h1>{{ $t('Api section') }}</h1>
    </section>
</template>

<script>

import Public from "@apps/catalyst-explorer/Layouts/Public.vue";
import {Head} from "@inertiajs/vue3";

export default {
    components: {Head},
    layout: Public
}
</script>
