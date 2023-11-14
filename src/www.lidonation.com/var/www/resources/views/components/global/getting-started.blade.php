<div class>
    <h2 class="mb-6 text-5xl text-gray-900 decorate dark">
               <span class="">
                   {{$snippets->getting}}
               </span>
        <span class="text-teal-600 opacity-90">
                  {{$snippets->started}}
               </span>
    </h2>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="flex flex-row justify-between h-full col-span-2 gap-4 lg:col-span-1 lg:flex-col lg:gap-8">
            <div class="border-b border-gray-600 min-w-1/2">
                <div class="mb-3 bg-gray-900">
                    <a wire:navigate.hover href="{{localizeRoute('what-is-cardano')}}">
                        <img class="filter hover:contrast-200"
                             src="https://www.lidonation.com/storage/340/responsive-images/what-is-cardano-future-boy___large_2048_2048.jpg"
                             alt="What is Cardano"/>
                    </a>
                </div>
                <a wire:navigate.hover href="{{localizeRoute('what-is-cardano')}}"
                   class="block mb-4 text-2xl text-gray-700 2xl:text-3xl">
                    {{$snippets->whatIsCardano}}
                </a>
            </div>
            <div class="border-b border-gray-600 min-w-1/2">
                <div class="mb-3 bg-gray-900">
                    <a wire:navigate.hover href="{{localizeRoute('what-is-staking')}}">
                        <img class="filter hover:contrast-200"
                             src="https://www.lidonation.com/storage/435/responsive-images/what-is-the-point-of-buying-ada-and-staking-in-cardano-hero-image___large_2048_2048.jpg"
                             alt="What is Cardano">
                    </a>
                </div>
                <a wire:navigate.hover href="{{localizeRoute('what-is-staking')}}"
                   class="block mb-4 text-2xl text-gray-700 2xl:text-3xl">
                    {{ $snippets->whatIsStaking }}
                </a>
            </div>
        </div>
        <div class="col-span-2 border-b border-gray-600">
            <div class="mb-3 bg-gray-900">
                <a href="//www.lidonation.com/posts/lido-nation-getting-in-the-middle-of-it">
                    <img class="filter hover:contrast-200"
                         src="https://www.lidonation.com/storage/535/responsive-images/Lido-Getting-In-The_Middle-Of-It___large_2048_2048.jpg"
                         alt="What is Cardano">
                </a>
            </div>
            <a href="//www.lidonation.com/posts/lido-nation-getting-in-the-middle-of-it"
               class="block mb-4 text-2xl text-gray-700 2xl:text-3xl">
                LIDO Nation - Getting in the middle of it
            </a>
        </div>
        <div class="flex flex-row justify-between h-full col-span-2 gap-4 lg:col-span-1 lg:flex-col lg:gap-8">
            <div class="border-b border-gray-600">
                <div class="mb-3 bg-gray-900">
                    <a wire:navigate.hover href="{{localizeRoute('how-to-buy-ada')}}">
                        <img class="filter hover:contrast-200"
                             src="https://www.lidonation.com/storage/432/responsive-images/how-to-buy-cardano-ada-hero-image___large_2048_2048.jpg"
                             alt="How to buy ada">
                    </a>
                </div>
                <a wire:navigate.hover href="{{localizeRoute('how-to-buy-ada')}}"
                   class="block mb-4 text-2xl text-gray-700 2xl:text-3xl">
                    {{ $snippets->howToBuyADA }}
                </a>
            </div>
            <div class="border-b border-gray-600">
                <div class="mb-3 bg-gray-900">
                    <a  wire:navigate.hoverhref="{{localizeRoute('how-to-stake-ada')}}">
                        <img class="filter hover:contrast-200"
                             src="https://www.lidonation.com/storage/433/responsive-images/how-to-stake-your-ada-hero-image___large_2048_2048.jpg"
                             alt="How to stake your ada">
                    </a>
                </div>
                <a wire:navigate.hover href="{{localizeRoute('how-to-stake-ada')}}"
                   class="block mb-4 text-2xl text-gray-700 2xl:text-3xl">
                    {{ $snippets->howToStakeYourADA }}
                </a>
            </div>
        </div>
    </div>
</div>
