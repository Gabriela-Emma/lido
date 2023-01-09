@props([
    'proposal'
])
<div class="quick-pitch-wrapper">
    <div
        class="quick-pitch-video w-full"
        id="quick-pitch-{{$proposal->id}}"
        x-ref="quickPitch"
        data-plyr-provider="youtube"
        data-plyr-embed-id="{{$proposal->quick_pitch_id}}"></div>
    <div class="flex flex-col w-full justify-between gap-2 px-5 quick-pitch-text">
        <div>
            <h2>
                <a class="font-medium text-gray-800"
                   href="{{$proposal->link}}">
                    {{$proposal->title}}
                </a>
            </h2>
        </div>
        <div class="flex flex-row gap-3 flex-wrap items-center justify-between w-full mb-4">
            <div class="font-semibold">
                <span class="text-lg 2xl:text-xl">
                    {{ $proposal->formatted_amount_requested }}
                </span>
                <sub class="text-slate-400 block mt-0.5 italic">
                    Requested
                </sub>
            </div>
            <div class="flex flex-row items-center justify-between flex-nowrap gap-2" x-data="voterTool">
                <div
                    @click="up( {
                        id: {{$proposal->id}},
                        title: @js($proposal->title),
                        type: @js($proposal->type),
                        amount: {{$proposal->amount_requested}},
                        ideascale_link: '{{$proposal->ideascale_link}}',
                        link: '{{$proposal->link}}',
                        fundId: {{$proposal->fund->id}},
                        fundTitle: @js($proposal->fund->label),
                        fundAmount: {{$proposal->fund?->amount}},
                        proposalsCount: {{$proposal->fund?->proposals_count}},
                        fundHero: '{{$proposal->fund?->thumbnail_url}}',
                        labels: [@js($proposal->fund?->parent?->label) + ' Picklist']
                    } )"
                    class="hover:text-yellow-500 hover:cursor-pointer">
                    <svg x-show="has({{$proposal->id}}, 'upvote')" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 2xl:w-10 xl:h-10 upvoted" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                    </svg>
                    <svg x-show="!has({{$proposal->id}}, 'upvote')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 2xl:w-10 xl:h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                    </svg>
                </div>
                <div
                    @click="down( {
                        id: {{$proposal->id}},
                        title: @js($proposal->title),
                        type: @js($proposal->type),
                        amount: {{$proposal->amount_requested}},
                        ideascale_link: '{{$proposal->ideascale_link}}',
                        link: '{{$proposal->link}}',
                        fundId: {{$proposal->fund->id}},
                        fundTitle: @js($proposal->fund->label),
                        fundAmount: {{$proposal->fund?->amount}},
                        proposalsCount: {{$proposal->fund?->proposals_count}},
                        fundHero: '{{$proposal->fund?->thumbnail_url}}',
                        labels: [@js($proposal->fund?->parent?->label) + ' Picklist']
                    })"
                    class="hover:text-yellow-500 hover:cursor-pointer">
                    <svg x-show="has({{$proposal->id}}, 'downvote')" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 2xl:w-10 xl:h-10 downvoted" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z" />
                    </svg>
                    <svg x-show="!has({{$proposal->id}}, 'downvote')"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 2xl:w-10 xl:h-10 downvote">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 15h2.25m8.024-9.75c.011.05.028.1.052.148.591 1.2.924 2.55.924 3.977a8.96 8.96 0 01-.999 4.125m.023-8.25c-.076-.365.183-.75.575-.75h.908c.889 0 1.713.518 1.972 1.368.339 1.11.521 2.287.521 3.507 0 1.553-.295 3.036-.831 4.398C20.613 14.547 19.833 15 19 15h-1.053c-.472 0-.745-.556-.5-.96a8.95 8.95 0 00.303-.54m.023-8.25H16.48a4.5 4.5 0 01-1.423-.23l-3.114-1.04a4.5 4.5 0 00-1.423-.23H6.504c-.618 0-1.217.247-1.605.729A11.95 11.95 0 002.25 12c0 .434.023.863.068 1.285C2.427 14.306 3.346 15 4.372 15h3.126c.618 0 .991.724.725 1.282A7.471 7.471 0 007.5 19.5a2.25 2.25 0 002.25 2.25.75.75 0 00.75-.75v-.633c0-.573.11-1.14.322-1.672.304-.76.93-1.33 1.653-1.715a9.04 9.04 0 002.86-2.4c.498-.634 1.226-1.08 2.032-1.08h.384" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class='absolute right-0 -bottom-1 details-toggle-wrapper'>
        <button type="button"
                @click="closeQuickPitch()"
                class="inline-flex items-center px-5 py-3 border border-transparent shadow-sm shadow-inner text-sm leading-4 font-medium rounded-sm rounded-tl-[6rem] rounded-bl-[3rem] rounded-tr-[12rem] text-slate-600 bg-slate-200 hover:bg-slate-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-400">
            Details
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-3s h-3 ml-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>
            </svg>
        </button>
    </div>
</div>
