<template>
    <p>{{  tweened.number.toFixed(0) }}</p>
</template>

<script lang="ts" setup>
import { ref, reactive, watch } from 'vue'
import gsap from "gsap"

const props = defineProps<{
    digits: number
    duration:number
}>()

const tweened = reactive({
    number: 0
})

gsap.to(tweened, { duration: props.duration, number: Number(props.digits) || 0 })

</script>