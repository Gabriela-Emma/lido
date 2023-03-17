@props(['proposal'])

<div x-data="translateProposal">
    <span class="mb-3" x-show="!loggedIn">Login <a href="/catalyst-explorer/login"> here</a> to translate</span>
    <div class=" text-white items-center border-t  border-x border-slate-300 w-full bg-white" x-init="getContent({{ json_encode($proposal->content) }})">
        <div class="items-center p-3 " x-show="loggedIn" x-init="getModelID({{ $proposal->id }})" >
            <div class="flex flex-row justify-between  ">
                <div class="flex flex-col  h-12 ">
                    <button x-show="!editing  " @click="translate = !translate"
                        class="p-2 font-medium w-32 rounded-md mr-3 text-white  bg-teal-600 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-600text-center
                                inline-flex mb-3 justify-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800"
                        type="button">
                        Translate
                    </button>

                    <div>
                        <template x-if="translate && !editing" x-init="getLangOptions()">
                            <div
                                class="flex flex-col bg-white shadow-md border z-10 absolute w-96 rounded-md justify-between p-3">
                                <div class=" w-full flex flex-col items-center ">
                                    <select x-model="targetLang"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-md focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500">
                                        <option value="" selected>select target language</option>
                                        <template x-for="option in options" :key="option.value">
                                            <option :value="option.value" x-text="option.name"></option>
                                        </template>
                                    </select>
                                </div>

                                <div x-show="targetLang!=null">
                                    <button @click="getTranslation()"
                                        class="p-2 font-medium rounded-md mr-3 text-white bg-teal-600 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-600text-center inline-flex items-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800"
                                        type="button">
                                        Start Translation
                                    </button>
                                </div>

                            </div>
                        </template>
                    </div>
                </div>



                <div class="" x-show="editing">
                    <button @click="submitEdits()"
                        class="p-2 font-medium  rounded-md mr-3 text-white  bg-teal-600 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-600text-center
                                  inline-flex items-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800"
                        type="button">
                        Save Translation
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div x-data="{ heightClass: 'max-h-[50rem] overflow-clip', funded: @js($proposal->funded) }" :class=" {editing:'h-full'}" class="relative p-4 border border-slate-300 rounded-sm break-normal" x-show="1" >        <div>
            <article :class="heightClass" x-transition x-show="!editing ">
                @if ($proposal->content)
                    <x-markdown x-html="marked.parse(proposalContent)"></x-markdown>
                @endif

                @if ($proposal->definition_of_success)
                    <h2>Definition of Success</h2>
                    <x-markdown>{{ $proposal->definition_of_success }}</x-markdown>
                @endif
            </article>
        </div>

        <template x-if="processing ===true" class="mt-4">
            <x-theme.spinner square="8" squareXl="8" theme="teal" />
        </template>

        <div x-show="editing">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Edit if needed
                and save translation.</label>
            <textarea :class="heightClass" x-transition
                class="block p-4 w-full h-[50rem]   text-gray-900 bg-white rounded-md border border-slate-300 focus:ring-teal-500 focus:border-teal-500"
                x-model="(proposalContent)">          
          </textarea>
        </div>
        <div @click="heightClass = ''" x-show="heightClass"
            class="absolute w-full  p-4 text-center bg-white/95 hover:cursor-pointer group bottom-4">
            <span class="font-bold text-teal-600 group-hover:text-slate-600">
                Expand
            </span>
        </div> 
    </div>
</div>

