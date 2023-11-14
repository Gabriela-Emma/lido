<div>
    <div class="flex flex-col justify-center col-span-1 px-8 py-8 text-center bg-phuffy2-500">
        <div class="text-3xl font-extrabold">
            {{$campaign?->metrics?->wallets?->participating ?? '-'}} / {{$eligibleWalletCount ?? '-'}}
        </div>
        <div class="text-sm">
            <span class="block">Participating / Eligible</span>
            <span class="block font-extrabold uppercase">Wallet</span>
        </div>
    </div>
</div>