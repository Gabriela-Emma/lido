<style>
    html,
    body {
        height: auto;
        color: white;
    }

    footer, #header, #mobile-menu, #top-blob, .global-banner, .global-search-wrapper, #global-video-player-wrapper {
        display: none !important;
    }
</style>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://www.lidonation.com/css/app.css">
        <title>{{$proposal->title}} summary card</title>
    </head>
    <body class="proposal bg-gradient-to-br from-primary-800 via-primary-600 to-accent-900 h-screen">
        <main class="">
            <x-catalyst.proposals.social-card :proposal="$proposal"/>

            @if($proposal->users)
                <div class="p-4 mb-6 rounded-sm flex flex-col justify-center text-center">
                    <h2 class="mb-6">
                        {{ $snippets->team}}
                    </h2>
                    <div>
                        @if($proposal->users->isNotEmpty())
                            <ul class="flex flex-wrap justify-center gap-5">
                                @foreach($proposal->users as $catalystUser)
                                    <li wire:key="{{$catalystUser->id}}">
                                        <div class="flex flex-col items-center gap-4">
                                            <img
                                                class="w-20 h-20 mx-auto rounded-full lg:w-24 lg:h-24"
                                                src="{{$catalystUser->thumbnail_url ?? $catalystUser->bio_pic?->getUrl('thumbnail') ?? $catalystUser->gravatar}}"
                                                alt="{{$catalystUser->name}} bio pic">
                                            <div class="max-w-[8rem] text-sm font-medium text-center lg:text-xs">
                                                <span class="block font-bold text-teal-600"
                                                   href="{{$catalystUser->link}}">
                                                    {{$catalystUser->name}}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif
        </main>
        <script src="{{ mix('js/app.js') }}" defer></script>
    </body>
</html>
