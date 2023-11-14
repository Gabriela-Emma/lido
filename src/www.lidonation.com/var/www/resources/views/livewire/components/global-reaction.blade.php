<div>
    <div x-data="globalReactions({{ json_decode($post->reationCounts) }})" class="py-6 border-t border-slate-300">
        <ul class="flex flex-row flex-wrap gap-4 justify-center">
            <template x-for="[reaction, count] of Object.entries(reactionsCount)">
                <li @click.prevent="addReaction(reaction, {{ $post->id }})"
                    class="border flex flex-row gap-2 border-slate-600 hover:border-green-500 p-2 rounded-sm text-lg cursor-pointer">
                    <button x-text="reaction"></button>
                    <span x-text="count"></span>
                </li>
            </template>
        </ul>
    </div>
</div>


