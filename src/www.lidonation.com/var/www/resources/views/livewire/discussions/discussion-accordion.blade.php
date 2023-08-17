<div class="leading-relaxed"
     x-data="{writeComment(){this.showCommentForm = true; this.showCategory = true;}, showCategory: @js($expanded), showCommentForm: false, acknowledgedRole: false}">
    <div
        class="p-6 hover:cursor-pointer group flex flex-row flex-wrap items-center justify-around gap-4 sticky top-10 z-20 {{$background}}"
        @click.self="showCategory=!showCategory">
        <div class="mr-auto text-gray-600 group-hover:text-teal-600 min-w-2/5">
            <h2 class="md:text-2xl xl:text-3xl 2xl:text-4xl">
                <span>{{$discussion?->title}}</span>
                @if($editable)
                <a href="#discussion{{$discussion->title}}CommentForm{{$discussion->id}}"
                   class="text-xs font-semibold text-accent-700" @click="writeComment">
                   {{$snippets->leaveAReview}}
                </a>
                @endif
            </h2>
        </div>
        <div  @click="showCategory=!showCategory"
            class="relative flex flex-row items-center pr-3 mt-auto -top-2 gap-x-3 md:text-md md:leading-8 md:gap-x-8">
            <span class="hidden md:w-6 md:h-6"></span>
            <div class="m-0">
                <x-public.stars :amount="$discussion->rating" :size="6"/>
            </div>
            <div class="flex flex-row gap-1 text-xs font-semibold flex-nowrap sm:text-sm 2x:text-base">
                <span>
                    {{$discussion->rating}}
                </span>
                <span>/</span>
                <span>5</span>
            </div>
            <div class="text-xs font-normal sm:text-sm 2xl:text-base">
                <span>{{$discussion->ratings_count}} {{$snippets->reviews}}</span>
            </div>
        </div>

        <div class="absolute top-0 flex flex-row items-center h-full ml-auto space-x-2 right-2 sm:relative"
             @click="showCategory=!showCategory">
            <span>
                <span class="hidden text-xs text-gray-600 sm:inline-block" x-show="!showCategory">
                    {{$snippets->expand}}
                </span>
                <span class="hidden text-xs text-gray-600 sm:inline-block" x-show="showCategory">
                    {{$snippets->collapse}}
                </span>
            </span>
            <span>
                <span class="text-gray-400 group-hover:text-teal-600" x-show="!showCategory">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>
                <span class="text-gray-400 group-hover:text-teal-600" x-show="showCategory">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 15l7-7 7 7"/>
                    </svg>
                </span>
            </span>
        </div>
    </div>

    <div class="p-6" x-show="showCategory" wire:key="{{$discussion->id}}">
        <div>
            <x-markdown>{{$discussion?->content}}</x-markdown>
        </div>

        @if($editable)
        <div class="my-10">
            <h3 class="my-5 space-x-1 decorate dark">
                {{$snippets->leaveAReview}}
            </h3>

            <div
                x-show="!showCommentForm && !acknowledgedRole"
                class="flex flex-row items-center justify-start max-w-xl gap-2 p-2 mx-auto font-semibold text-white bg-teal-600 border rounded-md hover:cursor-pointer hover:bg-primary-600"
                @click="showCommentForm=!showCommentForm">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    {{$snippets->review}} {{$discussion->model->title}}'s {{$discussion->title}}
                </div>
                <div class="ml-auto">
                    <svg x-show="!showCommentForm" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    <svg x-show="showCommentForm" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                </div>
            </div>

            <div class="p-8 mt-8 font-normal text-white bg-teal-600 text-md lg:text-xl"
                 x-show="showCommentForm && !acknowledgedRole">

                 {{$snippets->RatingDiscussionAcknowledgement}}

                <div class="mx-auto text-center">
                    <div
                        class="inline-flex flex-row items-center justify-start max-w-xl gap-2 p-2 mx-auto mt-6 font-semibold text-teal-400 bg-white border rounded-md hover:cursor-pointer hover:bg-primary-600"
                        @click="acknowledgedRole=true">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="text-2xl capitalize">
                            {{$snippets->iAcknowledgeRole}}
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="showCommentForm && acknowledgedRole">
                <div class="pt-4" id="discussion{{$discussion->title}}CommentForm{{$discussion->id}}">
                    <livewire:comment-form-component
                        context="review"
                        :modelId="$discussion->id"
                        :model="$discussion"
                        :modelType="'App\Models\Discussion'"
                        :prompt="$discussion->comment_prompt ?? 'What is ' . $discussion->model->title . ' ' . $discussion->title . '?'"/>
                </div>
            </div>
        </div>
        @endif

        @if($discussion->community_reviews?->count() > 0)
            <div class="mt-6">
                {{-- <h3 class="mb-4 space-x-1 decorate dark">
                    <span class="capitalize">
                        {{$snippets->communityReviews}}
                    </span>
                    <span>({{$discussion->community_reviews->count()}})</span>
                </h3> --}}

                <livewire:discussions.reviews-component :editable="false" :discussion="$discussion" :reviews="$discussion->community_reviews" />

{{--                <x-public.reviews :reviews="$discussion->community_reviews" :discussion="$discussion"></x-public.reviews>--}}
            </div>
        @endif
    </div>
</div>
