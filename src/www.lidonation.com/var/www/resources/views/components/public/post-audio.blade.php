@props([
    'post',
    'size' => 'xs',
    'src' => null
])
<div class="mix-blend-revert">
    @if($src ?? $post->getTranslation('content_audio', $locale, false))
        <iframe width="100%" height="20" scrolling="no" frameborder="no" allow="autoplay"
                src="{{$src ?? $post->audio}}"></iframe>
    @else
        <div class="text-md" onclick='Livewire.emit("openModal", "contribute-content.contribute-recording", {{ json_encode(["post" => $post->slug]) }})'>
            <div class="mb-0">
                Lend us your voice!
            </div>
            <div class="text-sm mb-2">
                Audio recordings make content accessible to more people
            </div>
            <a href="{{$post->recording_link}}" class="inline-flex flex-row gap-1 text-sm cursor-pointer items-center text-pink-600 font-semibold hover:text-teal-800 whitespace-nowrap px-1 py-0.5 bg-yellow-500 border border-yellow-800 rounded-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z" />
                </svg>
                <span>Record Article</span>
            </a>
        </div>
    @endif
</div>
