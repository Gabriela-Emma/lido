@props([
    'report',
    'view' => 'detail'
])
<div class="p-5 w-full bg-white rounded-sm relative flex flex-col justify-start bg-white shadow-sm mb-4 relative break-inside-avoid drip">
    <div class="break-long-words break-words">
        <x-markdown>{{$report->content}}</p></x-markdown>
    </div>

    <div class="mt-16 divide-y divide-teal-300 border-t border-teal-300 specs">
        <div class="flex flex-row gap-4 justify-between items-center py-4 spec-amount-received">
            <div class="text-teal-800 opacity-50 text-sm">Disbursed to Date</div>
            <div class="text-teal-800 font-bold text-base">
                {{$report?->proposal?->formatted_amount_received}}
            </div>
        </div>

        <div class="flex flex-row gap-4 justify-between items-center py-4 spec-title">
            <div class="text-teal-800 opacity-50 text-sm">Proposal</div>
            <a class="text-teal-800 font-medium inline-flex text-base hover:text-yellow-500" target="_blank" href="{{$report?->proposal?->link}}">
                {{$report?->proposal?->title}}
            </a>
        </div>
        <div class="flex flex-row gap-4 justify-between items-center py-4">
            <div class="text-teal-800 opacity-50 text-sm">Status</div>
            <div class="text-teal-800 font-medium text-base">
                {{$report->project_status ?? '-'}}
            </div>
        </div>
        <div class="flex flex-row gap-4 justify-between items-center py-4">
            <div class="text-teal-800 opacity-50 text-sm">
                Completion Target
            </div>
            <div class="text-teal-800 font-medium text-base">
                {{$report->completion_target ?? '-'}}
            </div>
        </div>
        @if($report->attachments->isNotEmpty())
            <div class="flex flex-row gap-4 justify-between items-center py-4">
                <div class="text-teal-800 opacity-50 text-sm">Attachment(s)</div>
                <div class="text-teal-800 font-medium text-right text-base">
                    @foreach($report->attachments as $attachment)
                        <a target="_blank" class="font-medium hover:text-yellow-500 px-1 py-0.5 border border-teal-600 rounded-sm text-xs inline-flex flex-row flex-nowrap gap-2 hover:bg-teal-600" href="{{$attachment}}">
                            <span class="inline-flex">Evidence {{$loop->iteration}}</span>
                            <span class="inline-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

{{--    <div x-data="catalystReportComments" class="w-full mx-auto bg-slate-100 px-4">--}}
{{--        <div class="flex justify-between items-center py-4">--}}
{{--            <div class="text-teal-800 opacity-75 text-sm inline-flex gap-2 items-center h-full">--}}
{{--                <span class="bold text-xl">Comments</span>--}}
{{--                <span>4</span>--}}
{{--            </div>--}}

{{--            <button id="message-type" name="message-type"--}}
{{--                    x-on:click="toggleShowComments(4138)" x-html="showComments ? '-' :'+' "--}}
{{--                    class="text-2xl font-medium text-teal-800 hover:text-yellow-600">--}}
{{--            </button>--}}
{{--        </div>--}}

{{--        <div x-cloak x-show="showComments" class="border-t border-slate-400 border-dashed pb-4">--}}
{{--            <ul x-if="comments">--}}
{{--                <template x-for="(comment, index) in comments" x-cloak class="boarder-b-2 ">--}}
{{--                    <li x-text="index"></li>--}}
{{--                </template>--}}
{{--            </ul>--}}
{{--            <p class="py-4" x-if="!comments">--}}
{{--                Be the first to leave a comment!--}}
{{--            </p>--}}
{{--            <div class="border-t border-slate-400 border-dashed pt-2">--}}
{{--                <div class="mb-2">--}}
{{--                    <label for="name" class="block text-sm font-medium text-slate-600">Name </label>--}}
{{--                    <div class="mt-1">--}}
{{--                        <input  id="name" name="name" type="text" autocomplete="name" required--}}
{{--                                class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="mb-2">--}}
{{--                    <label for="email" class="block text-sm font-medium text-slate-600">Email </label>--}}
{{--                    <div class="mt-1">--}}
{{--                        <input  id="email" name="email" type="email" autocomplete="email" required--}}
{{--                                class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <textarea class="border-slate-200" type="text" row="3" placeholder="Give feedback or ask team a question." required--}}
{{--                          x-model="newComment"></textarea>--}}

{{--                <button class="text-white text-xs px-2 bg-teal-300 hover:bg-teal-800 ml-auto"--}}
{{--                        x-on:click="addComment">Post--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
