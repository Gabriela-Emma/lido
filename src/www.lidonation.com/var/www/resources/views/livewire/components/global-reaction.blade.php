<div class="py-6 border-t border-slate-300">
    <ul class="flex flex-row flex-wrap gap-4 justify-center">
        @foreach ( $reactions as $reaction)
            <li
                class="border flex flex-row gap-2 border-slate-600 hover:border-green-500 p-2 rounded-sm text-lg">
                <button class="flex gap-1" wire:click="addReaction('{{ $reaction['label'] }}', {{ $post->id }})">
                    <span>{{ $reaction['label'] }}</span>
                    <span>{{ $reaction['count'] }}</span>
                </button>
            </li>
        @endforeach
    </ul>
</div>
