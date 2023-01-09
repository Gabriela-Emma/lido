<x-modal formAction="saveIdea">
    <x-slot name="title">
        Submit Content Idea!
    </x-slot>

    <x-slot name="content">
        <div class="min-h-[50vh]" x-data="{
            tab: 'new',
            upvoteIdea: function() {
                this.tab = 'vote';
                Livewire.emit('upvoteIdea');
            },
            submitIdea: function() {
                this.tab = 'new';
                Livewire.emit('submitIdea');
            }
        }">
            <div class="border-b border-gray-300 px-6">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
                    <a href="#"
                       :class="{
                                'border-primary-500 text-teal-600 border-b-2': tab === 'new',
                                'text-gray-500 hover:text-gray-700 hover:border-gray-300 ': tab !== 'new'
                            }"
                       @click="submitIdea"
                       class=" whitespace-nowrap flex py-4 px-1 font-medium text-sm"
                       aria-current="page">
                        Submit New Idea
                    </a>

                    <a href="#"
                       @click="upvoteIdea"
                       :class="{
                                'border-primary-500 text-teal-600 border-b-2': tab === 'vote',
                                'text-gray-500 hover:text-gray-700 hover:border-gray-300 ': tab !== 'vote'
                            }"
                       class="border-transparent whitespace-nowrap flex py-4 px-1 font-medium text-sm">
                        Upvote Existing Idea
                        <span
                            class="bg-primary-50 text-teal-700 ml-3 py-0.5 px-2.5 rounded-full text-xs font-semibold">
                                    {{$posts->count()}}
                                </span>
                    </a>
                </nav>
            </div>

            <section class="relative p-6 bg-gray-50">
                <div x-transition x-show="tab=='new'">
                    @if($ideaSubmitted)
                        <div class="bg-white">
                            <div class="py-16 sm:py-24">
                                <div class="text-center">
                                    <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Idea
                                        Submitted</h2>
                                    <p class="mt-1 text-3xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                                        Thank you so much!
                                    </p>
                                    <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">
                                        If you submitted your email, you'll get notified when your idea is
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
                                        Your Name
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
                                        Your Email
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
                                    <label for="title" class="block text-sm font-medium text-gray-700">
                                        Content Idea (Title) *
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
                                    <label for="idea" class="block text-sm font-medium text-gray-700">
                                        Notes *
                                    </label>
                                    <div class="my-1">
                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea id="idea" name="idea" wire:model.defer="idea" rows="5"
                                              class="shadow-sm block w-full focus:ring-primary-500 focus:border-primary-500 sm:text-sm border border-gray-300 rounded-sm"></textarea>
                                            <p class="mt-2 text-sm text-gray-500">Write a few sentences about your
                                                idea?</p>
                                        </div>
                                    </div>
                                    @error('idea')
                                    <div class="error-message">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="">
                                <div class="sm:col-span-3">
                                    <label for="links" class="block text-sm font-medium text-gray-700">
                                        Links
                                    </label>
                                    <div class="mt-1">
                                        <div class="my-1 sm:mt-0 sm:col-span-2">
                                    <textarea id="links" name="links" wire:model.defer="links" rows="3"
                                              class="shadow-sm block w-full focus:ring-primary-500 focus:border-primary-500 sm:text-sm border border-gray-300 rounded-sm"></textarea>
                                            <p class="mt-2 text-sm text-gray-500">Any relevant links?</p>
                                        </div>
                                        @error('links')
                                        <div class="error-message">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div wire:loading wire:target="saveIdea"
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

                <div class="relative z-50" x-show="tab=='vote'" x-transition>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">
                        Ideas being developed! Upvote to prioritize ideas you want to see sooner!
                    </h3>
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 z-50">
                        @foreach($posts as $idea)
                            <livewire:contribute-content.idea :postId="$idea->id" :votes="$idea->votes"
                                                              :wire:key="$idea->id"/>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </x-slot>

    <x-slot name="buttons">
        @if($this->submittingIdea)
            <button type="submit"
                    x-transition
                    class="h-10 px-4 py-2 border border-transparent m-0 text-sm font-medium rounded-sm shadow-xs text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Submit
            </button>
        @endif
        <button type="button"
                x-transition
                onclick='Livewire.emit("closeModal", "contribute-content.contribute-idea")'
                class="h-10 px-4 py-2 relative top-1 border border-transparent m-0 text-sm font-medium rounded-sm shadow-xs text-white bg-gray-400 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            Close
        </button>
    </x-slot>
</x-modal>
