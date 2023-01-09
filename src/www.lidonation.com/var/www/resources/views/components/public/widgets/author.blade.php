@props([
    'author',
    'editor' => null,
])
@if($author)
    <div class="border border-gray-600">
        <div class="border-t-4 border-gray-600 -mt-px p-6 flex flex-row gap-4 items-start">
            <div class="flex flex-col gap-3 flex-shrink-0 w-16">
                @if($author->bio_pic)
                    <img class="h-16 w-16 rounded-full block" srcset="{{$author->bio_pic?->getSrcset('thumbnail')}}"/>
                @else
                    <img class="h-16 w-16 rounded-full"
                         src="{{$author->gravatar}}"
                         title="{{$author->name}}"
                         alt="{{$author->name}} Bio Pic" />
                @endif
                @if($author->social_links?->isNotEmpty())
                <ul class="flex gap-2 justify-center">
                    @foreach($author->social_links as $network => $link)
                        <li class="h-6 w-6">
                            <a class="block text-gray-600" href="{{$link}}" target="_blank">
                                @include("svg.$network")
                            </a>
                        </li>
                    @endforeach
                </ul>
                @endif
            </div>
            <div>
                <h2 class="">
                    {{$author->name}}
                </h2>
                <div class="text-base 2xl:text-lg">
                    <x-markdown>{{$author->short_bio}}</x-markdown>
                </div>
            </div>
        </div>
        @if($editor)
            <div class="border-t p-6">
                <div class="text-gray-400 mb-2">Edited By</div>
                <div class="flex flex-row xl:flex-nowrap gap-2 items-start">
                    @if($editor->bio_pic)
                        <img class="h-8 w-8 rounded-full block" srcset="{{$editor->bio_pic?->getSrcset('thumbnail')}}"/>
                    @else
                        <img class="h-8 w-8 rounded-full"
                             src="{{$editor->gravatar}}"
                             title="{{$editor->name}}"
                             alt="{{$editor->name}} Bio Pic" />
                    @endif
                    <h3 class="">
                        {{$editor->name}}
                    </h3>
                </div>
            </div>
        @endif
    </div>
@endif
