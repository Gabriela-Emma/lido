@props([
    'posts',
    'theme' => null
])
<div class="flex-1 flex flex-col">
    <div
        class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-12 more-posts">
        @foreach($posts as $post)
            @if($theme ==  App\Enums\ComponentThemesEnum::plain)
                <div class="w-full pr-6 -mt-px -ml-px post">
                    <x-post.drip :post="$post" :showHero="true" />
                </div>
            @elseif($theme ==  App\Enums\ComponentThemesEnum::column)
                <div class="w-full xl:border-r xl:border-slate-600 pr-6 -mt-px -ml-px post">
                    <x-post.drip :post="$post" :showHero="true" />
                </div>
            @elseif($theme ==  App\Enums\ComponentThemesEnum::card)
                <div class="w-full pr-6 -mt-px -ml-px post">
                    <x-post.square :post="$post" :showHero="true" />
                </div>
            @endif
        @endforeach
    </div>
</div>
