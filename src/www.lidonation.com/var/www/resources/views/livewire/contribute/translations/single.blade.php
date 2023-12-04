<div>
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <div class='relative flex flex-row items-end justify-start gap-3 font-black text-teal-600 -bottom-6'>
                <div>
                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor"
                         viewBox="0 0 48 48"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0zm12 6a4 4 0 11-8 0 4 4 0 018 0zm-28 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div>
                    <span class='font-light'>{{__('Contribute') }}</span> <span>{{__('Translation') }}</span>
                </div>
            </div>
        </x-slot>
        @isset($this->translatingTo)
            <p class="mt-1">
                translating to {{$this->translatingTo}}</span>
            </p>
        @endisset
    </x-public.page-header>

    @foreach($this->translations as $translation)
        <section class="relative py-16 {{$loop->even ? 'bg-primary-10' : 'bg-white'}}"
                 wire:key="{{ $loop->index }}"
                 x-data="translator({{$translation?->id}})">
            <div class="container">
                <div class="flex flex-row items-center justify-between">
                    <h1 class="text-gray-500">{{$translation->title}}</h1>
                    <button type="button"
                            wire:click="preTranslate({{$translation?->id}})"
                            x-transition
                            class="flex items-center gap-2 px-3 py-2 m-0 mr-auto text-xs font-medium text-white border border-transparent rounded-sm shadow-xs xl:text-sm bg-teal-600 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Generate Draft Translation
                    </button>
                </div>

                <div>
                    <div
                class="flex flex-col justify-center py-1 mb-4 border-t-4 bg-gray-50 sm:px-3 lg:px-4 w-[40%]">
                <div class="p-1" x-data="{expanded: true}">
                    <div class="mb-1">
                        <div class="flex justify-between">
                            <h2 class="flex flex-row items-end gap-3">
                                <span>Context</span>
                            </h2>
                            <div class="p-2 text-gray-400 hover:cursor-pointer hover:text-teal-600"
                                 @click="expanded = !expanded">
                                <svg x-transition x-show="expanded" xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7"/>
                                </svg>
                                <svg x-transition x-show="!expanded" xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div x-show="expanded" x-transition
                             class="max-h-[44rem] overflow-y-auto flex flex-col gap-6">
                            <div class="bg-white p-3">
                                <h3 class="mb-4">Original {{Str::title(Str::replace('_', ' ', $translation->source_field))}}:</h3>
                                {!! nl2br($translation?->source_content) !!}
                            </div>

                            @if(!$translation->source->link && $translation->source?->media->isNotEmpty())
                                <div class="bg-gray-800 p-4">
                                    <h3 class="text-gray-50">Preview</h3>
                                    <img class="embed-responsive object-cover"
                                         src="{{$translation->source?->media?->first()?->getUrl('thumbnail')}}"
                                         alt="{{$translation->source?->media?->first()?->name}}"/>
                                </div>
                            @endif

                            @if($translation->source?->preview_url || $translation->source?->link)
                                <div class="bg-teal-500 p-2">
                                    <a target="_blank"
                                       href="{{$translation->source?->preview_url ?? $translation->source?->link}}"
                                       class="relative flex items-center justify-center h-full gap-1 text-xl text-white hover:text-yellow-500">
                                        <span class="font-semibold">View Related Content</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="relative w-6 h-6"
                                             viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                                            <path
                                                d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                </div>
                </div>



                @isset($translation)
                    <div class="flex flex-row flex-no-wrap items-start gap-5 overflow-x-auto" wire:ignore>
                        <div class="flex flex-col justify-center mb-4 w-[60%] relative">
                            <div>

                                    <textarea x-ref="editor-{{$translation?->id}}" wire:model.lazy="translations.{{$loop->index}}.content" class="h-[400px]">
                                        {{$translation->content}}
                                    </textarea>

                                <div class="flex items-center justify-start gap-2">
                                    <button type="button"
                                            wire:click="saveDraft({{$translation?->id}})"
                                            x-transition
                                            class="flex items-center gap-2 px-3 py-2 m-0 text-xs font-medium text-white bg-gray-400 border border-transparent rounded-sm shadow-xs xl:text-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        Save Draft
                                    </button>
                                    <button type="button"
                                            wire:click="translate({{$translation?->id}})"
                                            x-transition
                                            class="flex items-center gap-2 px-3 py-2 m-0 mr-auto text-xs font-medium text-white border border-transparent rounded-sm shadow-xs xl:text-sm bg-teal-600 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        Publish
                                    </button>

                                    <a href="#" type="button"
                                       x-transition
                                       class="px-3 py-2 m-0 text-xs font-medium text-white bg-gray-400 border border-transparent rounded-sm shadow-xs xl:text-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                        Close
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div>
                            {{$translation->content}}
                        </div>
                        </div>
                    </div>
                @endisset
            </div>
        </section>
    @endforeach
</div>
