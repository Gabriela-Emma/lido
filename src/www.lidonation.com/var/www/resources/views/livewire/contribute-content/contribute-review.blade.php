<x-modal formAction="saveReview">
    <x-slot name="title">
        Submit an Review
    </x-slot>

    <x-slot name="content">
        <div class="min-h-[40vh]" x-data="{
            tab: 'none',
            submitArticle: function() {
                this.tab = 'new';
                Livewire.emit('submitReview');
            }
        }">
            <section class="relative">
                <div class="relative z-50 p-6 bg-gray-50">
                    <div x-transtion x-show="tab=='none'">
                        <div class="mb-2">
                            {{$snippets->ratingDiscussionIntro}}
                        </div>

                        <div class="my-8">
                            <hr class="my-4 border-gray-320"/>
                        </div>
                    </div>


                    <div class="">
                        <dl class="bg-white rounded-sm shadow-xs sm:grid sm:grid-cols-2">
                            <div
                                @click="tab='template'"
                                class="flex flex-col p-6 text-center border-b border-gray-100 group sm:border-0 sm:border-r hover:cursor-pointer">
                                <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500">
                                    Starting a new Review?
                                </dt>
                                <dd class="order-1 text-4xl font-extrabold text-teal-600 group-hover:text-yellow-500">
                                    <span>Download</span><br/>
                                    <span>Template</span>
                                </dd>
                            </div>
                            <div
                                @click="tab='new'"
                                class="flex flex-col p-6 text-center border-t border-b border-gray-100 group sm:border-0 sm:border-l sm:border-r hover:cursor-pointer">
                                <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500">
                                    Already have a completed template?
                                </dt>
                                <dd class="order-1 text-4xl font-extrabold text-teal-600 group-hover:text-yellow-500">
                                    <span>Submit</span><br/>
                                    <span>Review</span>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div x-transition x-show="tab=='template'">
                        <div class="py-6">
                            <p class="text-2xl">Publishing a review to lidonation happens in a few easy steps!</p>

                            <ol class="flex flex-col gap-2 px-6 py-3 list-decimal">
                                <li>
                                    copy the text from the pdf below into a google doc when you are ready to write
                                    your review.
                                </li>
                                <li>
                                    Fill it out; reach out if you have any questions.
                                </li>
                                <li>
                                    Come back here and fill out the "Submit Review" form with the google doc link
                                </li>
                                <li>
                                    An editor will be assigned to you and will work with you to edit your review via the google doc.
                                </li>
                                <li>
                                    You approve the edits and final review.
                                </li>
                                <li>
                                    Review is scheduled for publication!
                                </li>
                            </ol>
                        </div>
                        <div class="flex flex-col gap-3 py-4 max-w-2xl">
                            <dt class="font-medium text-pink-500 text-md">
                                PDF(s)
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <ul role="list" class="rounded-md border border-gray-300 divide-y divide-gray-300">
                                    <li class="flex justify-between items-center py-3 pr-4 pl-3 text-sm">
                                        <div class="flex flex-1 items-center w-0">
                                            <svg class="flex-shrink-0 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span class="flex-1 ml-2 w-0 truncate">
                                              general-review-template.pdf
                                            </span>
                                        </div>
                                        <div class="flex-shrink-0 ml-4">
                                            <a target="_blank" href="{{asset('files/general-reviews-template.pdf')}}" class="font-medium text-teal-600 hover:text-teal-600">
                                                Download
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </dd>
                        </div>
                    </div>

                    <div class="mt-8" x-transition x-show="tab=='new'">
                        @if($reviewSubmitted)
                            <div class="bg-white">
                                <div class="py-16 mx-auto sm:py-24">
                                    <div class="text-center">
                                        <h2 class="text-base font-semibold tracking-wide uppercase text-teal-600">
                                            Review
                                            Submitted</h2>
                                        <p class="mt-1 text-3xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                                            Thank you so much!
                                        </p>
                                        <p class="mx-auto mt-5 max-w-xl text-xl text-gray-500">
                                            If you submitted your email, you'll get notified when your review is
                                            published!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex relative flex-col gap-6">
                                <div class="">
                                    <div class="sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">
                                            Review Subject *
                                        </label>
                                        <div class="mt-1">
                                            <input type="text" name="title" id="title" wire:model.defer="title"
                                                   class="block px-3 w-full rounded-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm focus:outline-none focus:ring-1 focus:ring-offset-primary-400">
                                        </div>
                                        @error('title')
                                        <div class="error-message">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="">
                                    <div class="sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">
                                            Your Name *
                                        </label>
                                        <div class="mt-1">
                                            <input type="text" name="name" id="name" wire:model.defer="name"
                                                   class="block px-3 w-full rounded-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm focus:outline-none focus:ring-1 focus:ring-offset-primary-400">
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
                                                   class="block px-3 w-full rounded-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm focus:outline-none focus:ring-1 focus:ring-offset-primary-400">
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
                                                       class="block px-3 w-full rounded-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm focus:outline-none focus:ring-1 focus:ring-offset-primary-400">
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
                                        <label for="social_excerpt" class="block text-sm font-medium text-gray-700">
                                            Social Post
                                        </label>
                                        <div class="my-1">
                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <textarea id="social_excerpt" name="social_excerpt"
                                                  wire:model.defer="social_excerpt" rows="3"
                                                  class="block w-full rounded-sm border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"></textarea>
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
                                                  class="block w-full rounded-sm border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"></textarea>
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
                                     class="absolute top-0 left-0 ml-0 w-full h-full bg-white opacity-75">
                                    <div
                                        class="flex justify-center items-center w-full h-full opacity-100 text-teal-700">
                                        <svg class="mr-3 w-8 h-8 animate-spin" viewBox="0 0 24 24">
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
                class="px-4 py-2 m-0 h-10 text-sm font-medium text-white rounded-sm border border-transparent shadow-xs bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Submit
        </button>

        <button type="button"
                x-transition
                onclick='Livewire.emit("closeModal", "contribute-content.contribute-article")'
                class="relative top-1 px-4 py-2 m-0 h-10 text-sm font-medium text-white bg-gray-400 rounded-sm border border-transparent shadow-xs hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            Close
        </button>
    </x-slot>
</x-modal>
