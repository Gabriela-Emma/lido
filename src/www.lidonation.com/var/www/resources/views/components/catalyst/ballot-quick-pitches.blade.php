@props([
    'proposals' => null,
])
<div id="ballot-quick-pitches" class="py-8">
    <h2 class="lg:text-2xl xl:text-3xl 2xl:text-4xl font-semibold decorate light mb-4">
        <span>Catalyst Proposal Quick Pitches</span>
        <a  href="{{localizeRoute('projectCatalyst.voterTool')}}" type="button"
              class="inline-flex items-center ml-auto relative -top-1 rounded-sm border border-transparent bg-accent-700 px-2 py-1 text-xs font-medium text-white shadow-sm hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            View Ballot
            <svg class="ml-2 -mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
            </svg>

        </a>
    </h2>
    <p class="font-medium max-w-2xl text-base mb-4">
        Fund 9 ballot opens Sept 5. Here are some quick pitches of proposals on the ballot!
    </p>
    @if($proposals)
        <div class="grid grid-cols-2 xl:grid-cols-4 auto-rows-fr gap-5">
            @foreach($proposals as $p)
                <div
                    x-data="proposalDrip" data-view="pitch" data-proposal='@json($p->toJs())' x-ref="proposalDrip"
                    class="pitch">
                    <x-catalyst.proposals.quickpitch :proposal="$p" />
                </div>
{{--                @if ($loop->iteration === 1)--}}
{{--                x-data="proposalDrip" data-view="pitch" data-proposal='@json($p->toJs())' x-ref="proposalDrip" --}}
{{--                    --}}
{{--                @elseif(!$loop->first && $loop->iteration <= 4)--}}
{{--                    <div x-data="proposalDrip" data-view="pitch" data-proposal='@json($p->toJs())' x-ref="proposalDrip"--}}
{{--                         class="pitch col-span-2 row-span-4">--}}
{{--                        <x-catalyst.proposals.quickpitch :proposal="$p" />--}}
{{--                    </div>--}}
{{--                @else--}}
{{--                    <div x-data="proposalDrip" data-view="pitch" data-proposal='@json($p->toJs())' x-ref="proposalDrip"--}}
{{--                         class="pitch col-span-1 row-span-9">--}}
{{--                        <x-catalyst.proposals.quickpitch :proposal="$p" />--}}
{{--                    </div>--}}
{{--                @endif--}}
            @endforeach
        </div>
    @endif
</div>
