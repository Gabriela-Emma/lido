@props([
    'causes' => $causes,
    'votes' => $votes
])
<div>
    <ul role="list" class="divide-y divide-gray-200">
        @foreach($causes as $cause)
            <li class="cause">
                <div class="flex items-center px-4 py-4 sm:px-6">
                    <div class="flex-1 min-w-0 sm:flex sm:items-center sm:justify-between">
                        <div class="truncate">
                            <div class="flex text-xl">
                                <p class="truncate text-teal-600 title">
                                    {{$cause->title}}

                                    <span class="flex-shrink-0 ml-1 text-lg font-semibold text-pink-500 votes">
                                        {{-- 22,000,000 Phuffy --}}
                                    </span>
                                </p>
                            </div>
                            <div class="flex mt-2">
                                <div class="flex items-center text-sm text-gray-500 added">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                    <p class="">
                                        Added
                                        <time datetime="{{$cause->created_at}}">{{$cause->created_at}}</time>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0 mt-4 sm:mt-0 sm:ml-5">
                            <div class="flex -space-x-1 overflow-hidden">

                            </div>
                        </div>
                    </div>
                    @if ($votes?->filter(fn($v) => !$v->submitted)->pluck('cause_id')->contains($cause->id))
                        <a href="{{route('phuffy-vote', ['causeId' => $cause->id, 'voteId' => $votes->firstWhere('cause_id', $cause->id)->id])}}"
                            class="flex flex-row items-center flex-shrink-0 gap-1 ml-5 hover:text-pink-500">
                            <span>Complete Vote</span>
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"/>
                            </svg>
                        </a>
                    @else
                        @if(!!$user && !$user?->has_lido_nft)
                            <span class="flex flex-col items-center justify-center gap-2 text-gray-600" title="Must be a LIDO delegate and registered to vote">
                                <span>Vote</span>
                                <span class="w-24 text-xs text-gray-200">
                                    Must be a LIDO delegate and registered to vote
                                </span>
                            </span>
                        @else
                            <a href="{{route('phuffy-vote', ['causeId' => $cause->id])}}"
                                class="flex flex-row items-center flex-shrink-0 gap-1 ml-5 hover:text-pink-500">
                                <span>Vote</span>
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"/>
                                </svg>
                            </a>
                        @endif
                    @endif
                </div>
                <div class="max-w-2xl px-6 mb-6 text-lg leading-6">
                    <x-markdown>{{$cause->summary}}</x-markdown>
                </div>
            </li>
        @endforeach
    </ul>
</div>
