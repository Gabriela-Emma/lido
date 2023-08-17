<div class="flex"  x-data={show:false}>
    <div class="flex-1 px-4 py-2 leading-relaxed border rounded-sm sm:px-6 sm:py-4">
        <h2 class="flex flex-row items-center gap-2">
            <span>
                {{$discussion?->title}}
            </span>
            <x-public.stars :amount="$discussion->rating" />
            <span>
                ({{$discussion?->community_reviews?->count()}})
            </span>
        </h2>

        <x-markdown>{{$discussion?->content}}</x-markdown>

        @if($discussion->community_reviews?->count() > 0)
        <div class="mt-6 bg-gray-50">
            <h3 class="mb-4 space-x-1">
                <span>
                    {{$snippets->communityReviews}}
                </span>
                <span>({{$discussion->community_reviews->count()}})</span>
            </h3>

            <div class="antialiased">
                <div class="space-y-4">
                    @foreach($discussion->community_reviews as $comment)
                        <div class="flex" x-data="comment('{{$comment->short_json}}')">
                            <div class="flex-shrink-0 mr-3">
                                <img class="w-8 h-8 rounded-sm sm:w-10 sm:h-10" src="{{$comment->gravatar}}" alt="Commenter gravatar">
                            </div>
                            <div class="flex-1 px-4 py-2 leading-relaxed border rounded-sm sm:px-6 sm:py-4">
                                <div class="flex flex-row items-center gap-1">
                                    <strong>{{$comment->name}}</strong>
                                    <x-public.stars :amount="$comment->rating->rating" :size="3" />
                                </div>

                                <div class="text-xs text-gray-400">
                                    {{$comment->created_at_formatted}}
                                </div>

                                <x-markdown>{{$comment->content}}</x-markdown>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="mt-6">

            <div class="flex flex-row items-center justify-start gap-2 p-2 border rounded-md hover:cursor-pointer hover:bg-gray-100" @click="show=!show">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    {{$snippets->rate}} {{$discussion->model->title}}'s  {{$discussion->title}}
                </div>
                <div class="ml-auto">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </div>
            </div>

            <div x-show="show">
                <div class="pt-16" id="discussion{{$discussion->title}}CommentForm{{$discussion->id}}">
                    <livewire:comment-form-component
                        context="review"
                        wire:key="commentForm{{$discussion->id}}"
                        :modelId="$discussion->id"
                        :model="$discussion"
                        :modelType="'App\Models\Discussion'"
                        :prompt="$discussion->comment_prompt ?? 'What is ' . $discussion->model->title . ' ' . $discussion->title . '?'" />
                </div>
            </div>
        </div>
    </div>
</div>
