<template>
    <div class="overflow-hidden bg-white sm:rounded-sm">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg xl:text-xl font-medium leading-6 text-slate-900">
                    {{ group.name }}
                </h3>
                <div class="flex gap-4 text-slate-400">
                    <div class="flex gap-1 ">
                        <div>Total Proposals</div>
                        <div class="font-semibold">-</div>
                    </div>
                    <div class="flex gap-1">
                        <div>Total Awarded</div>
                        <div class="font-semibold">-</div>
                    </div>
                    <div class="flex gap-1">
                        <div>Total Received</div>
                        <div class="font-semibold">-</div>
                    </div>
                    <div class="flex gap-1">
                        <div>Funding Remaining</div>
                        <div class="font-semibold">-</div>
                    </div>
                </div>
            </div>
            <div>
                <button type="button" @click.prevent="editing = !editing"
                        class="inline-flex items-center rounded-sm border border-slate-300 bg-white px-2.5 py-1.5 text-md font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    <span v-if="!editing">Edit</span>
                    <span v-if="!!editing">Cancel</span>
                </button>
            </div>
        </div>
        <form class="border-t border-slate-200 px-4 py-5 sm:px-6" @submit.prevent="submit">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <dt class="text-md font-medium text-slate-500">
                        <label for="bio" class="block text-sm font-medium text-slate-700">
                            About
                        </label>
                    </dt>
                    <dd class="mt-1 text-md text-slate-900">
                        <div v-if="!editing">
                            {{ group.bio }}
                        </div>
                        <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                            <textarea id="bio" name="bio" rows="6" v-model="groupForm.bio"
                                      class="mt-1 block w-full rounded-sm border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"></textarea>

                            <div class="text-pink-600" v-if="groupForm.errors.bio">
                                {{ groupForm.errors.bio }}
                            </div>
                        </div>
                    </dd>
                </div>

                <div class="flex gap-8 sm:col-span-2 w-full relative">
                    <div class="absolute block left-3 -top-1.5 bg-white rounded-sm text-xs px-2">
                        Group Details
                    </div>
                    <div class="border divide-x space-x-8 flex gap-4 p-2 sm:col-span-2 w-full">
                        <div class="flex flex-col flex-1 justify-center p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="name" class="block text-sm font-medium text-slate-700">
                                    Group Name
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span v-if="!editing">{{ group.name }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="name" id="name" autocomplete="name"
                                           v-model="groupForm.name"
                                           class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.name">
                                        {{ groupForm.errors.name }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                Admin
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                {{ group?.owner?.name }}
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="website" class="block text-sm font-medium text-slate-700">
                                    Website
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span v-if="!editing">{{ group.website }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="website" id="website" autocomplete="website"
                                           v-model="groupForm.website"
                                           class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.website">
                                        {{ groupForm.errors.website }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>

                <div class="flex gap-8 sm:col-span-2 w-full relative">
                    <div class="absolute block left-3 -top-1.5 bg-white rounded-sm text-xs px-2">
                        Community & Support Links
                    </div>
                    <div class="border divide-x space-x-8 flex gap-8 p-2 sm:col-span-2 w-full">
                        <div class="flex flex-col flex-1 justify-center p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="twitter" class="block text-sm font-medium text-slate-700">
                                    twitter
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span v-if="!editing">{{ group.twitter || '-' }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="twitter" id="twitter" autocomplete="twitter"
                                           v-model="groupForm.twitter"
                                           class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.twitter">
                                        {{ groupForm.errors.twitter }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-8">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="discord" class="block text-sm font-medium text-slate-700">
                                    discord
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span v-if="!editing">{{ group.discord || '-' }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="discord" id="discord" autocomplete="discord"
                                           v-model="groupForm.discord"
                                           class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.discord">
                                        {{ groupForm.errors.discord }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-8">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="github" class="block text-sm font-medium text-slate-700">
                                    github org
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span v-if="!editing">{{ group.github || '-' }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="github" id="github" autocomplete="github"
                                           v-model="groupForm.github"
                                           class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.github">
                                        {{ groupForm.errors.github }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
            </dl>


                <div class="flex gap-8 sm:col-span-2 w-full relative mt-8 border border-slate-200 p-4">
                    <div class="w-full" >
                        <div class="absolute block left-3 -top-1.5 bg-white rounded-sm text-xs px-2">
                            The Team
                        </div>
                        <div class="flex flex-col  justify-between">
                            <div class="mb-4 w-full justify-end">
                                <div class="flex flex-row items-center justify-end">
                                    <div class="w-80" v-if="saveButton">
                                        <PersonPicker :class="{'border rounded-lg bg-white shadow':true}"  v-model="selectedProfile" :key="resetPersonPicker"/>
                                    </div>
                                    <div class="flex flex-row items-center w-48 justify-end flex-shrink-0">
                                        <button v-if="saveButton"
                                                @click.prevent="addMember"
                                                class="inline-flex justify-center shrink-0 ml-6 rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium
                                                    text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                            <span class="flex items-center justify-between ">
                                              Save
                                            </span>
                                        </button>
                                        <button v-if="!saveButton"
                                                @click.prevent="saveButton = !saveButton"
                                                class="inline-flex justify-center shrink-0 rounded-sm border border-teal-600  py-2 px-4 text-sm font-medium
                                                text-teal-600 shadow-sm  focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                            <span class="flex items-center justify-between ">
                                                <PlusIcon class="w-5 h-5 mr-2 -ml-1 text-teal-600" aria-hidden="true"/>
                                                Add Profile(s)
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                    <li v-for="member in members" :key="member.id"
                                        class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow">
                                        <div class="flex w-full items-center justify-between space-x-6 p-6">
                                            <div class="flex-1 truncate">
                                                <div class="flex items-center space-x-3">
                                                    <h3 class="truncate text-sm font-medium text-gray-900">{{ member.name }}</h3>
                                                    <span class="inline-block flex-shrink-0 rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">
                                                        {{member.role}}
                                                    </span>
                                                </div>
                                                <p class="mt-1 truncate text-sm text-gray-500">{{member.title}}</p>
                                                <TrashIcon @click.prevent="removeMember(member.id)" 
                                                        class="h-5 w-5 hover:text-gray-600 text-gray-400"/>
                                            </div>
                                                <img class="h-10 w-10 flex-shrink-0 rounded-full bg-gray-300" :src="member.profile_photo"
                                                        alt=""/>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="flex w-0 flex-1">
                                                    <a :href="`mailto:${member.email}`"
                                                        class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500">
                                                        <EnvelopeIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                                                        <span class="ml-3">Email</span>
                                                    </a>
                                                </div>
                                                <div class="-ml-px flex w-0 flex-1">
                                                    <a :href="member.discord"
                                                        target="_blank"
                                                        class="relative inline-flex w-0 flex-1 items-center justify-center rounded-br-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500">
                                                        <svg role="img" viewBox="0 0 24 24" stroke="currentColor"
                                                                class="h-5 w-5 fill-current text-gray-400 " fill="gray">
                                                            <path
                                                                d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.9555 2.4189-2.1569 2.4189zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.946 2.4189-2.1568 2.4189Z"/>
                                                        </svg>
                                                        <span class="ml-3 text-gray-700">Discord</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>  
                </div>
          


                <div class="group-proposals-wrapper p-4 bg-slate-50 mt-8">
                <div>
                    <div class="flex flex-row justify-between">
                        <div class="">
                            <h3>{{ group.name }} Proposals <span> - more coming soon</span></h3>
                        </div>
                        <div class="flex flex-row justify-between w-1/2">
                            <div class="flex flex-row items-center w-1/3">
                                <button v-if="selectedRef.length>0"
                                        @click.prevent="addProposal()"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-sm shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                    <span class="flex items-center justify-between ">
                                        <PlusIcon class="w-5 h-5 mr-2 -ml-1" aria-hidden="true"/>
                                        Add Proposal(s)
                                    </span>
                                </button>
                            </div>
                            <div class="inline-flex w-2/3 shadow-slate-300">
                                    <ProposalPicker v-model="selectedRef" :class="{'border rounded-lg bg-white shadow':true}" :key="reset" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="typo__label">Tagging</label>
                    </div>

                    <div>
                        <div class="overflow-hidden bg-white shadow sm:rounded-md">
                            <ul role="list" class="divide-y divide-gray-200">
                                <template v-for="proposal in initProposals">
                                    <li :key="proposal.id" v-if="proposal">
                                        <a href="#" class="block hover:bg-gray-50">
                                            <div class="flex items-center px-4 py-4 sm:px-6">
                                                <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                                    <div class="truncate">
                                                        <div class="flex text-sm">
                                                            <p class="truncate font-medium text-teal-600">
                                                                {{proposal.title }}
                                                            </p>
                                                            <!--                                                        <p class="ml-1 flex-shrink-0 font-normal text-gray-500">in {{ position.department }}</p>-->
                                                        </div>
                                                        <TrashIcon @click.prevent="removeProposal(proposal.id)" 
                                                             class="w-5 h-5 text-gray-500  hover:text-gray-700" aria-hidden="true"/>
                                                        <div class="mt-2 flex">
                                                            <div class="flex items-center text-sm text-gray-500">
                                                                <CalendarIcon
                                                                    class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400"
                                                                    aria-hidden="true"/>
                                                                <p>
                                                                    {{ proposal.fund?.label }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                                                        <div class="flex -space-x-1 overflow-hidden">
                                                            <img v-for="user in proposal.users" :key="user.id"
                                                                 class="inline-block h-6 w-6 rounded-full ring-2 ring-white"
                                                                 :src="user.profile_photo_url" :alt="user.name"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ml-5 flex-shrink-0">
                                                    <ChevronRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-4 py-3 text-right sm:px-6 mt-8 -mx-6 -mb-6">
                <button type="submit"
                        class="inline-flex justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    {{ group.id ? 'Save' : 'Create' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script lang="ts" setup>
import Group from '../../models/group';
import {EnvelopeIcon} from '@heroicons/vue/20/solid';
import {useForm, usePage} from "@inertiajs/vue3";
import {Ref, ref} from "vue";
import axios from "axios";
import {CalendarIcon, ChevronRightIcon, PlusIcon,TrashIcon} from '@heroicons/vue/20/solid'
import Proposal from "../../models/proposal";
import Profile from '../../models/profile';
import PersonPicker from "../../modules/people/PersonPicker.vue"
import ProposalPicker from '../../modules/proposals/ProposalPicker.vue';

let initProposals: Ref<Proposal[]> = ref([]);
let members: Ref<Profile[]> = ref([])
const props = withDefaults(
    defineProps<{
        group: Group;
    }>(),
    {
        group: () => {
            return {} as Group;
        }
    }
);


// const people = [
//     {
//         name: 'Jane Cooper',
//         title: 'Regional Paradigm Technician',
//         role: 'Admin',
//         email: 'janecooper@example.com',
//         telephone: '+1-202-555-0170',
//         imageUrl:
//             'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
//     }
// ]

axios.get(`${usePage().props.base_url}/catalyst-explorer/my/groups/${props.group?.id}/proposals`)
    .then((response) => {
        initProposals.value = [...response?.data?.data];
    })
    .catch((error) => {
        console.error(error);
    });

axios.get(`${usePage().props.base_url}/catalyst-explorer/my/groups/${props.group?.id}/members`)
.then((response) => {
    members.value =[...response?.data?.data];
})
.catch((error) => {
    console.error(error);
});


let groupForm = useForm({...props.group});
let editing = ref(!props?.group?.name || false);

let submit = () => {
    let url;
    if (props.group?.id) {
        url = `${usePage().props.base_url}/catalyst-explorer/my/groups/${props.group.id}`;
    } else {
        url = `${usePage().props.base_url}/catalyst-explorer/my/groups`;
    }
    groupForm.post(url,
        {
            preserveScroll: false,
            preserveState: false,
            onSuccess: () => editing.value = false
        });
}
// removing proposal from the group
let showRemove = ref(false);

let removeProposal = (id:number) =>
 {   const proposalId= id; 

    axios.delete(`${usePage().props.base_url}/catalyst-explorer/my/groups/${props.group.id}/proposals/${proposalId}`,{method:'DELETE'}) // return the actual list
    .then((res) => {
        initProposals.value = [...res?.data?.data];
    })
    .catch(error => {
      console.error(error);
    });

}

// adding new proposals to the group
let selectedRef :Ref<number[]> = ref([]);
let reset = ref(0)
let addProposal = () => {

   const proposalsId = [...selectedRef.value]; 

  axios.post(`${usePage().props.base_url}/catalyst-explorer/my/groups/${props.group.id}/add`, { proposals_id: proposalsId })
  .then((res) => {
        initProposals.value = [...res?.data?.data];
        selectedRef.value = [];
        reset.value += 1;
    })
    .catch(error => {
      console.error(error);
    });
}

// remove members
let removeMember = (id:number) =>
 {  
    const profile_id =[id];

    axios.delete(`${usePage().props.base_url}/catalyst-explorer/my/groups/${props.group.id}/remove/profiles/${profile_id}`,{method:'DELETE'})
    .then((res) =>{
        members.value = [...res?.data?.data];
    })
    .catch((error) => {
        console.error(error);
    }); 
}

// add member
let selectedProfile: Ref<number[]> = ref([])
let saveButton = ref(false)
let resetPersonPicker = ref(0)
let addMember = () =>
{   
    axios.post(`${usePage().props.base_url}/catalyst-explorer/my/groups/${props.group.id}/add/members`,{profileIDs:[...selectedProfile.value]})
    .then((res) =>{
        members.value = [...res?.data?.data];
        reset.value += 1;
        selectedProfile.value = []
        saveButton.value = !saveButton
    })
    .catch((error) => {
        console.error(error);
    });
}
</script>
