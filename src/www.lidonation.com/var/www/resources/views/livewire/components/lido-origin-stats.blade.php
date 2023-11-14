<div class="gap-6 md:grid md:grid-cols-2 2xl:grid-cols-5 lido-origin">
    <div
        class="rounded-sm bg-gradient-to-tl from-primary-10 to-primary-20 via-primary30 via-slate-50 text-slate-800 w-full p-8 2xl:col-span-3">
        <h2 class="md:text-4xl xl:text-5xl">
            Lido Nation: Origin Story
        </h2>
        <p class="md:text-xl xl:text-2xl leading-loose tracking-wide">
            The Lido Nation staking pool launched on the Cardano mainnet in December 2020. From there, a
            couple of dreamers started to talk about what our little corner of the network should look
            like.
            As a pair of curious birds, who get excited about learning and sharing knowledge, we noticed
            that there wasn’t enough of the kind of material we wanted to read about blockchain, and
            Cardano.
        </p>
        <b class="font-title font-bold text-3xl mt-2 xl:mt-4 block">So we started to write it!</b>
    </div>
    <div
        class="rounded-sm bg-gradient-to-bl from-{{$theme}}-700 via-{{$theme}}-600 to-{{$theme}}-500 w-full p-2 md:p-8 2xl:col-span-2">
        <div class="flex flex-row flex-wrap text-slate-50 font-bold justify-around">
            <!-- Analytics -->
            <div class="p-2">
                <div
                    class="flex justify-center p-3 rounded-full border border-{{$theme}}-500 w-32 h-32 bg-{{$theme}}-700 shadow-inner shadow-lg">
                    <div class="inline-flex flex-col items-center justify-center">
                        <div class="text-4xl inline-block font-bold">
                            <x-public.animated-number :number="$newsArticles"
                                                      :time="1000"></x-public.animated-number>
                        </div>
                        <div class="text-xs inline-block text-center">
                            News Articles
                        </div>
                    </div>
                </div>
            </div>
            <!-- Analytics -->
            <div class="p-2">
                <div
                    class="flex justify-center p-3 rounded-full border border-{{$theme}}-500 w-32 h-32 bg-{{$theme}}-700 shadow-inner shadow-lg">
                    <div class="inline-flex flex-col items-center justify-center">
                        <div class="text-4xl inline-block font-bold">
                            <x-public.animated-number :number="$educationalArticles"
                                                      :time="900"></x-public.animated-number>
                        </div>
                        <div class="text-xs inline-block text-center">
                            Educational Articles
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics -->
            <div class="p-2">
                <div
                    class="flex justify-center p-3 rounded-full border border-{{$theme}}-500 w-32 h-32 bg-{{$theme}}-700 shadow-inner shadow-lg">
                    <div class="inline-flex flex-col items-center justify-center">
                        <div class="text-4xl inline-block font-bold">
                            <x-public.animated-number :number="$minutesOfAudioReadings"
                                                      :time="2200"></x-public.animated-number>
                        </div>
                        <div class="text-xs inline-block text-center">
                            Minutes of audio readings
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics -->
            <div class="p-2">
                <div
                    class="flex justify-center p-3 rounded-full border border-{{$theme}}-500 w-32 h-32 bg-{{$theme}}-700 shadow-inner shadow-lg">
                    <div class="inline-flex flex-col items-center justify-center">
                        <div class="text-5xl inline-block font-bold">
                            <x-public.animated-number :number="$hrsOfTwitterSpacesWork"
                                                      :time="4000"></x-public.animated-number>
                        </div>
                        <div class="text-sm inline-block text-center">
                            Hrs of twitter spaces/wk
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics -->
            <div class="p-2" wire:poll.60s.visible="get30DaysPageViews">
                <div
                    class="flex justify-center p-3 rounded-full border border-{{$theme}}-500 w-32 h-32 bg-{{$theme}}-700 shadow-inner shadow-lg">
                    <div class="inline-flex flex-col items-center justify-center">
                        <div class="text-3xl inline-block font-bold">
                            <x-public.animated-number :number="$thirtyDaysPageViews"
                                                      :time="2000"></x-public.animated-number>
                        </div>
                        <div class="text-sm inline-block text-center">
                            30-day Page Views
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics -->
            <div class="p-2" wire:poll.60s.visible="get30DaysCatalystQueries">
                <div
                    class="flex justify-center p-3 rounded-full border border-{{$theme}}-500 w-32 h-32 bg-{{$theme}}-700 shadow-inner shadow-lg">
                    <div class="inline-flex flex-col items-center justify-center">
                        <div class="text-3xl inline-block font-bold">
                            <x-public.animated-number :number="$thirtyDaysCatalystQueries"
                                                      :time="3000"></x-public.animated-number>
                        </div>
                        <div class="text-sm inline-block text-center">
                            30-day Catalyst Queries
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
