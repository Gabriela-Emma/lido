<div>
    @if(isset($taxonomy))
        <div class="flex flex-col py-4">
            <span class='font-semibold text-sm text-slate-700'>{{ (new ReflectionClass($taxonomy))->getShortName()  }}</span>
            <span class='font-semibold text-teal-600 text-xl xl:text-4xl'>{{ $taxonomy->title }}</span>
        </div>

        <x-post.posts :theme="$theme" :posts="$posts ?? []"/>

        <livewire:components.more-posts-component :taxonomy='$taxonomy' :per-page="$perPage" :theme='$theme'/>
    @endif
</div>
