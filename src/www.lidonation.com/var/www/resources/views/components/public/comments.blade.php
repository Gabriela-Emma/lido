@props(['model', 'comments'])
<div class="antialiased">
    <div class="space-y-4">
        @foreach($comments ?? $model->comments as $comment)
        <div class="flex" x-data="comment('{{$comment->short_json}}')">
            <div class="flex-shrink-0 mr-3">
                <img class="w-8 h-8 rounded-sm sm:w-10 sm:h-10" src="{{$comment->gravatar}}" alt="Commenter gravatar">
            </div>
            <div class="flex-1 px-4 py-2 leading-relaxed rounded-sm border sm:px-6 sm:py-4">
                <strong>{{$comment->name}}</strong>
                <span class="text-xs text-gray-400">{{$comment->created_at_formatted}}</span>
                <a href="#articleCommentForm" class="inline-block ml-1 text-xs" @click="reply">
                    {{ $snippets->reply }}
                </a>

                <x-markdown>{{$comment->content}}</x-markdown>

                @if($comment->children?->isNotEmpty())
                <div class="flex items-center mt-4">
                    <div class="py-16 pt-8 max-w-5xl">
                        <x-public.comments :model="$model" :comments="$comment->children"></x-public.comments>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
