<template>
    <section class="bg-white px-6 py-2.5" v-if="!submitted">
        <h1>
            Catalyst SWARM - After Town Hall Breakout Room & Community Events
        </h1>
        <div class="flex flex-col gap-2">
            <p>
                Thank you for your interest in Catalyst Swarm After Town Hall!
            </p>
            <p>
                Fill out this form to turn that interest into Action!
                <span class="font-bold text-red-500"
                    >DEADLINE TO REGISTER for Wednesday’s ATH Break Out Rooms -
                    EACH TUESDAY 17.00 UTC</span
                >
            </p>
            <p>
                For more informations, visit us on
                <a href="https://catalystswarm.com/" target="_blank"
                    >https://catalystswarm.com/</a
                >
                |
                <a href="https://twitter.com/CatalystSwarm" target="_blank"
                    >https://twitter.com/CatalystSwarm</a
                >
                |
                <a href="https://discord.gg/9pbRF2PfcU" target="_blank"
                    >https://discord.gg/9pbRF2PfcU</a
                >
            </p>
        </div>

        <form class="mt-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border border-gray-300 rounded-md p-5">
                    <label
                        for="name"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Full Name</label
                    >
                    <div class="mt-2">
                        <input
                            v-model="form.full_name"
                            type="text"
                            name="name"
                            id="name"
                            class="border border-gray-200 text-gray-500 text-sm rounded-md block w-full py-2.5 px-0"
                            required
                        />
                        <div
                            v-if="form.errors.full_name"
                            v-text="form.errors.full_name"
                            class="text-red-500 text-xs mt-1"
                        ></div>
                    </div>
                </div>

                <div class="border border-gray-300 rounded-md p-5">
                    <label
                        for="email"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Your Email</label
                    >
                    <div class="mt-2">
                        <input
                            v-model="form.email"
                            type="email"
                            name="email"
                            id="email"
                            class="border border-gray-200 text-gray-500 text-sm rounded-md block w-full py-2.5 px-0"
                            required
                        />
                        <div
                            v-if="form.errors.email"
                            v-text="form.errors.email"
                            class="text-red-500 text-xs mt-1"
                        ></div>
                    </div>
                </div>

                <div class="border border-gray-300 rounded-md p-5">
                    <label
                        for="co-host"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Name of Co-Host
                        <span class="block"
                            >If you have a co host to facilitate the discussion
                            in your room* (not mandatory)</span
                        >
                    </label>
                    <div class="mt-2">
                        <input
                            v-model="form.cohost_name"
                            type="text"
                            name="co-host"
                            id="co-host"
                            class="border border-gray-200 text-gray-500 text-sm rounded-md block w-full py-2.5 px-0"
                        />
                    </div>
                </div>

                <div
                    class="border border-gray-300 rounded-md p-5 flex flex-col justify-end"
                >
                    <div>
                        <label
                            for="twitter"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >Twitter handle to your Project ( optional )
                        </label>
                        <div class="mt-2">
                            <input
                                v-model="form.twitter"
                                type="text"
                                name="twitter"
                                id="twitter"
                                class="border border-gray-200 text-gray-500 text-sm rounded-md block w-full py-2.5 px-0"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="border border-gray-300 rounded-md mt-4">
                <div class="bg-black text-white p-3 text-center rounded-t-md">
                    <p>Request a Breakout room for the After Townhall</p>
                </div>
                <div class="p-3">
                    <p>
                        Every Wednesday, around 18:00UTC, after the Project
                        Catalyst Weekly Townhall
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div
                    class="border border-gray-300 rounded-md p-5 flex flex-col justify-end"
                >
                    <label
                        for="eventName"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >What is the name of your breakout room? (Max 120
                        characters)
                    </label>
                    <div class="mt-2">
                        <input
                            v-model="form.event_name"
                            type="text"
                            name="eventName"
                            id="eventName"
                            class="border border-gray-200 text-gray-500 text-sm rounded-md block w-full py-2.5 px-0"
                            placeholder="Town Hall Check-In"
                            required
                        />
                        <div
                            v-if="form.errors.event_name"
                            v-text="form.errors.event_name"
                            class="text-red-500 text-xs mt-1"
                        ></div>
                    </div>
                </div>
                <div class="border border-gray-300 rounded-md p-5">
                    <label
                        for="description"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Please give us a short description of your breakout
                        room to be used on announcements (Max 250 characters)
                    </label>
                    <div class="mt-2">
                        <textarea
                            v-model="form.description"
                            id="message"
                            rows="4"
                            class="block p-2.5 w-full text-sm text-gray-500 bg-gray-50 rounded-md border border-gray-300"
                            placeholder="Write your thoughts here..."
                        ></textarea>
                    </div>
                </div>

                <div class="border border-gray-300 rounded-md p-5">
                    <label
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >On which date do you want to host your room ? ( pls
                        select only dates on which Town Hall takes place ;) -
                        Each Wednesday on 18.00 UTC</label
                    >
                    <div class="mt-2">
                        <select
                            id="selectWednesday"
                            v-model="form.date"
                            class="border border-gray-200 text-gray-500 text-sm rounded-md block w-full p-2.5"
                        >
                            <option
                                class="py-1 px-2"
                                v-for="wednesday in nextWednesdays"
                                :key="wednesday"
                            >
                                {{ wednesday }}
                            </option>
                        </select>

                        <div
                            v-if="form.errors.date"
                            v-text="form.errors.date"
                            class="text-red-500 text-xs mt-1"
                        ></div>
                    </div>
                </div>
                <div
                    class="border border-gray-300 rounded-md p-5 flex flex-col justify-end"
                >
                    <div>
                        <label
                            for="website"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >Website to your Project ( optional )
                        </label>
                        <div class="mt-2">
                            <input
                                v-model="form.website"
                                type="text"
                                name="website"
                                id="website"
                                class="border border-gray-200 text-gray-500 text-sm rounded-md block w-full py-2.5 px-0"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="border border-gray-300 rounded-md mt-4 p-5">
                <h2>
                    Get Recognized & Rewarded for hosting your Room ( Optional )
                </h2>
                <p class="mt-0">
                    We deeply appreciate & respect Room hosts and invite you to
                    receive rewards for hosting your Room.
                </p>
                <p>
                    In order to be rewarded you would have to follow these
                    steps:
                </p>
                <p class="mt-0">
                    Join us on Dework where SWARM manages tasks & Bounties
                    <a
                        class="block"
                        href="https://app.dework.xyz/i/06KWakBQdcK8unXUqUWtqa"
                        target="_blank"
                        ><span class="break-words"
                            >https://app.dework.xyz/i/06KWakBQdcK8unXUqUWtqa</span
                        ></a
                    >
                </p>
                <p>
                    The SWARM Team will manually assign you to rewarded breakout
                    room tasks. You dont have to do any additional work than
                    joining the Dework - Swarm Server
                </p>
                <p>
                    NOTE* ONLY REQUIRED FOR NEW CONTRIBUTORS, ONCE YOU SUBMITTED
                    YOUR RECEIVING addr1 YOU WONT HAVE TO RESUBMIT
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div
                    class="border border-gray-300 rounded-md p-5 flex flex-col justify-end"
                >
                    <label
                        for="discord"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Your Dework/Discord handle
                    </label>
                    <div class="mt-2">
                        <input
                            v-model="form.discord"
                            type="text"
                            name="discord"
                            id="discord"
                            class="border border-gray-200 text-gray-500 text-sm rounded-md block w-full py-2.5 px-0"
                        />
                    </div>
                </div>
                <div class="border border-gray-300 rounded-md p-5">
                    <label
                        for="address"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Your receiving addr1
                        <span class="block">
                            Let us know to which wallet address you would like
                            to get your rewards been sent to</span
                        ></label
                    >
                    <div class="mt-2">
                        <input
                            v-model="form.address"
                            type="text"
                            name="address"
                            id="address"
                            class="border border-gray-200 text-gray-500 text-sm rounded-md block w-full py-2.5 px-0"
                        />
                    </div>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button
                    @click.prevent="clear"
                    type="submit"
                    class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                >
                    Clear
                </button>
                <button
                    @click.prevent="submit"
                    type="submit"
                    class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                >
                    Submit
                </button>
            </div>
        </form>
    </section>
    <section class="bg-white px-6 py-2.5" v-if="submitted">
        <h1>
            Catalyst SWARM - After Town Hall Breakout Room & Community Events
        </h1>
        <p>Your response has been recorded.</p>
        <button
            class="py-2 px-3 border rounded-md mt-4 hover:text-gray-700"
            @click="submitted = false"
        >
            Submit another response
        </button>
    </section>
</template>
<script lang="ts" setup>
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import route from "ziggy-js";

let submitted = ref(false);

let form = useForm({
    full_name: "",
    email: "",
    cohost_name: "",
    event_name: "",
    description: "",
    date: "",
    twitter: "",
    website: "",
    discord: "",
    address: "",
});

const nextWednesdays = computed(() => {
    const today = new Date();

    const nextWednesday = today.getDate() + ((7 - today.getDay() + 4) % 7);

    const nextWednesdays = [];
    for (let i = 0; i < 4; i++) {
        nextWednesdays.push(
            new Date(
                today.getFullYear(),
                today.getMonth(),
                nextWednesday + i * 7
            )
        );
    }

    return nextWednesdays.map((date) => date.toISOString().split("T")[0]);
});

function submit() {
    form.post(route("catalystExplorer.eventCreate"), {
        onSuccess: () => {
            submitted.value = true;
            clear();
        },
    });
}

function clear() {
    form.reset();
}
</script>
