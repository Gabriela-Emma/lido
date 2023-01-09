<div
    wire:loading.attr="disabled"
    class="relative group p-2 w-full flex items-center justify-between rounded-sm border {{$post->status === 'pending' ? 'border-primary-500' : 'border-gray-300'}} shadow-sm text-left hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
    <div class="flex flex-1 items-center min-w-0">
        <div class="block flex-1 min-w-0">
            <div class="block font-medium text-gray-900 truncate text-md">{{$post?->title}}</div>
            @if($post->status === 'ready')
                <div class="text-sm font-semibold text-teal-600">
                    {{$snippets->publishingSoon}}
                </div>
            @endif
            @if($post->status !== 'ready')
                <div class="flex gap-3 text-sm truncate">
                    @if(!$voted)
                        <a class="font-semibold" href="#" wire:click.prevent="upVote">
                            {{$snippets->upvote}}
                        </a>
                    @else
                        <span class="font-medium text-gray-500">
                            {{$snippets->thanksForVoting}}
                        </span>
                    @endif
                    @if($post->status === 'pending')
                        <a class="font-semibold" href="#"
                           onclick='Livewire.emit("openModal", "contribute-content.contribute-article", {{ json_encode(["postId" => $post->id]) }})'
                           wire:click.prevent>
                           {{$snippets->claim}}
                        </a>
                    @else
                        <span class="font-medium text-gray-500">
                            {{$snippets->claimed}}
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>
    <div
        class="inline-flex flex-col flex-shrink-0 justify-center items-center w-10 h-10 text-sm text-gray-400 hover:text-teal-600 hover:cursor-pointer">
        <span>{{$votes}}</span>
        <span class="block text-gray-300">
            {{$snippets->votes}}
        </span>
    </div>
    <div wire:loading class="absolute top-0 left-0 ml-0 w-full h-full bg-white opacity-75">
        <div class="flex justify-end items-center w-full h-full opacity-100 text-teal-600">
            <svg class="mr-3 w-5 h-5 animate-spin" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
</div>
