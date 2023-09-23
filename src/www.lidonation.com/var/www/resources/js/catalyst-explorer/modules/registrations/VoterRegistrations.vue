<template>
    <div v-if="search && registrations?.data?.length === 0">
        <p>
            Could not find any registration transactions for the stake address <span class="font-bold">{{ search }}</span>.
        </p>
    </div>
    <div class="bg-white/90 p-4" v-if="search && registrations?.data?.length > 0">
        <div class="flex items-center gap-4 rounded-sm">
            <div class="sm:flex-auto">
                <div class="max-w-2xl">
                    <h1 class="text-lg font-semibold leading-6 text-gray-900">
                        My Registrations
                    </h1>
                    <p class="block mt-2 text-gray-700">
                        Here are the onchain transactions of registrations for the stake address <span class="font-bold">{{ search }}</span>
                    </p>
                </div>
                <div class="max-w-xl p-3 mt-2 text-white bg-teal-600 rounded-sm text-md">
                    <p class="block mt-2 text-white">
                        This tool shows your historical registrations only. It does not validate your registration.
                        If you have your qr code you can use this IO tool to validate your registrations:
                        <a href="https://verify.testnet.projectcatalyst.io/" target="_blank"
                           class="text-yellow-500 hover:text-black">
                            https://verify.testnet.projectcatalyst.io/
                        </a>
                    </p>
                    <p class="block mt-2 text-white">
                        To learn how to registration as a voter, please visit:
                        <a href="https://docs.projectcatalyst.io/catalyst-basics/how-to-register-as-a-voter"
                           target="_blank" class="text-yellow-500 hover:text-black">
                            https://docs.projectcatalyst.io/catalyst-basics/how-to-register-as-a-voter
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="flow-root mt-8">
            <div class="-my-2 overflow-x-auto">
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-sm">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Tx</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="registration in registrations.data" :key="registration.tx">
                                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                    {{
                                        new Date(
                                            registration.created_at
                                        ).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"})
                                    }}
                                </td>
                                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                    <a class="inline-flex text-base font-medium text-teal-800 hover:text-yellow-500"
                                       target="_blank" :href="`https://cexplorer.io/tx/${registration.tx}/metadata#data`">
                                        {{ registration.tx }}
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import CatalystRegistrationData = App.DataTransferObjects.CatalystRegistrationData;

const props = withDefaults(
    defineProps<{
        search?: string,
        currPage?: number,
        perPage?: number,
        registrations: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: CatalystRegistrationData[]
        }
    }>(), {
        search: '',
    });
</script>
