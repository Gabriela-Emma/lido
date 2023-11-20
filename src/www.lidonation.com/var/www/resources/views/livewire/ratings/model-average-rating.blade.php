<span class="flex flex-row gap-2 items-center ">
    <span class="block">
        {{$averageRatingFormatted}}
    </span>
    <span class="block">
        <x-public.stars theme="text-{{$theme}}-500" :amount="$averageRating" :size="$size"/>
    </span>
    <span class="block">
        ({{$ratingsCount}})
    </span>
</span>
