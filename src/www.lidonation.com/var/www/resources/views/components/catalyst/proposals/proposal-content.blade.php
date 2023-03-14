@props([
    'proposal',
])

<div x-data="translateProposal">
    <div x-data="{heightClass: 'max-h-[50rem] overflow-clip', funded: @js($proposal->funded)}"
        class="relative p-4 border border-slate-300 rounded-sm break-normal">
    <div class="">
        <div class=" text-white p-3 border mb-3 rounded-sm shadow-sm" >
            <div>
                <div class="flex flex-row h-10">
                    <button x-show = "!translate" @click = "translate = !translate" class="p-2 font-medium text-sm rounded-md mr-3 text-white  bg-teal-600 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-600text-center
                                inline-flex items-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800"
                            type="button">
                        Translate
                    </button>

                    <template x-if = "translate" >
                        <button  @click="openDropdown = !openDropdown"
                                class="p-2 font-medium text-sm rounded-md mr-3 text-white  bg-teal-600 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-600 
                                    text-center inline-flex items-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800"
                                type="button">Choose target language
                                <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                        </button>

                        <div  class=" w-48 absolute z-10 bg-white rounded-lg shadow dark:bg-gray-700 mt-2" x-show="openDropdown" >
                            <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200">
                            <li>
                                <div class="flex items-center  p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input  type="checkbox"
                                        value="" 
                                        class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-700
                                            dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="checkbox-item-4" 
                                        class="w-full ml-2 text-sm font-medium  text-gray-900 rounded dark:text-gray-300">
                                        Default checkbox
                                </label>
                                </div>
                            </li>
                            </ul>
                        </div>

                        <button x-show = "startTranslation" @click = "getTranslation" class="p-2 font-medium text-sm rounded-md mr-3 text-white  bg-teal-600 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-600text-center
                                    inline-flex items-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800"
                                type="button">
                            Start Translation
                        </button>

                    </template>
                </div>
            </div>
        </div>
        <div>
            <article class="" :class="heightClass" x-transition>
                @if($proposal->content)
                    <x-markdown>{{$proposal->content}}</x-markdown>
                @endif

                @if($proposal->definition_of_success)
                    <h2>Definition of Success</h2>
                    <x-markdown>{{$proposal->definition_of_success}}</x-markdown>
                @endif
            </article>
        </div>
    </div>

    <div @click="heightClass = ''" x-show="heightClass"
            class="absolute w-full p-4 text-center bg-white/95 hover:cursor-pointer group bottom-4">
        <span class="font-bold text-teal-600 group-hover:text-slate-600">
            Expand
        </span>
    </div>
    </div>
</div>

<script>

function translateProposal()
{
    return {
        translate:false,
        toggle:true,
        edit:false,
        openDropdown:false,
        startTranslation:false
        translatedContent:[],


    }
};

</script>