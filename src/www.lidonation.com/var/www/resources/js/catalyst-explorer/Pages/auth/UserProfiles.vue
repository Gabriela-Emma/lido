<template>
    <header-component titleName0="My Catalyst" titleName1="Profile" subTitle=""/>

    <section class="py-16 bg-primary-20">
        <div class="container">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="py-6 px-2 sm:px-6 lg:col-span-3 xl:col-span-2 lg:py-0 lg:px-0">
                    <UserNav/>
                </aside>

                <div class="space-y-6 sm:px-6 lg:col-span-9 xl:col-span-10 lg:px-0">
                    <form @submit.prevent=" userForm.post(
                        `${usePage().props.base_url}/api/catalyst-explorer/user`,
                        { preserveScroll: false }
                        )">
                        <div class="sm:overflow-hidden sm:rounded-sm">
                            <div class="space-y-6 bg-white py-6 px-4 sm:p-6">
                                <div>
                                    <h2 class="text-lg xl:text-xl font-medium leading-6 text-slate-900">
                                        Your Lido Nation Account
                                    </h2>
                                    <p class="mt-1 text-sm text-slate-500">
                                        All information, with the exception of your
                                        email, will be displayed publicly.</p>
                                </div>

                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="email" class="block text-sm font-medium text-slate-700">
                                            Name
                                        </label>
                                        <input type="text" name="email" id="email" autocomplete="email"
                                               v-model="userForm.name"
                                               class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                        <div class="text-pink-600" v-if="userForm.errors.name">
                                            {{ userForm.errors.name }}
                                        </div>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="email" class="block text-sm font-medium text-slate-700">
                                            Email Address <span class="text-slate-400">Use for login and communication. Not displayed publicly, not exposed in apis</span>
                                        </label>
                                        <input type="text" name="email" id="email" autocomplete="email"
                                               v-model="userForm.email"
                                               class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                        <div class="text-pink-600" v-if="userForm.errors.email">
                                            {{ userForm.errors.email }}
                                        </div>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="twitter"
                                               class="block text-sm font-medium text-slate-700">Twitter</label>
                                        <input type="text" name="twitter" id="twitter" autocomplete="twitter"
                                               v-model="userForm.twitter"
                                               class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                        <div class="text-pink-600" v-if="userForm.errors.twitter">{{
                                                userForm.errors.twitter
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-slate-50 px-4 py-3 text-right sm:px-6">
                                <button type="submit"
                                        class="inline-flex justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>

                    <form v-for="form in forms" class="mb-16" @submit.prevent="submit($event, form)">
                        <div class="sm:overflow-hidden sm:rounded-sm">
                            <div class="space-y-6 bg-white py-6 px-4 sm:p-6">
                                <input type="hidden" name="id" v-model="form.id"/>

                                <div>
                                    <h2 class="text-lg xl:text-xl font-medium leading-6 text-slate-900">
                                        Edit Catalyst Profile: <span class="font-bold">{{ form.name }}</span>
                                    </h2>
                                    <p class="mt-1 text-sm text-slate-500">
                                        All information, with the exception of your
                                        email, will be displayed publicly.
                                    </p>

                                    <div class="text-pink-600" v-if="form.errors.id">
                                        {{form.errors.id }}
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-6">
                                    <!--                                    <div class="col-span-6 sm:col-span-3">-->
                                    <!--                                        <label for="first-name"-->
                                    <!--                                               class="block text-sm font-medium text-slate-700">Name</label>-->
                                    <!--                                        <input type="text" name="name" id="name" autocomplete="name"-->
                                    <!--                                               v-model="form.name"-->
                                    <!--                                               class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">-->
                                    <!--                                        <div v-if="form.errors.name">{{ form.errors.name }}</div>-->
                                    <!--                                    </div>-->

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="email" class="block text-sm font-medium text-slate-700">Email
                                            address <span class="text-slate-400">(Not displayed publicly, not exposed in apis)</span></label>
                                        <input type="text" name="email" id="email" autocomplete="email"
                                               v-model="form.email"
                                               class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                        <div class="text-pink-600" v-if="form.errors.email">{{
                                                form.errors.email
                                            }}
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="twitter"
                                               class="block text-sm font-medium text-slate-700">Twitter</label>
                                        <input type="text" name="twitter" id="twitter" autocomplete="twitter"
                                               v-model="form.twitter"
                                               class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                        <div class="text-pink-600" v-if="form.errors.twitter">{{
                                                form.errors.twitter
                                            }}
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="linkedin"
                                               class="block text-sm font-medium text-slate-700">LinkedIn</label>
                                        <input type="text" name="linkedin" id="linkedin" autocomplete="linkedin"
                                               v-model="form.linkedin"
                                               class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                        <div class="text-pink-600" v-if="form.errors.linkedin">{{
                                                form.errors.linkedin
                                            }}
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="discord"
                                               class="block text-sm font-medium text-slate-700">Discord</label>
                                        <input type="text" name="discord" id="discord" autocomplete="discord"
                                               v-model="form.discord"
                                               class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                        <div class="text-pink-600" v-if="form.errors.discord">{{
                                                form.errors.discord
                                            }}
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="telegram"
                                               class="block text-sm font-medium text-slate-700">Telegram</label>
                                        <input type="text" name="telegram" id="telegram" autocomplete="telegram"
                                               v-model="form.telegram"
                                               class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                        <div class="text-pink-600" v-if="form.errors.telegram">{{
                                                form.errors.telegram
                                            }}
                                        </div>
                                    </div>

                                    <div class="col-span-3">
                                        <label for="bio" class="block text-sm font-medium text-slate-700">Bio</label>
                                        <div class="mt-1">
                                            <textarea id="bio" name="bio" rows="6" v-model="form.bio"
                                                      class="mt-1 block w-full rounded-sm border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"></textarea>
                                            <div v-if="form.errors.bio">{{ form.errors.bio }}</div>
                                        </div>
                                        <p class="mt-2 text-sm text-slate-500">
                                            Brief description for your profile. Markdown supported
                                        </p>
                                    </div>

                                    <!--                                    <div class="col-span-3">-->
                                    <!--                                        <label class="block text-sm font-medium text-slate-700">Photo</label>-->
                                    <!--                                        <div class="mt-1 flex items-center">-->
                                    <!--                                            <span-->
                                    <!--                                                class="inline-block h-12 w-12 overflow-hidden rounded-full bg-slate-100">-->
                                    <!--                                              <svg class="h-full w-full text-slate-300" fill="currentColor"-->
                                    <!--                                                   viewBox="0 0 24 24">-->
                                    <!--                                                <path-->
                                    <!--                                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/>-->
                                    <!--                                              </svg>-->
                                    <!--                                            </span>-->
                                    <!--                                            <button type="button"-->
                                    <!--                                                    class="ml-5 rounded-sm border border-slate-300 bg-white py-2 px-3 text-sm font-medium leading-4 text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">-->
                                    <!--                                                Change-->
                                    <!--                                            </button>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                </div>
                            </div>

                            <div class="bg-slate-50 px-4 py-3 text-right sm:px-6">
                                <button type="submit"
                                        class="inline-flex justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>

                    <form class="hidden">
                        <div class="shadow sm:overflow-hidden sm:rounded-sm">
                            <div class="space-y-6 bg-white py-6 px-4 sm:p-6">
                                <div>
                                    <h3 class="text-lg font-medium leading-6 text-slate-900">Notification
                                        Preferences</h3>
                                    <p class="mt-1 text-sm text-slate-500">Provide basic information about the job. Be
                                        specific with the job title.</p>
                                </div>

                                <fieldset>
                                    <legend class="text-base font-medium text-slate-900">By Email</legend>
                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex h-5 items-center">
                                                <input id="comments" name="comments" type="checkbox"
                                                       class="h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="comments"
                                                       class="font-medium text-slate-700">Comments</label>
                                                <p class="text-slate-500">Get notified when someones posts a comment on
                                                    a posting.</p>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex items-start">
                                                <div class="flex h-5 items-center">
                                                    <input id="candidates" name="candidates" type="checkbox"
                                                           class="h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="candidates" class="font-medium text-slate-700">Candidates</label>
                                                    <p class="text-slate-500">Get notified when a candidate applies for
                                                        a job.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex items-start">
                                                <div class="flex h-5 items-center">
                                                    <input id="offers" name="offers" type="checkbox"
                                                           class="h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="offers"
                                                           class="font-medium text-slate-700">Offers</label>
                                                    <p class="text-slate-500">Get notified when a candidate accepts or
                                                        rejects an offer.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="mt-6">
                                    <legend class="text-base font-medium text-slate-900">Push Notifications</legend>
                                    <p class="text-sm text-slate-500">These are delivered via SMS to your mobile
                                        phone.</p>
                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-center">
                                            <input id="push-everything" name="push-notifications" type="radio"
                                                   class="h-4 w-4 border-slate-300 text-teal-600 focus:ring-teal-500">
                                            <label for="push-everything" class="ml-3">
                                                <span class="block text-sm font-medium text-slate-700">Everything</span>
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="push-email" name="push-notifications" type="radio"
                                                   class="h-4 w-4 border-slate-300 text-teal-600 focus:ring-teal-500">
                                            <label for="push-email" class="ml-3">
                                                <span
                                                    class="block text-sm font-medium text-slate-700">Same as email</span>
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="push-nothing" name="push-notifications" type="radio"
                                                   class="h-4 w-4 border-slate-300 text-teal-600 focus:ring-teal-500">
                                            <label for="push-nothing" class="ml-3">
                                                <span class="block text-sm font-medium text-slate-700">No push notifications</span>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="bg-slate-50 px-4 py-3 text-right sm:px-6">
                                <button type="submit" @click.prevent="submit"
                                        class="inline-flex justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</template>

<script lang="ts" setup>
import UserNav from "./UserNav.vue";
import {computed, ref} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";
import User from "../../models/user";
import Profile from "../../models/profile";

const user = computed(() => usePage().props?.user as User);

let userForm = useForm({...user.value});

const props = withDefaults(
    defineProps<{
        locale: string,
        profiles: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: Profile[]
        };
    }>(), {});

let forms = ref(
    props.profiles.data?.map((profile) => (useForm({...profile})))
);

let submit = (event, form) => {
    form.post(`${usePage().props.base_url}/catalyst-explorer/my/profiles/${form.id}`,
        {
            preserveScroll: false
        });
}

</script>
