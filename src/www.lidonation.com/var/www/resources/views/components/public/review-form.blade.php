@props([
    'parentId' => null,
    'model',
    'modelType',
    'modelId',
    'prompt'
])
<div class="rounded-sm border" id="commentForm{{$modelId}}">
    @if($errors->isNotEmpty())
        <x-global.errors :errors="$errors"></x-global.errors>
    @endif

    @if(!$this->replySubmitted)
        <section class="relative">
            <form class="px-4 pt-2 w-full bg-white" wire:submit.prevent>
                <div wire:loading wire:target="submitReview,writeReview" class="absolute top-0 left-0 ml-0 w-full h-full bg-white bg-opacity-75">
                    <div class="flex justify-center items-center w-full h-full text-teal-700">
                        <svg class="mr-3 w-8 h-8 rounded-full border-t-2 border-b-2 animate-spin border-primary-600" viewBox="0 0 24 24">
                            <circle class="opacity-50" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                            <path class="opacity-100" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ $this->writing ? $snippets->saving : $snippets->confirmingYourHumanity }}
                    </div>
                </div>

                @csrf

                <x-honeypot/>

                <div class="mb-6">
                    @if(!$this->writing)
                        <div x-data
                             class="flex absolute justify-center items-center w-full h-full bg-white bg-opacity-80 cursor-pointer hover:text-teal-600"
                             wire:click="writeReview">
                            <p class="text-2xl font-semibold" wire:loading.remove>
                                {{ $snippets->writeComment }}
                            </p>
                        </div>
                    @endif
                    <div class="flex max-w-3xl">
                        <h2 class="pt-3 pb-2">
                            {{$prompt ?? $snippets->leaveAComment }}
                        </h2>
                        <div>

                        </div>
                    </div>

                    <div>
                        <div class="my-4">
                            <div class="sm:col-span-3">
                                <label for="name{{$modelId}}" class="block text-sm font-medium text-gray-700">
                                    {{ $snippets->name }}
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name{{$modelId}}" value="{{ old('name') }}"
                                           wire:model.defer="name"
                                           class="block px-3 w-full rounded-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm focus:outline-none focus:ring-1 focus:ring-offset-primary-400">
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
                                           class="block px-3 w-full rounded-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm focus:outline-none focus:ring-1 focus:ring-offset-primary-400">
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="sm:col-span-3">
                                <label for="title" class="block text-sm font-medium text-gray-700">
                                    {{ $snippets->commentTitle }}
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                                           wire:model.defer="title"
                                           class="block px-3 w-full rounded-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-offset-primary-400">
                                </div>
                            </div>
                        </div>
                        <div class="my-2 w-full md:w-full">
                            <label>
                        <textarea value="{{ old('comments') }}" wire:model.defer="comments"
                                  class="px-2 px-3 py-2 w-full h-60 font-medium leading-normal placeholder-gray-700 bg-gray-100 rounded border border-gray-300 resize-none focus:ring-1 focus:ring-primary-500 focus:ring-offset-primary-400 focus:outline-none focus:bg-white"
                                  name="comments" placeholder='{{ $snippets->typeYourComment }}*'
                                  required></textarea>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
            <div class="px-4 mb-4">
                <button type="button" wire:click="submitReview" wire:loading.attr="disabled"
                        class="flex items-center px-8 py-4 text-lg font-medium text-white rounded-sm btn btn-primary bg-teal-600 hover:bg-primary-700">
                        {{ $snippets->postComment }}
                </button>
            </div>
        </section>
    @endif
</div>


