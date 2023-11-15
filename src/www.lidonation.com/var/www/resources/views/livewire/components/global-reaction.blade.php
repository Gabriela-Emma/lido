<div>
    <div x-data='globalReactions({{ json_encode($post->reactionsCounts) }})'>
        <div class="py-6 border-t border-slate-300">
            <ul class="flex flex-row flex-wrap gap-4 justify-center">
                @foreach ($post->reactionsCounts as $reaction => $count)
                    <li @click.prevent="addReaction('{{ $reaction }}', {{ $post->id }})"
                        class="border flex flex-row gap-2 border-slate-600 hover:border-green-500 p-2 rounded-sm text-lg">
                        <button x-text="'{{ $reaction }}'"></button>
                        <span x-text="{{ $count }}"></span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
