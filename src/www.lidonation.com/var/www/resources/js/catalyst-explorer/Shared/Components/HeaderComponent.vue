<template>
    <header class="py-10 container">
        <h1 class="text-2xl lg:text-3xl 2xl:text-5xl font-semibold text-slate-700">
            {{ titleName0 }} <span class="text-teal-600"> {{ titleName1 }}</span>
        </h1>
        <p class="text-slate-600">
            {{subTitle}}
        </p>
    </header>
</template>

<script lang="ts" >
export default {
  props: {
    titleName0: String,
    titleName1: String,
    subTitle:String
  }
}

</script>
