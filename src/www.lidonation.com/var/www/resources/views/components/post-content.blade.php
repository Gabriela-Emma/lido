@props(['post', 'pageLocale'])
<div class="" x-data="translateProposal({{ $post->id }}, '{{ $pageLocale }}','{{class_basename($post->type)}}')">
    @if ($post->content)
        <div x-show="locale === data.sourceLocale">
            <div class="relative w-full bg-white z-10 -top-10 right-2">
                <div x-show="!loggedIn"
                    class="mb-3 absolute rounded-sm px-1 py-0.5 right-1 top-1 text-sm bg-yellow-500 border border-yellow-800 text-pink-600 font-semibold hover:text-teal-800">
                    Help Translate! <a href="/login">login</a>
                </div>
                <button x-show="!editing && loggedIn && langExists" @click="translateContent()"
                    class="px-2 py-1 font-medium w-28 rounded-sm text-white focus:ring-4 focus:outline-none absolute right-1 top-1 text-base z-10
                                    inline-flex justify-center bg-yellow-500 border border-yellow-800 text-pink-600 font-semibold hover:text-teal-80"
                    type="button">
                    Translate
                </button>
            </div>
        </div>
        <div class="pt-4 flex flex-row justify-center w-full" x-show="loggedIn && translate">
            <template x-if="translate && !editing && !translatorsLang" >
                <div class="flex flex-col items-end bg-white shadow-sm border z-10 w-96 rounded-sm p-3">
                    <div class="w-full" >
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
            <div class="flex flex-col justify-center">
                <div class="flex flex-col" x-show="editing">
                    <p class="flex flex-row mb-2">
                        Open English text in another tab.
                        <a class="flex flex-row" href="/proposals/{{ $post->slug }}" target="_blank">
                            Open
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </a>
                    </p>
                    <button @click="submitEdits()"
                        class="p-2 font-medium  rounded-sm text-white bg-teal-600 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-600text-center
                                  inline-flex items-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800"
                        type="button">
                        Save Translation
                    </button>
                    <span class="text-pink-600 text-sm text-bold mt-2 " x-show="failed">Error! Try saving again </span>
                </div>
            </div>
        </div>
    @endif
    <div  class="h-full overflow-clip p-4 break-normal" >
        <div class="flex flex-col items-center">
            <div class="flex rounded-sm items-center w-48 mt-2 bg-green-700 p-1 text-bold" x-show="success">
                    <span class="text-white mr-1">Translation saved</span>
                    <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"
                        id="IconChangeColor" height="20" width="20">
                        <path fill="#FFFFFF" d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm-55.808 536.384-99.52-99.584a38.4 38.4 0 1
                                0-54.336 54.336l126.72 126.72a38.272 38.272 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336L456.192 600.384z"
                            id="mainIconPathAttribute" stroke-width="0"
                            stroke="#FF0000"></path>
                    </svg>
            </div>
            <template x-if="processing === true" class="mt-4">
                <x-theme.spinner square="8" squareXl="8" theme="teal" />
            </template>
            <div x-show="!editing ">
                <article class="mb-6 text-xl text-justify" >
                    <div class="mt-3">
                        @if(Lang::has($post->getTable() . '.' . $post->slug ))
                            <x-markdown>{{__($post->getTable() . '.' . $post->slug)}}</x-markdown>
                        @else
                            <x-markdown>{{$post->content}}</x-markdown>
                        @endif
                    </div>
                </article>
            </div>
        </div>
        <div x-show="editing">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Edit if needed
                and save translation.</label>
            <textarea  x-transition
                class="block p-4 w-full h-[50rem]   text-gray-900 bg-white rounded-md border border-slate-300 focus:ring-teal-500 focus:border-teal-500"
                x-model="modelContent">
            </textarea>
        </div>
    </div>
</div>