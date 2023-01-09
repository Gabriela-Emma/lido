 <div class="border rounded-sm" id="commentForm{{$modelId}}">
    @if($errors->isNotEmpty())
        <x-public.errors :errors="$errors"></x-public.errors>
    @endif

    @if($this?->comment && !$this->commenting)
        <div class="flex flex-row justify-center p-8">
            <div class="p-4 rounded-md bg-accent-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Heroicon name: solid/check-circle -->
                        <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xl font-medium text-black">
                            {{ $snippets->commentThanksMessage }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(!$this?->comment)
        <section class="relative">
            <form class="w-full px-4 pt-2 bg-white" wire:submit.prevent>
                <div wire:loading wire:target="submitComment,writeComment" class="absolute top-0 left-0 w-full h-full ml-0 bg-white bg-opacity-75">
                    <div class="flex items-center justify-center w-full h-full text-teal-700">
                        <svg class="w-8 h-8 mr-3 animate-spin" viewBox="0 0 24 24">
                            <circle class="opacity-50" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                            <path class="opacity-100" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ $this->commenting ? $snippets->saving : $snippets->confirmingYourHumanity }}
                    </div>
                </div>

                <x-honeypot/>

                <div class="mb-6">
                    @if(!$commenting)
                        <div x-data
                            class="absolute flex items-center justify-center w-full h-full bg-white cursor-pointer bg-opacity-80 hover:text-teal-600"
                            wire:click="writeComment">
                            <p class="text-2xl font-semibold" wire:loading.remove>
                                {{ $snippets->{'write' . Str::title($context)} }}
                            </p>
                        </div>
                    @endif
                    <div class="flex max-w-3xl">
                        <h2 class="pt-3 pb-2">
                            {{$prompt ?? $snippets->{'leaveA'  . Str::title($context)} }}
                        </h2>
                        <div>

                        </div>
                    </div>

                    <div>
                        @if($context === 'review')
                        <div class="my-4">
                            <div class="sm:col-span-3">
                                <div class="flex space-x-1 rating">
                                    <label class="block text-sm font-medium text-gray-400" for="star1{{$modelId}}">
                                        <input class="hidden" wire:model="rating" type="radio" id="star1{{$modelId}}" name="rating" value="1" />
                                        <svg class="cursor-pointer block w-8 h-8 @if($rating >= 1 ) text-teal-600 @else text-grey @endif " fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    </label>
                                    <label class="block text-sm font-medium text-gray-400" for="star2{{$modelId}}">
                                        <input  class="hidden" wire:model="rating" type="radio" id="star2{{$modelId}}" name="rating" value="2" />
                                        <svg class="cursor-pointer block w-8 h-8 @if($rating >= 2 ) text-teal-600 @else text-grey @endif " fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    </label>
                                    <label class="block text-sm font-medium text-gray-400" for="star3{{$modelId}}">
                                        <input  class="hidden" wire:model="rating" type="radio" id="star3{{$modelId}}" name="rating" value="3" />
                                        <svg class="cursor-pointer block w-8 h-8 @if($rating >= 3 ) text-teal-600 @else text-grey @endif " fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    </label>
                                    <label class="block text-sm font-medium text-gray-400" for="star4{{$modelId}}">
                                        <input  class="hidden" wire:model="rating" type="radio" id="star4{{$modelId}}" name="rating" value="4" />
                                        <svg class="cursor-pointer block w-8 h-8 @if($rating >= 4 ) text-teal-600 @else text-grey @endif " fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    </label>
                                    <label class="block text-sm font-medium text-gray-400"for="star5{{$modelId}}">
                                        <input  class="hidden" wire:model="rating" type="radio" id="star5{{$modelId}}" name="rating" value="5" />
                                        <svg class="cursor-pointer block w-8 h-8 @if($rating >= 5 ) text-teal-600 @else text-grey @endif " fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="my-4">
                            <div class="sm:col-span-3">
                                <label for="name{{$modelId}}" class="block text-sm font-medium text-gray-700">
                                    {{ $snippets->Name }}
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name{{$modelId}}" value="{{ old('name') }}"
                                           wire:model.defer="name"
                                           class="block w-full px-3 border border-gray-300 rounded-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm focus:outline-none focus:ring-1 focus:ring-offset-primary-400">
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    {{ $snippets->email }}
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="email" id="email" value="{{ old('email') }}"
                                           wire:model.defer="email"
                                           class="block w-full px-3 border border-gray-300 rounded-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm focus:outline-none focus:ring-1 focus:ring-offset-primary-400">
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="sm:col-span-3">
                                <label for="title" class="block text-sm font-medium text-gray-700">
                                    {{ $snippets->{$context . 'Title'} }}
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                                           wire:model.defer="title"
                                           class="block w-full px-3 border border-gray-300 rounded-sm focus:ring-primary-500 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-offset-primary-400">
                                </div>
                            </div>
                        </div>
                        <div class="w-full my-2 md:w-full">
                            <label>
                        <textarea value="{{ old('comments') }}" wire:model.defer="comments"
                                  class="w-full px-2 px-3 py-2 font-medium leading-normal placeholder-gray-700 bg-gray-100 border border-gray-300 rounded resize-none h-60 focus:ring-1 focus:ring-primary-500 focus:ring-offset-primary-400 focus:outline-none focus:bg-white"
                                  name="comments" placeholder='{{$snippets->{'typeYour' . Str::title($context)} }}*'
                                  required></textarea>
                            </label>
                        </div>
                    </div>
                </div>
                <input type="hidden" wire:model="parent.parentId" value="{{$parentId}}">
            </form>
            <div class="px-4 mb-4">
                <button type="button" wire:click="submitComment" wire:loading.attr="disabled"
                        class="flex items-center px-8 py-4 text-lg font-medium text-white rounded-sm btn btn-primary bg-teal-600 hover:bg-primary-700">
                        {{ $snippets->{'post' . Str::title($context)} }}
                </button>
            </div>
        </section>
    @endif
</div>


