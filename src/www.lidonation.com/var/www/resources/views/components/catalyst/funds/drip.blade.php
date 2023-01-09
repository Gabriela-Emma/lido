@props([
    'fund',
])
<div
    class="py-8 px-6 bg-primary-10 text-center rounded-sm flex flex-row justify-center items-start xl:px-8 xl:text-left">
    <div class="space-y-6 flex flex-col justify-between items-start w-full xl:space-y-10">
        <a href="{{$fund->link}}"
           class="w-32 h-32 lg:w-32 lg:h-32 xl:w-44 xl:h-44 rounded-full mx-auto shadow-inner shadow-md">
            <img class="rounded-full w-full h-full"
                 src="{{$fund->thumbnail_url ?? $fund->gravatar}}"
                 alt="{{$fund->name}} logo"/>
        </a>
        <div class="space-y-2 w-full xl:flex xl:items-center xl:justify-between items-end">
            <div class="font-medium text-lg leading-6 space-y-1 w-full">
                <h3 class="mb-2">
                    <a href="{{$fund->link}}"
                       class="text-gray-800 hover:text-teal-700">
                        {{$fund->label}}
                    </a>
                </h3>
                <div class="flex flex-row justify-between items-start gap-2 w-full">
                    <div class="flex flex-col gap2 itemscenter justify-center">
                        <span class="text-gray-600 font-semibold text-lg">
                            {{$fund->formatted_amount}}
                        </span>
                        <span class="text-gray-500 text-xs">Budget</span>
                    </div>
                    <div class="flex flex-col gap2 itemscenter justify-center">
                        <span class="text-gray-600 font-semibold text-lg">
                            {{humanNumber($fund->proposals_count)}}
                        </span>
                        <span class="text-gray-500 text-xs">Proposals</span>
                    </div>
                    <div class="flex flex-col gap2 itemscenter justify-center">
                        <span class="text-gray-600 font-semibold text-lg">
                            {{humanNumber($fund->funded_proposals_count)}}
                        </span>
                        <span class="text-gray-500 text-xs">Approved</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
