<template>  
   <div class="flex items-center justify-center h-screen bg-slate-100">
        <form >
            <div class=" bg-white shadow-sm  rounded  p-6 w-96">
                <div class=" flex-col  mb-4">
                    <div class=" flex items-center justify-center">
                        <h1 class="text-2xl lg:text-3xl 2xl:text-5xl font-semibold text-slate-700"> Login </h1>
                    </div>
                    <div class="flex items-center justify-center mb-4">
                        <img alt="catalyst explorer logo" :src="$utils.assetUrl('img/catalyst-explorer-logo.jpg')" class="h-40" />
                    </div>
                </div>    
                <div class="mb-2">
                    <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
                    <div class="mt-1 ">
                        <input v-model="form.email" id="email" name="email" type="email" autocomplete="email" required
                            class="block w-full appearance-none rounded-sm border border-slate-400 px-3  py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-1"></div>
                    </div>
                </div>

                <div class="mb-2">
                    <label for="email" class="block text-sm font-medium text-slate-700">Password</label>
                    <div class="mt-1">
                        <input v-model="form.password" id="password" name="password" type="password" autocomplete="password" required
                            class="block w-full appearance-none rounded-sm border border-slate-400 px-3  py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-1"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4 mb-2">
                    <div class="flex items-center">
                        <input v-model="form.remember" id="remember-me" name="remember-me" type="checkbox"
                            class="h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <label for="remember" class="ml-2 block text-sm text-slate-900">Remember me</label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-bold text-teal-600 hover:text-teal-500">Forgot your password?</a>
                    </div>
                </div>

                <div class="justify-between flex items-end ">
                    <button @click.prevent="submit"
                            type="submit"
                            class="flex gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-xl 2xl:text-2xl font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        <span>Sign in</span>
                    </button>
                    <span class="text-sm">
                        <a href="#" class="font-bold text-teal-600 hover:text-teal-500">Register</a>
                    </span>
                </div>
            </div>
        </form>   
    </div>
</template>
<script>

</script>

<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';

const props=defineProps({
    errors:Object
})
let form= useForm({
    password:'',
    email:'',
    remember:false
})

let submit=()=>{
    form.post('/api/catalyst-explorer/login');
}
console.log(form)

</script>