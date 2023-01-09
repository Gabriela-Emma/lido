<x-modal formAction="saveArticle">
    <x-slot name="title">
        Submit an Article!
    </x-slot>

    <x-slot name="content">
        <div class="min-h-[60vh]" x-data="{
            tab: 'new',
            submitArticle: function() {
                this.tab = 'new';
                Livewire.emit('submitArticle');
            }
        }">
            <section class="relative">
                <div class="bg-gray-50 relative p-6 z-50">
                    <div x-transition x-show="tab=='new'">
                        @if($articleSubmitted)
                            <div class="bg-white">
                                <div class="mx-auto py-16 sm:py-24">
                                    <div class="text-center">
                                        <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">
                                            Article
                                            Submitted</h2>
                                        <p class="mt-1 text-3xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                                            Thank you so much!
                                        </p>
                                        <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">
                                            If you submitted your email, you'll get notified when your article is
                                            published!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="relative flex flex-col gap-6">
                                <div class="">
                                    <div class="sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">
                                            Your Name *
                                        </label>
                                        <div class="mt-1">
                                            <input type="text" name="name" id="name" wire:model.defer="name"
                                                   class="px-3 border focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:ring-offset-primary-400">
                                        </div>
                                        @error('name')
                                        <div class="error-message">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="">
                                    <div class="sm:col-span-3">
                                        <label for="email" class="block text-sm font-medium text-gray-700">
                                            Your Email *
                                        </label>
                                        <div class="mt-1">
                                            <input type="email" name="email" id="email" wire:model.defer="email"
                                                   class="px-3 border focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:ring-offset-primary-400">
                                        </div>
                                        @error('email')
                                        <div class="error-message">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="">
                                    <div class="sm:col-span-3">
                                        <label for="link" class="block text-sm font-medium text-gray-700">
                                            Content Link (Google Doc) *
                                        </label>
                                        <div class="my-1">
                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <input type="text" name="link" id="link" wire:model.defer="link"
                                                       class="px-3 border focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:ring-offset-primary-400">
                                                <p class="mt-2 text-sm text-gray-500">
                                                    Paste link to google docs.
                                                </p>
                                            </div>
                                        </div>
                                        @error('link')
                                        <div class="error-message">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="">
                                    <div class="sm:col-span-3">
                                        <label for="title" class="block text-sm font-medium text-gray-700">
                                            Article Title
                                        </label>
                                        <div class="my-1">
                                            <input type="text" name="title" id="title" wire:model.defer="title"
                                                   class="px-3 border focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:ring-offset-primary-400">
                                        </div>
                                        @error('title')
                                        <div class="error-message">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="">
                                    <div class="sm:col-span-3">
                                        <label for="comment_prompt" class="block text-sm font-medium text-gray-700">
                                            Comment Prompt
                                        </label>
                                        <div class="my-1">
                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <textarea id="comment_prompt" name="comment_prompt"
                                                  wire:model.defer="comment_prompt" rows="3"
                                                  class="shadow-sm block w-full focus:ring-primary-500 focus:border-primary-500 sm:text-sm border border-gray-300 rounded-sm"></textarea>
                                                <p class="mt-2 text-sm text-gray-500">
                                                    Questions(s) to help guide conversation in comments.
                                                    Will be posted before the comments when article is published.
                                                </p>
                                            </div>
                                        </div>
                                        @error('comment_prompt')
                                        <div class="error-message">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="">
                                    <div class="sm:col-span-3">
                                        <label for="social_excerpt" class="block text-sm font-medium text-gray-700">
                                            Social Post
                                        </label>
                                        <div class="my-1">
                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <textarea id="social_excerpt" name="social_excerpt"
                                                  wire:model.defer="social_excerpt" rows="3"
                                                  class="shadow-sm block w-full focus:ring-primary-500 focus:border-primary-500 sm:text-sm border border-gray-300 rounded-sm"></textarea>
                                                <p class="mt-2 text-sm text-gray-500">
                                                    Will be used to share post on social media.
                                                </p>
                                            </div>
                                        </div>
                                        @error('social_excerpt')
                                        <div class="error-message">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="">
                                    <div class="sm:col-span-3">
                                        <label for="author_comments" class="block text-sm font-medium text-gray-700">
                                            Author Comments
                                        </label>
                                        <div class="my-1">
                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <textarea id="author_comments" name="author_comments"
                                                  wire:model.defer="author_comments" rows="3"
                                                  class="shadow-sm block w-full focus:ring-primary-500 focus:border-primary-500 sm:text-sm border border-gray-300 rounded-sm"></textarea>
                                                <p class="mt-2 text-sm text-gray-500">
                                                    Anything we should know?
                                                </p>
                                            </div>
                                        </div>
                                        @error('author_comments')
                                        <div class="error-message">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div wire:loading wire:target="saveContent"
                                     class="absolute left-0 top-0 ml-0 w-full h-full bg-white opacity-75">
                                    <div
                                        class="w-full h-full  flex justify-center items-center text-teal-700 opacity-100">
                                        <svg class="animate-spin h-8 w-8 mr-3" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                            <path class="opacity-100" fill="currentColor"
                                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </x-slot>

    <x-slot name="buttons">

        <button type="submit"
                x-transition
                class="h-10 px-4 py-2 border border-transparent m-0 text-sm font-medium rounded-sm shadow-xs text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Submit
        </button>

        <button type="button"
                x-transition
                onclick='Livewire.emit("closeModal", "contribute-content.contribute-article")'
                class="h-10 px-4 py-2 relative top-1 border border-transparent m-0 text-sm font-medium rounded-sm shadow-xs text-white bg-gray-400 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            Close
        </button>
    </x-slot>
</x-modal>
