@props([
    'fund',
])
<div
    class="flex flex-row items-start justify-center px-6 py-8 text-center rounded-sm bg-primary-10 xl:px-8 xl:text-left">
    <div class="flex flex-col items-start justify-between w-full space-y-6 xl:space-y-10">
        <a href="{{$fund->link}}"
           class="w-32 h-32 mx-auto rounded-full shadow-inner lg:w-32 lg:h-32 xl:w-44 xl:h-44">
            <img class="w-full h-full rounded-full"
                 src="{{$fund->thumbnail_url ?? $fund->gravatar}}"
                 alt="{{$fund->name}} logo"/>
        </a>
        <div class="items-end w-full space-y-2 xl:flex xl:items-center xl:justify-between">
            <div class="w-full space-y-1 text-lg font-medium leading-6">
                <h3 class="mb-2">
                    <a href="{{$fund->link}}"
                       class="text-gray-800 hover:text-teal-700">
                        {{$fund->label}}
                    </a>
                </h3>
                <div class="flex flex-row items-start justify-between w-full gap-2">
                    <div class="flex flex-col justify-center">
                        <span class="text-lg font-semibold text-gray-600">
                            {{$fund->formatted_amount}}
                        </span>
                        <span class="text-xs text-gray-500">Budget</span>
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="text-lg font-semibold text-gray-600">
                            {{humanNumber($fund->proposals_count)}}
                        </span>
                        <span class="text-xs text-gray-500">Proposals</span>
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="text-lg font-semibold text-gray-600">
                            {{humanNumber($fund->funded_proposals_count)}}
                        </span>
                        <span class="text-xs text-gray-500">Approved</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
