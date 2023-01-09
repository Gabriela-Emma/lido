@props([
    'cause',
    'view' => 'expanded'
])
<div class="rounded-sm overflow-hidden lg:grid lg:grid-cols-6 lg:gap-4">
    <div class="pt-10 pb-12 sm:pt-16 lg:py-10 lg:pr-0 col-span-3">
        <div class="lg:self-center">
            <h2 class="text-2xl font-semibold">
                <span class="block">
                    {{$cause->title}}
                </span>
            </h2>
            @if($view === 'expanded')
                <div class="my-4 text-lg leading-6 max-w-2xl">
                    <x-markdown>{{$cause->content}}</x-markdown>
                </div>
            @endif

            @if($view === 'expanded')
                @if($cause->links)
                    <x-public.links :links="$cause->links"/>
                @endif
            @endif
        </div>
    </div>

    <div class="h-full flex flex-col justify-center items-center gap-4">
        <div
            class="{{ intval($user?->meta?->phuffy_balance) > 0 ? 'bg-primary-600 hover:bg-teal-600' : 'bg-gray-600' }}  text-white rounded-full h-32 w-32 flex flex-col items-center justify-center">
            <div class="font-semibold text-3xl">Vote</div>
            <div class="text-sm">for this cause</div>
        </div>
        <div class="text-gray-700 text-center">
            <span class="text-sm">On Dec 1</span>
            {{--                                    400 Phuffy <br/>--}}
            {{--                                    <span class="text-sm relative -top-2">received</span>--}}
        </div>
    </div>

    <div class="-mt-6 aspect-w-5 aspect-h-3 md:aspect-w-2 md:aspect-h-1 col-span-2">
        <img
            class="rounded-tl-[8rem] rounded-tr-[1rem] transform translate-x-6 translate-y-6 rounded-md object-cover object-center sm:translate-x-16 lg:translate-y-20"
            src="{{$cause->hero?->getUrl()}}"
            alt="{{$cause->title}} hero">
    </div>
</div>
