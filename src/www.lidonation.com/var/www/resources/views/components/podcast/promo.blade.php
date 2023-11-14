@props([
    'promo',
    'post' => null,
])
<div href="{{$promo->uri}}" target="_blank">
    <a href="{{$promo->uri}}" target="_blank" title="{{$promo->content}}">
        <img src="{{$promo?->feature_url}}" alt="{{$promo->title}}'s promo" title="{{$promo->content}}">
    </a>
{{--    <div--}}
{{--        class="absolute left-0 bottom-0 flex gap-2 items-center text-yellow-500 bg-gradient-to-t from-slate-800 h-auto w-full p-2.5 sm:p-2">--}}
{{--        <span class="flex w-full">--}}
{{--            <a href="{{$promo->uri}}" target="_blank" class="w-3/4 text-white hover:text-yellow-500">--}}
{{--                <span class="flex gap-3 items-center">--}}
{{--                    <span class="font-medium  text-lg xl:text-xl 2xl:text-2xl">--}}
{{--                        {{$promo->title}}--}}
{{--                    </span>--}}

{{--                    <span class="inline-flex items-center px-1 py-0.5 capitalize h-5 text-slate-700 hover:text-yellow-900 rounded-sm text-xs font-semibold bg-yellow-500 border border-yellow-500">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">--}}
{{--                          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />--}}
{{--                        </svg>--}}
{{--                        <span class="inline-block text-xs ml-1 leading-3">Info</span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--                <span class="text-slate-100 block text-sm">--}}
{{--                    {{$promo->content}}--}}
{{--                </span>--}}
{{--            </a>--}}

{{--            @if($post)--}}
{{--                @include('podcast.actions')--}}
{{--            @endif--}}
{{--        </span>--}}
{{--    </div>--}}
</div>
