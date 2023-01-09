@props([
    'theme' => 'white',
    'title' => 'Staking with LIDO'
])
<div class="w-full p-6 bg-{{$theme}} rounded-sm 2xl:py-12 pool-id-picker">
    <strong class='block text-2xl leading-none'>{{$title}}</strong>
    <p class='text-base'>{{$snippets->whatWalletAreYouUsing}}</p>
    <div x-data="{wallet: 'daedalus'}">
        <div
            class="inline-flex flex-row flex-nowrap items-center p-3 my-3 w-full text-xs text-white uppercase rounded-tl-2xl rounded-br-2xl border 2xl:my-8 border-teal-700 bg-teal-600 leading-2 lg:leading-5 lg:text-sm xl:text-base wallet-picker">
            <span
                class="flex-1 px-2 py-1 text-center rounded-sm cursor-pointer text-md"
                @click="wallet = 'daedalus'"
                :class="{'wallet-picker-wallet-selected': wallet === 'daedalus'}"
            >Daedalus</span>
            <span
                class="flex-1 px-2 py-1 text-center rounded-sm cursor-pointer lg:mt-0 text-md"
                @click="wallet = 'other'"
                :class="{'wallet-picker-wallet-selected': wallet === 'other'}"
            >Yoroi & Others</span>
        </div>
        <div class='font-black'>
            <span class='text-xs text-gray-400 md:text-sm'>pool id </span>
            <span class='text-lg break-all cursor-text select-all md:text-xl xl:text-2xl'
                  x-show="wallet === 'daedalus'">pool1kks6sgxvx7p6fe3hhnne68xzwa9jg8qgy50yt3w3lrelvns7390</span>
            <span class='text-lg break-all cursor-text select-all md:text-xl xl:text-2xl' x-show="wallet === 'other'">b5a1a820cc3783a4e637bce79d1cc2774b241c08251e45c5d1f8f3f6</span>
        </div>
    </div>
</div>
