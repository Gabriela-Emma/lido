<div>
    @if(isset($taxonomy))
        <x-post.posts :theme="$theme" :posts="$posts ?? []"/>

        <livewire:components.more-posts-component :taxonomy='$taxonomy' :per-page="$perPage" :theme='$theme'/>
    @endif
</div>
