@props(['proposal'])

<div class="border border-slate-300 rounded-sm" x-data="translateProposal">

    @if ($proposal->content)
        <div class="relative w-full bg-white z-10"
             x-init="getContent({{ json_encode($proposal->content) }})">
            <div
                class="mb-3 absolute rounded-sm px-1 py-0.5 right-1 top-1 text-sm bg-yellow-500 border border-yellow-800 text-pink-600 font-semibold hover:text-teal-800"
                x-show="!loggedIn">
                Help Translate! <a href="/catalyst-explorer/login">login</a>
            </div>

            <button x-show="!editing && loggedIn" @click="translate = !translate"
                    class="px-2 py-1 font-medium w-28 rounded-sm text-white focus:ring-4 focus:outline-none absolute right-1 top-1 text-base z-10
                                inline-flex justify-center bg-yellow-500 border border-yellow-800 text-pink-600 font-semibold hover:text-teal-80"
                    type="button">
                Translate
            </button>
        </div>

        <div class="pt-4 flex flex-row justify-center w-full" x-show="loggedIn && translate" x-init="getModelID({{ $proposal->id }})">
            <template x-if="translate && !editing" x-init="getLangOptions()">
                <div
                    class="flex flex-col items-end bg-white shadow-sm border z-10 w-96 rounded-sm p-3">
                    <div class="w-full">
                        <select x-model="targetLang"
                                class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-sm focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500">
                            <option value="" selected>select target language</option>
                            <template x-for="option in options" :key="option.value">
                                <option :value="option.value" x-text="option.name"></option>
                            </template>
                        </select>
                    </div>

                    <div x-show="targetLang!=null">
                        <button @click="getTranslation()"
                                class="px-2 py-1 font-medium rounded-sm text-white bg-teal-600 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-600text-center inline-flex items-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800"
                                type="button">
                            Start Translation
                        </button>
                    </div>
                </div>
            </template>

            <div class="" x-show="editing">
                <button @click="submitEdits()"
                        class="p-2 font-medium  rounded-sm text-white bg-teal-600 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-600text-center
                              inline-flex items-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800"
                        type="button">
                    Save Translation
                </button>
            </div>
        </div>
    @endif

    <div x-data="{ heightClass: 'max-h-[50rem] overflow-clip', funded: @js($proposal->funded) }"
         :class=" {editing:'h-full'}" class="relative p-4 break-normal" x-show="1">
        <div>
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
            <x-theme.spinner square="8" squareXl="8" theme="teal"/>
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

