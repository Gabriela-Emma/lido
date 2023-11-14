<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div>
        <button type="button" wire:click="togglePodcast" class="inline-flex items-center px-2 py-0.5 ml-0.5 capitalize text-white hover:text-slate-600 rounded-sm text-xs font-semibold bg-post-type-news text-slight-50 border border-post-type-news">
            podcast
        </button>
        <x-podcast.drip :podcast="$latestLidoMinute" />
    </div>

</div>
